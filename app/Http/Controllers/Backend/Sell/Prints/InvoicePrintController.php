<?php

namespace App\Http\Controllers\Backend\Sell\Prints;

use PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Backend\Sell\SellInvoice;
use App\Models\Backend\Customer\Customer;
use App\Models\Backend\Purchase\PurchaseInvoice;

class InvoicePrintController extends Controller
{
    
    public function posPrintFromDirectSellCart()
    {
        return view('backend.sell.print.invoice-from-sell-cart.pos_print');
    }
    public function normalPrintFromDirectSellCart()
    {
        //its working from sell list print
        return "normal print";
    }


    
    public function posPrintFromSellList($invoiceId)
    {
        $data['data']  =  SellInvoice::where('id',$invoiceId)->first();
        return view('backend.sell.print.invoice-from-sell.pos_print',$data);
    }

    public function normalPrintFromSellList($invoiceId)
    {
        $data['data']  =  SellInvoice::where('id',$invoiceId)->first();
        return view('backend.sell.print.invoice-from-sell.normal_print',$data);
    }

    //pdf sell list
    public function sellListPdfDownload(Request $request){

        $sellInvoices  =  SellInvoice::whereIn('id',$request->checked_id)->get();
        $data['datas'] = $sellInvoices;
        ini_set('max_execution_time', 180); //3 minutes
        
        $html =  header('Content-Type: text/html; charset=utf-8');
      
          $html .= '<h4 style="text-align:center;">'.config('app.name').'</h4>';
            /* 
                $html .= '<div style="margin:0 auto; padding:2%; width:94%;"><strong style="font-size: 19px">'.companyNameInInvoice_hh().'</strong><br>
                <span>'.companyAddressLineOneInInvoice_hh().'</span> 
                '.companyAddressLineTwoInInvoice_hh().'<br>'.
                
                '<span><strong>Call:  '.companyPhone_hh().' '. companyPhoneOne_hh() ? ','. companyPhoneOne_hh() : NULL ;
                
                $html .= companyPhoneTwo_hh() ? ','. companyPhoneTwo_hh() : NULL .' </strong> </span><br>' .'
                </div>
                <hr/>'; 
            */
        

        $html .= '<table style="width:96%;margin:2%;border: 0.5px solid gray; border-spacing: 0;">
        <tr>
          <th style="border: 0.5px solid gray; border-collapse: collapse;text-align:center">#</th>
          <th style="border: 0.5px solid gray; border-collapse: collapse;text-align:center">Invoice No</th>
          <th style="border: 0.5px solid gray; border-collapse: collapse;text-align:center">Date(Time)</th>
          <th style="border: 0.5px solid gray; border-collapse: collapse;text-align:center">Customer</th>
          <th style="border: 0.5px solid gray; border-collapse: collapse;text-align:center">Payable Amount</th>
          <th style="border: 0.5px solid gray; border-collapse: collapse;text-align:center">Paid Amount</th>
          <th style="border: 0.5px solid gray; border-collapse: collapse;text-align:center">Due Amount</th>
          <th style="border: 0.5px solid gray; border-collapse: collapse;text-align:center">Less Amount</th>
          <th style="border: 0.5px solid gray; border-collapse: collapse;text-align:center">Total Item</th>
        </tr>';

        $totalPayableAmount = 0;
        $totalPaidAmount = 0;
        $totalDueAmount = 0;
        $totalDiscountAmount = 0;   
        $totalItem = 0;

        $dynamicRows = '';
        foreach($sellInvoices as $index => $item)
        {
            $customer = Customer::select('id','name')->find($item->customer_id);
            $customerName = NULL;
            if($customer){
                $customerName = $customer->name;
            }
            
            $dynamicRows .= 
            '<tr>
                <td style="border: 0.5px solid gray; border-collapse: collapse;text-align:center">'. ($index + (1)).'</td>
                <td style="border: 0.5px solid gray; border-collapse: collapse;text-align:center">'. $item->invoice_no.'</td>
                <td style="border: 0.5px solid gray; border-collapse: collapse;text-align:center">'. date('d-m-Y h:i:s A',strtotime($item->created_at)).'</td>
                <td style="border: 0.5px solid gray; border-collapse: collapse;text-align:center">'. html_entity_decode($customerName)  .'</td>
                <td style="border: 0.5px solid gray; border-collapse: collapse;text-align:center">'. $item->total_payable_amount.'</td>
                <td style="border: 0.5px solid gray; border-collapse: collapse;text-align:center">'. $item->total_paid_amount.'</td>
                <td style="border: 0.5px solid gray; border-collapse: collapse;text-align:center">'. $item->total_due_amount.'</td>
                <td style="border: 0.5px solid gray; border-collapse: collapse;text-align:center">'. $item->total_discount_amount.'</td>
                <td style="border: 0.5px solid gray; border-collapse: collapse;text-align:center">'. $item->totalSellItemAfterRefund().'</td>
            </tr>';

            $totalPayableAmount += $item->total_payable_amount;
            $totalPaidAmount += $item->total_paid_amount;
            $totalDueAmount += $item->total_due_amount;
            $totalDiscountAmount += $item->total_discount_amount;   
            $totalItem += $item->totalSellItemAfterRefund();            
        };
        $html .= '<tbody>'.$dynamicRows.'</tbody';
        //$html .= $tbody;

        $html .= '<tfooter  style="background-color:gray;">
            <tr>
                <th style="border:1px solid gray; border-collapse: collapse;text-align:right" colspan="4">Total</th>
                <th style="border:1px solid gray; border-collapse: collapse;text-align:center">'. number_format($totalPayableAmount,2,'.','').'</th>
                <th style="border:1px solid gray; border-collapse: collapse;text-align:center">'. number_format($totalPaidAmount,2,'.','').'</th>
                <th style="border:1px solid gray; border-collapse: collapse;text-align:center">'. number_format($totalDueAmount,2,'.','').'</th>
                <th style="border:1px solid gray; border-collapse: collapse;text-align:center">'. number_format($totalDiscountAmount,2,'.','').'</th>
                <th style="border:1px solid gray; border-collapse: collapse;text-align:center">'. $totalItem.'</th>
            </tr>
        </tfooter>';

        $html .= '</table>';
        
        $pdf = \App::make('dompdf.wrapper');
        //$pdf->loadHTML($html);
        $pdfile = $pdf->loadHTML($html)->setPaper('a4', 'landscape')->setWarnings(false)->save('myfile.pdf');
        return $pdfile->download('sell-list-'.date('d-m-Y h:i:s A').'.pdf');
        //return $pdf->stream();
    

        //ini_set('max_execution_time', 180); //3 minutes
        //$page =  view('backend.sell.print.invoice-from-sell.pdf_sell_list',$data);
        //$pdf = \App::make('dompdf.wrapper');
        //$pdf->loadView('backend.sell.print.invoice-from-sell.pdf_sell_list',$data); // $pdf->loadHTML('<h2>'.Hello, Preint This Section.'</h2>');
        //return $pdf->download('pdfDownload_FileName.pdf');
        //return $pdf->stream();


        //$pdf = PDF::loadView('backend.sell.print.invoice-from-sell.pdf_sell_list',$data);
        //return $pdf->download('sell-list.pdf');//->setOptions(['defaultFont' => 'sans-serif'])

        return view('backend.sell.print.invoice-from-sell.pdf_sell_list',$data);
    } 

    //sell quotation print
    public function normalPrintFromSellQuotationList($sellInvoiceId)
    {
        $data['data']  =  SellInvoice::where('id',$sellInvoiceId)->first();
        return view('backend.sell.print.invoice-from-sell.normal_quotation_print',$data);
    }

    
    

    //purchase section

    //have to process later
    public function posPrintFromDirectPurchaseCart()
    {
        return view('backend.sell.print.invoice-from-sell-cart.pos_print');
    }
    public function normalPrintFromDirectPurchaseCart()
    {
        //its working from sell list print
        return "normal print";
    }



    public function posPrintFromPurchaseList($invoiceId)
    {
        $data['data']  =  PurchaseInvoice::where('id',$invoiceId)->first();
        return view('backend.purchase.print.invoice-from-purchase.pos_print',$data);
    }

    public function normalPrintFromPurchaseList($invoiceId)
    {
        $data['data']  =  PurchaseInvoice::where('id',$invoiceId)->first();
        return view('backend.purchase.print.invoice-from-purchase.normal_print',$data);
    }

    //sell quotation print
    public function normalPrintFromPurchaseQuotationList($sellInvoiceId)
    {
        $data['data']  =  PurchaseInvoice::where('id',$sellInvoiceId)->first();
        return view('backend.purchase.print.invoice-from-purchase.normal_quotation_print',$data);
    }

    
    



    
}
