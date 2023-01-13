<?php

namespace App\Http\Controllers\Backend\Sell\Delivery;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Backend\Sell\SellInvoice;
use App\Models\Backend\Sell\SellProduct;
use App\Models\Backend\Sell\SellProductStock;
use App\Models\Backend\SellDelivery\SellProductDelivery;
use App\Models\Backend\SellDelivery\SellProductDeliveryInvoice;
use App\Traits\Backend\Stock\Logical\StockChangingTrait;
use App\Traits\Backend\Sell\Logical\UpdateSellSummaryCalculationTrait;

class SellProductDeliveryController extends Controller
{
    use StockChangingTrait, UpdateSellSummaryCalculationTrait;

    protected $sellDeliveryQuantity;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['data']  =  SellInvoice::where('id',$request->id)->first();
        $html = view('backend.sell.delivery.index',$data)->render();
        $product = view('backend.sell.delivery.product_only',$data)->render();
        return response()->json([
            'status' => true,
            'html' => $html,
            'product' => $product
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            if((isset($request->checked_id)) && (count($request->checked_id) > 0))
            {
                $rand = rand(01,99);
                $makeInvoice = date("iHsymd").$rand;
                
                $invoiceData  =  SellInvoice::where('id',$request->sell_invoice_id)->first();
                $invoiceData->total_delivered_count = (($invoiceData->total_delivered_count) + 1);
                $invoiceData->save();

                $sellDelivery = $this->sellProductDeliveryInvoiceStore($makeInvoice,$invoiceData);

                foreach($request->checked_id as $sell_product_stock_id)
                {
                    $this->sellProductStockProcessing($sellDelivery,$invoiceData, $sell_product_stock_id, $request->input('deliverying_qty_'.$sell_product_stock_id));
                }

                //update sell delivery invoice
                $sellDelivery->quantity = $this->sellDeliveryQuantity;
                $sellDelivery->save();

                //module = SellProduct, moduleTypeId = 1
                $this->sellModuleWiseUpdateDbField($moduleTypeId = 1, $primaryId = $request->sell_invoice_id);

                DB::commit();
            }else{
                return response()->json([
                    'status'    => false,
                    'message'   => "Please, checked minimum quantity of a item for delivery",
                    'type'      => 'error'
                ]);
            }
            $data['data']  = SellInvoice::where('id',$request->sell_invoice_id)->first();
           
            $product = view('backend.sell.delivery.product_only',$data)->render();
            $printRoute = route('admin.sell.product.delivery.print.product.delivered.invoice.wise.delivered.list',$makeInvoice);
            $printRouteHtml = '<a href="'.$printRoute.'" class="print" target="_blank">Print</a>';
            return response()->json([
                'status'    => true,
                'product' => $product,
                'print' => $printRouteHtml,
                'message'   => "Delivery submited successfully!",
                'type'      => 'success'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
            return response()->json([
                'status'    => false,
                'message'   => "Something went wrong fasedfdfa",
                'type'      => 'error'
            ]);
        }
    }

    //sell product stock
    private function sellProductStockProcessing($sellDelivery,$invoiceData,$sell_product_stock_id, $deliverying_quantity)
    {
        $sellProductStockDetails = SellProductStock::where('id',$sell_product_stock_id)
                ->select('id','sell_product_id','product_id','stock_id','product_stock_id','total_quantity',
                   'reduceable_delivered_qty','reduced_base_stock_remaining_delivery','delivered_total_qty','remaining_delivery_qty','total_delivered_qty',
                )
                ->first();

        $sellProduct =  SellProduct::select('id','unit_id')->where('id',$sellProductStockDetails->sell_product_id)->first();

        /*
        |--------------------------------------------------------------------------------------------------------
        | this section is managing for reducing stock when return/refund qty
        | note that:- refunding time -> we make a vartual field name totalReduceableQty
        | It's make by two column:-  totalReduceableQty = (reduceable_delivered_qty + reduced_base_stock_remaining_delivery)
        |--------------------------------------------------------------------------------------------------------
        */
            $totalQty = $sellProductStockDetails->total_quantity;

            $previouslyReduceableDeliveredQty= $sellProductStockDetails->reduceable_delivered_qty;
            $reducedBaseStockQtyRemainingDelivery = $sellProductStockDetails->reduced_base_stock_remaining_delivery;
            //$previouslyTotalReduceableQty = $sellProductStockDetails->total_reduceable_qty;
            $deliveryingQty = $deliverying_quantity;
            $newlyReducedBaseStockQtyRemainingDelivery = 0;
            $newlyReduceableDeliveredQty = 0;

            $minusStockQtyFromMainProductStock = 0;//minus stock qty from product_stocks table - available_base_stock field
            $minusReducedStockQtyFromMainProductStock = 0;//minus reduced stock qty from product_stocks table - available_base_stock field

            if($deliveryingQty > $reducedBaseStockQtyRemainingDelivery && $totalQty > 0){
                $newlyReducedBaseStockQtyRemainingDelivery = 0;
                $newlyReduceableDeliveredQty = $previouslyReduceableDeliveredQty + $deliveryingQty;
                
                //minus from main stock:- product_stocks table available_base_stock field
                $minusableMainStock = $deliveryingQty - $reducedBaseStockQtyRemainingDelivery;
                $minusStockQtyFromMainProductStock = $minusableMainStock;
                $minusReducedStockQtyFromMainProductStock = $reducedBaseStockQtyRemainingDelivery;
            }
            else if($deliveryingQty == $reducedBaseStockQtyRemainingDelivery && $totalQty > 0){
                $newlyReducedBaseStockQtyRemainingDelivery = 0;
                $newlyReduceableDeliveredQty = $previouslyReduceableDeliveredQty + $deliveryingQty;

                //minus from main stock:- product_stocks table available_base_stock field
                $minusStockQtyFromMainProductStock = 0;
                $minusReducedStockQtyFromMainProductStock = $reducedBaseStockQtyRemainingDelivery;
            }
            else if($deliveryingQty < $reducedBaseStockQtyRemainingDelivery && $totalQty > 0){
                $newlyReducedBaseStockQtyRemainingDelivery = $reducedBaseStockQtyRemainingDelivery - $deliveryingQty;
                $newlyReduceableDeliveredQty = $previouslyReduceableDeliveredQty + $deliveryingQty;

                //minus from main stock:- product_stocks table available_base_stock field
                $minusStockQtyFromMainProductStock = 0;
                $minusReducedStockQtyFromMainProductStock = $deliveryingQty;
            }
            $sellProductStockDetails->reduced_base_stock_remaining_delivery = $newlyReducedBaseStockQtyRemainingDelivery;
            $sellProductStockDetails->reduceable_delivered_qty =  $newlyReduceableDeliveredQty;
            //$this->totalReduceableStockQty($reducedBaseStockQtyRemainingDelivery,$previouslyReduceableDeliveredQty, $deliveryingQty);
        /*
        |--------------------------------------------------------------------------------------------------------
        | this section is managing for reducing stock when return/refund qty
        | note that:- refunding time -> we make a vartual field name totalReduceableQty
        | It's make by two column:-  totalReduceableQty = (reduceable_delivered_qty + reduced_base_stock_remaining_delivery)
        |--------------------------------------------------------------------------------------------------------
        */
            //delivered_total_qty

        $stockReduceFromRemainingDelivery = $minusReducedStockQtyFromMainProductStock;
        
        $totalDeliveredQty = (($sellProductStockDetails->total_delivered_qty) + $deliverying_quantity);
        $sellProductStockDetails->total_delivered_qty = $totalDeliveredQty;
        
        //when total delivered qty is equal to total quantity, then this data will be null
        if($totalDeliveredQty == $sellProductStockDetails->total_quantity){
            $sellProductStockDetails->remaining_delivery_unreduced_qty_date = NULL;
        }//have to process :- remaining_delivery_unreduced_qty
        
        
        $totalRemainingDeliveryQty = $sellProductStockDetails->total_quantity - $totalDeliveredQty;

        $sellProductStockDetails->remaining_delivery_qty = $totalRemainingDeliveryQty < 0 ? 0 : $totalRemainingDeliveryQty;
       
        $sellProductStockDetails->save();

        $productStock = productStockByProductStockId_hh($sellProductStockDetails->product_stock_id);
        if($productStock &&  $stockReduceFromRemainingDelivery)
        {
            $productStock->reduced_base_stock_remaining_delivery = (($productStock->reduced_base_stock_remaining_delivery) - $stockReduceFromRemainingDelivery);
            $productStock->save();
        }

        $stockReduceFromMainBaseStock  = $minusStockQtyFromMainProductStock;
        //reduce stock from product stock
        if($invoiceData->sell_type == 1 && $stockReduceFromMainBaseStock > 0)
        {
            $this->stock_id_FSCT = $sellProductStockDetails->stock_id;
            $this->product_id_FSCT = $sellProductStockDetails->product_id;
            $this->stock_quantity_FSCT = $stockReduceFromMainBaseStock;
            $this->unit_id_FSCT = $sellProduct ? $sellProduct->unit_id:0;
            $this->sellingFromPossStockTypeDecrement();
        }
        $this->sellDeliveryQuantity += $stockReduceFromMainBaseStock;
        $this->sellProductDeliveryProcess($sellDelivery,$invoiceData,$sellProductStockDetails,$deliverying_quantity);
       

        //module = SellProductStock, moduleTypeId = 3
        $this->sellModuleWiseUpdateDbField($moduleTypeId = 3, $primaryId = $sellProductStockDetails->id);

        //module = SellProduct, moduleTypeId = 2
        $this->sellModuleWiseUpdateDbField($moduleTypeId = 2, $primaryId = $sellProduct->id);

        return true;



        /*    
            $remainingStockProcessInstantlyQty = $sellProductStockDetails->stock_process_instantly_qty - $sellProductStockDetails->stock_process_instantly_qty_reduced;
            
            $stockReduceFromMainBaseStock = 0;
            $stockReduceFromRemainingDelivery = 0;
            if($remainingStockProcessInstantlyQty > 0)
            {
                if($deliverying_quantity > $remainingStockProcessInstantlyQty)
                {
                    $stockReduceFromMainBaseStock = $deliverying_quantity - $remainingStockProcessInstantlyQty;
                    $stockReduceFromRemainingDelivery = $remainingStockProcessInstantlyQty;
                }
                else if($deliverying_quantity == $remainingStockProcessInstantlyQty)
                {
                    $stockReduceFromMainBaseStock = $deliverying_quantity - $remainingStockProcessInstantlyQty;
                    $stockReduceFromRemainingDelivery = $remainingStockProcessInstantlyQty;
                }
                else if($deliverying_quantity < $remainingStockProcessInstantlyQty)
                {
                    $stockReduceFromMainBaseStock = 0;
                    $stockReduceFromRemainingDelivery = $deliverying_quantity;
                }else{
                    $stockReduceFromMainBaseStock = $deliverying_quantity;
                    $stockReduceFromRemainingDelivery = 0;
                }
            }else{
                $stockReduceFromMainBaseStock = $deliverying_quantity;
                $stockReduceFromRemainingDelivery = 0;
            }
        
            $totalDeliveredQty = (($sellProductStockDetails->total_delivered_qty) + $deliverying_quantity);
            //$totalSellDeliveredQty = (($sellProductStockDetails->sell_delivered_qty) + $deliverying_quantity); //new field
            
            $sellProductStockDetails->total_delivered_qty = $totalDeliveredQty;
            //$sellProductStockDetails->sell_delivered_qty = $totalSellDeliveredQty;//new field 

            $sellProductStockDetails->remaining_delivery_qty = $sellProductStockDetails->total_quantity - $totalDeliveredQty;
        
            $sellProductStockDetails->stock_process_instantly_qty_reduced += $stockReduceFromRemainingDelivery;
            $sellProductStockDetails->save();

            $productStock = productStockByProductStockId_hh($sellProductStockDetails->product_stock_id);
            if($productStock &&  $stockReduceFromRemainingDelivery)
            {
                $productStock->reduced_base_stock_remaining_delivery = (($productStock->reduced_base_stock_remaining_delivery) - $stockReduceFromRemainingDelivery);
                $productStock->save();
            }

    
            //reduce stock from product stock
            if($invoiceData->sell_type == 1 && $stockReduceFromMainBaseStock > 0)
            {
                $this->stock_id_FSCT = $sellProductStockDetails->stock_id;
                $this->product_id_FSCT = $sellProductStockDetails->product_id;
                $this->stock_quantity_FSCT = $stockReduceFromMainBaseStock;
                $this->unit_id_FSCT = $sellProduct ? $sellProduct->unit_id:0;
                $this->sellingFromPossStockTypeDecrement();
            }
            //reduce stock from product stock
            $this->sellDeliveryQuantity += $stockReduceFromMainBaseStock;

            $this->sellProductDeliveryProcess($sellDelivery,$invoiceData,$sellProductStockDetails,$deliverying_quantity);
            return true; 
        */
    }


    //its not implemented yet now.. 11-01-2023
    private function totalReduceableStockQty(int $reducedBaseStockQtyRemainingDelivery, int $previouslyReduceableDeliveredQty, int $deliveryingQty) : int {
        //when delivered qty
        //number one is :- reduceable_delivered_qty stock will be plus..
        //number two is :- reduced_base_stock_remaining_delivery stock will be minus until zero..
        $reducedBaseStockQtyRemainingDelivery;// 2
        $previouslyReduceableDeliveredQty;// 1
        //vartually $previouslyTotalReduceableQty;// 0 
        $deliveryingQty; //3

        $newlyReducedBaseStockQtyRemainingDelivery = 0;
        $newlyReduceableDeliveredQty = 0;
        //$newlyTotalReduceableQty = 0;
        if($deliveryingQty > $reducedBaseStockQtyRemainingDelivery){
            $newlyReducedBaseStockQtyRemainingDelivery = 0;
            $newlyReduceableDeliveredQty = $previouslyReduceableDeliveredQty + $deliveryingQty;
            //$newlyTotalReduceableQty = 0;
        }
        else if($deliveryingQty == $reducedBaseStockQtyRemainingDelivery){
            $newlyReducedBaseStockQtyRemainingDelivery = 0;
            $newlyReduceableDeliveredQty = $previouslyReduceableDeliveredQty + $deliveryingQty;
            //$newlyTotalReduceableQty = 0;
        }
        else if($deliveryingQty < $reducedBaseStockQtyRemainingDelivery){
            $newlyReducedBaseStockQtyRemainingDelivery = $reducedBaseStockQtyRemainingDelivery - $deliveryingQty;
            $newlyReduceableDeliveredQty = $previouslyReduceableDeliveredQty + $deliveryingQty;
            //$newlyTotalReduceableQty = 0;
        }

        return 4;
    }


    //sell product delivery invoice
    private function sellProductDeliveryInvoiceStore($makeInvoice,$sellInvoice)
    {
        $sellDeliver = new SellProductDeliveryInvoice();
        $sellDeliver->branch_id = authBranch_hh();
        $sellDeliver->invoice_no = $makeInvoice; 
        $sellDeliver->sell_invoice_no = $sellInvoice->invoice_no; 
        $sellDeliver->sell_invoice_id = $sellInvoice->id; 
        //$sellDeliver->delivery_note = ''; 
        //$sellDeliver->quantity = $this->sellDeliveryQuantity;
        $sellDeliver->delivery_status = 1;
        $sellDeliver->created_by = authId_hh();
        $sellDeliver->save();
        return $sellDeliver;
    }

    //sell product delivery
    private function sellProductDeliveryProcess($sellDelivery,$sellInvoice,$sellProductStockDetails,$deliverying_quantity)
    {
        $delivery = new SellProductDelivery();
        $delivery->branch_id = authBranch_hh();
        $delivery->sell_product_delivery_invoice_id = $sellDelivery->id; 
        $delivery->sell_invoice_id = $sellInvoice->id; 
        $delivery->sell_product_id = $sellProductStockDetails->sell_product_id;
        $delivery->sell_product_stock_id = $sellProductStockDetails->id;
        $delivery->product_id = $sellProductStockDetails->product_id;
        $delivery->stock_id = $sellProductStockDetails->stock_id;
        $delivery->product_stock_id = $sellProductStockDetails->product_stock_id;
        $delivery->quantity = $deliverying_quantity;
        $delivery->delivery_status = 1;
        $delivery->created_by = authId_hh();
        $delivery->save();
        return $delivery;
    }



    //print
    public function printSellProductDeliveredInvoiceWiseDeliveredProductList($invoiceId)
    {
        $data['delivery_invoice'] = $invoiceId;
        $data['sellProductDelivery']  =  SellProductDelivery::where('invoice_no',$invoiceId)->first();
        $data['data']  =  SellProductDelivery::where('invoice_no',$invoiceId)->get();
        return view('backend.sell.delivery.delivered_print',$data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
