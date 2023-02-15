<?php

namespace App\Http\Controllers\Backend\Sell\Details;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Backend\Sell\SellInvoice;
use App\Models\Backend\Sell\SellProduct;
use App\Traits\Backend\Payment\PaymentProcessTrait;
use App\Traits\Backend\Payment\CustomerPaymentProcessTrait;
use App\Traits\Backend\Customer\Logical\ManagingCalculationOfCustomerSummaryTrait;

use App\Traits\Backend\Sell\Logical\UpdateSellSummaryCalculationTrait;

class SellController extends Controller
{
    use UpdateSellSummaryCalculationTrait;

    use PaymentProcessTrait;
    use CustomerPaymentProcessTrait, ManagingCalculationOfCustomerSummaryTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['datas'] = SellInvoice::where('sell_type',1)
                        ->where('branch_id',authBranch_hh())
                        ->whereNull('deleted_at')
                        //->orderBy('custom_serial','ASC')
                        ->latest()
                        ->paginate(10);
        $data['page_no'] = 1;
        return view('backend.sell.sell_details.index',$data);
    }

    public function sellListByAjaxResponse(Request $request)
    {
        /* $status         = $request->status ?? NULL;
        $pagination     = $request->pagination ?? 50;
        $search         = $request->search ?? NULL;
        
        $date_from = Carbon::parse($request->input('start_date'));
        $date_to = Carbon::parse($request->input('end_date') ?? date("Y-m-d h:i:s",strtotime(date("Y-m-d h:i:s")."-21 day")));
        
        $query= Order::query();
        if($search)
        {   
            $query->where('order_number','like','%'.$search.'%')
            ->orWhere('customer_name','like','%'.$search.'%')
            ->orWhere('status','like','%'.$search.'%')
            ->orWhere('payment_status','like','%'.$search.'%')
            ->orWhere('method','like','%'.$search.'%')
            ;
        }
        if($date_from)
        {
            $query->whereDate('created_at', '<=', $date_from)
            ->whereDate('created_at', '>=', $date_to);
        }
        if($status != "none" && $status != "")
        {
            $query->where('status',$status);
        }
        $data['orders'] =    $query->orderBy('id', 'desc')
                        ->paginate($pagination); 
        $data['page_no'] = $request->page ?? 1; */

        $status         = $request->status ?? NULL;
        $pagination     = $request->pagination ?? 50;
        $search         = $request->search ?? NULL;
        
        $date_to = Carbon::parse($request->input('date_to'));
        $date_from = Carbon::parse($request->input('date_from') ?? date("Y-m-d h:i:s",strtotime(date("Y-m-d h:i:s")."-7 day")));
        //$date_from = Carbon::parse($request->input('date_from'));
        //$date_to = Carbon::parse($request->input('date_to') ?? date("Y-m-d h:i:s",strtotime(date("Y-m-d h:i:s")."-7 day")));

        $sell  = SellInvoice::query();
        if($request->ajax())
        {
            if($request->search)
            {
                $sell->where('invoice_no','like','%'.$request->search.'%')
                ->orWhere('customer_phone','like','%'.$request->search.'%');
            }
            if($date_from)
            {
                $sell->whereDate('created_at', '>=', $date_from)
                ->whereDate('created_at', '<=', $date_to);
            }
            $data['datas']  =  $sell->where('sell_type',1)->latest()->paginate($pagination);
            $data['page_no'] = $request->page ?? 1;
            $html = view('backend.sell.sell_details.ajax.list_ajax_response',$data)->render();
            return response()->json([
                'status' => true,
                'html' => $html
            ]);
        }
    }


    public function singleView(Request $request)
    {
        $data['data']  =  SellInvoice::where('id',$request->id)->first();
        $html = view('backend.sell.sell_details.show.show',$data)->render();
        return response()->json([
            'status' => true,
            'html' => $html
        ]);
    }


    public function viewSingleInvoiceProfitLoss(Request $request)
    {
        $data['data']  =  SellInvoice::where('id',$request->id)->first();
        $html = view('backend.sell.sell_details.show.profit_lost',$data)->render();
        return response()->json([
            'status' => true,
            'html' => $html
        ]);
    }


    //payment modal open with customer information and invoice information
    public function receiveSingleInvoiceWisePayment(Request $request)
    {   
        $data['data'] = SellInvoice::findOrFail($request->id);
        if($data['data'])
        {
            $data['cashAccounts'] = cashAccounts_hh();
            $data['advanceAccounts'] = advanceAccounts_hh();
            
            $html = view('backend.sell.payment.single_payment',$data)->render();
            return response()->json([
                'status'    => true,
                'html'     => $html,
            ]);
        }else{
            return response()->json([
                'status'    => false,
            ]);
        }
    }
    
    //store receiving single invoice swise payment
    public function receivingSingleInvoiceWisePayment(Request $request)
    {
        //return $request;
        DB::beginTransaction();
        try {
            //payment process
            if(($request->invoice_total_paying_amount ?? 0) > 0)
            {
                $invoiceData = SellInvoice::findOrFail($request->sell_invoice_id);
                //for payment processing 
                $this->mainPaymentModuleId = getModuleIdBySingleModuleLebel_hh('Sell');
                $this->paymentModuleId = getModuleIdBySingleModuleLebel_hh('Sell');
                $this->paymentCdfTypeId = getCdfIdBySingleCdfLebel_hh('Credit');
                $moduleRelatedData = [
                    'main_module_invoice_no' => $invoiceData->invoice_no,
                    'main_module_invoice_id' => $invoiceData->id,
                    'module_invoice_no' => $invoiceData->invoice_no,
                    'module_invoice_id' => $invoiceData->id,
                    'user_id' => $invoiceData->customer_id,//client[customer,supplier,others staff]
                ];
                $this->paymentProcessingRequiredOfAllRequestOfModuleRelatedData = $moduleRelatedData;
                $this->paymentProcessingRelatedOfAllRequestData = paymentDataProcessingWhenSellingSubmitFromPos_hh($request);// $paymentAllData;
                $this->invoiceTotalPayingAmount = $request->invoice_total_paying_amount ?? 0 ;
                $this->processingPayment();

                //customer transaction statement history
                $requestCTSData = [];
                $requestCTSData['amount'] = $request->invoice_total_paying_amount ?? 0 ;
                $requestCTSData['ledger_page_no'] = NULL;
                $requestCTSData['next_payment_date'] = NULL;
                $requestCTSData['short_note'] = "Sell Due Payment";
                $requestCTSData['sell_amount'] = 0;
                $requestCTSData['sell_paid'] = 0;
                $requestCTSData['sell_due'] = 0;
                $this->processingOfAllCustomerTransactionRequestData = customerTransactionRequestDataProcessing_hp($requestCTSData);
                $this->amount = $request->invoice_total_paying_amount ?? 0 ;
                
                $this->ctsTTModuleId = getCTSModuleIdBySingleModuleLebel_hp('Sell Due Payment');
                $this->ctsCustomerId = $invoiceData->customer_id;
                $ttModuleInvoics = [
                    'invoice_no' => $invoiceData->invoice_no,
                    'invoice_id' => $invoiceData->id
                ];
                $this->ttModuleInvoicsDataArrayFormated = $ttModuleInvoics;
                $this->ctsCdsTypeId = getCTSCdfIdBySingleCdfLebel_hp('Paid');
                $this->processingOfAllCustomerTransaction();
                //customer transaction statement history  
                
                //calculation in the customer table
                //$dbField = 24;'current_paid_return';
                //$calType = 1='plus', 2='minus'
                //$this->managingCustomerCalculation($invoiceData->customer_id,$dbField = 24 ,$calType = 2,$request->invoice_total_paying_amount ?? 0 );
                //calculation in the customer table 
                                   
                //change amount from sellinvoice 
                $invoiceData->paid_amount = $invoiceData->paid_amount + $request->invoice_total_paying_amount ?? 0;
                $invoiceData->due_amount = $invoiceData->due_amount - $request->invoice_total_paying_amount ?? 0;
                $invoiceData->total_paid_amount = $invoiceData->total_paid_amount + $request->invoice_total_paying_amount ?? 0;
                $invoiceData->save();
                $this->updateSellInvoiceCalculation($invoiceData->id);

                //$dbField = 21;'current_paid_due';
                //$calType = 1='plus', 2='minus'
                $this->managingCustomerCalculation($invoiceData->customer_id,$dbField = 21 ,$calType = 1,$request->invoice_total_paying_amount ?? 0 );
            } 
            DB::commit();

            $data['data'] = SellInvoice::findOrFail($request->sell_invoice_id);
            $data['cashAccounts'] = cashAccounts_hh();
            $data['advanceAccounts'] = advanceAccounts_hh();
            $html = view('backend.sell.payment.single_payment',$data)->render();
            return response()->json([
                'status'    => true,
                'message'   => "Payment received successfully!",
                'type'      => 'success',
                'html'     => $html,
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
            return response()->json([
                'status'    => true,
                'message'   => "Something went wrong",
                'type'      => 'error'
            ]);
        }
    }



    //view single invoice Payment details
    public function viewSingleInvoicePaymentDetails(Request $request)
    {   
        $data['data'] = SellInvoice::findOrFail($request->id);
        if($data['data'])
        {
            $html = view('backend.sell.payment.view_single_payment',$data)->render();
            return response()->json([
                'status'    => true,
                'html'     => $html,
            ]);
        }else{
            return response()->json([
                'status'    => false,
            ]);
        }
    }





    
    public function viewSingleInvoiceForOverallAdjustmentDiscount(Request $request)
    {
        $data['data']  =  SellInvoice::where('id',$request->id)->first();
        $html = view('backend.sell.sell_details.show.overall_adjustment',$data)->render();
        return response()->json([
            'status' => true,
            'html' => $html
        ]);
    }

    //store receiving single invoice swise payment
    public function viewSingleInvoiceForOverallAdjustmentDiscountReceiving(Request $request)
    {
        //return $request;
        DB::beginTransaction();
        try {
            //payment process
            if(($request->amount ?? 0) > 0)
            {
                $invoiceData = SellInvoice::findOrFail($request->id);
                /* //for payment processing 
                $this->mainPaymentModuleId = getModuleIdBySingleModuleLebel_hh('Sell');
                $this->paymentModuleId = getModuleIdBySingleModuleLebel_hh('Sell');
                $this->paymentCdfTypeId = getCdfIdBySingleCdfLebel_hh('Credit');
                $moduleRelatedData = [
                    'main_module_invoice_no' => $invoiceData->invoice_no,
                    'main_module_invoice_id' => $invoiceData->id,
                    'module_invoice_no' => $invoiceData->invoice_no,
                    'module_invoice_id' => $invoiceData->id,
                    'user_id' => $invoiceData->customer_id,//client[customer,supplier,others staff]
                ];
                $this->paymentProcessingRequiredOfAllRequestOfModuleRelatedData = $moduleRelatedData;
                $this->paymentProcessingRelatedOfAllRequestData = paymentDataProcessingWhenSellingSubmitFromPos_hh($request);// $paymentAllData;
                $this->invoiceTotalPayingAmount = $request->invoice_total_paying_amount ?? 0 ;
                $this->processingPayment();

                //customer transaction statement history
                $requestCTSData = [];
                $requestCTSData['amount'] = $request->invoice_total_paying_amount ?? 0 ;
                $requestCTSData['ledger_page_no'] = NULL;
                $requestCTSData['next_payment_date'] = NULL;
                $requestCTSData['short_note'] = "Sell Due Payment";
                $requestCTSData['sell_amount'] = 0;
                $requestCTSData['sell_paid'] = 0;
                $requestCTSData['sell_due'] = 0;
                $this->processingOfAllCustomerTransactionRequestData = customerTransactionRequestDataProcessing_hp($requestCTSData);
                $this->amount = $request->invoice_total_paying_amount ?? 0 ;
                
                $this->ctsTTModuleId = getCTSModuleIdBySingleModuleLebel_hp('Sell Due Payment');
                $this->ctsCustomerId = $invoiceData->customer_id;
                $ttModuleInvoics = [
                    'invoice_no' => $invoiceData->invoice_no,
                    'invoice_id' => $invoiceData->id
                ];
                $this->ttModuleInvoicsDataArrayFormated = $ttModuleInvoics;
                $this->ctsCdsTypeId = getCTSCdfIdBySingleCdfLebel_hp('Paid');
                $this->processingOfAllCustomerTransaction();
                //customer transaction statement history  
                
                //calculation in the customer table
                //$dbField = 24;'current_paid_return';
                //$calType = 1='plus', 2='minus'
                //$this->managingCustomerCalculation($invoiceData->customer_id,$dbField = 24 ,$calType = 2,$request->invoice_total_paying_amount ?? 0 );
                //calculation in the customer table 
                                 */
                //change amount from sellinvoice 
                //$invoiceData->paid_amount = $invoiceData->paid_amount + $request->invoice_total_paying_amount ?? 0;
                //$invoiceData->due_amount = $invoiceData->due_amount - $request->invoice_total_paying_amount ?? 0;
                $invoiceData->adjustment_amount =  $request->amount ?? 0;
                $invoiceData->save();
                $this->updateSellInvoiceCalculation($invoiceData->id);

                //$dbField = 21;'current_paid_due';
                //$calType = 1='plus', 2='minus'
                //$this->managingCustomerCalculation($invoiceData->customer_id,$dbField = 21 ,$calType = 1,$request->invoice_total_paying_amount ?? 0 );
            } 
            DB::commit();
            return response()->json([
                'status'    => true,
                'message'   => "Received successfully!",
                'type'      => 'success',
            ]);

            $data['data'] = SellInvoice::findOrFail($request->sell_invoice_id);
            $data['cashAccounts'] = cashAccounts_hh();
            $data['advanceAccounts'] = advanceAccounts_hh();
            $html = view('backend.sell.payment.single_payment',$data)->render();
            return response()->json([
                'status'    => true,
                'message'   => "Payment received successfully!",
                'type'      => 'success',
                'html'     => $html,
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
            return response()->json([
                'status'    => true,
                'message'   => "Something went wrong",
                'type'      => 'error'
            ]);
        }
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
        //
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
