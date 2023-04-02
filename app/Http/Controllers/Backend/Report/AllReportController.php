<?php

namespace App\Http\Controllers\Backend\Report;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Backend\Payment\AccountPayment;
use App\Models\Backend\Purchase\PurchaseInvoice;
use App\Models\Backend\Sell\SellInvoice;

class AllReportController extends Controller
{
   
    public function dalilyTransactionalReportSummary(Request $request){
        //$date_to = date("Y-m-d h:i:s",strtotime(date("Y-m-d h:i:s")."-1 day"));
         
        $date_to = Carbon::parse($request->input('date_to'));
        $date_from = Carbon::parse($request->input('date_from') ?? date("Y-m-d h:i:s",strtotime(date("Y-m-d h:i:s")."-0 day")));
        
        $accountPayments =  AccountPayment::where('branch_id',authBranch_hh())->whereNull('deleted_at')->whereDate('payment_date', '>=', $date_from)->whereDate('payment_date', '<=', $date_to)->get();
        $creditAccountPayments =  AccountPayment::where('branch_id',authBranch_hh())->where('cdf_type_id',1)->whereNull('deleted_at')->whereDate('payment_date', '>=', $date_from)->whereDate('payment_date', '<=', $date_to)->get();
        $debitAccountPayments =  AccountPayment::where('branch_id',authBranch_hh())->where('cdf_type_id',2)->whereNull('deleted_at')->whereDate('payment_date', '>=', $date_from)->whereDate('payment_date', '<=', $date_to)->get();
       
        return view('backend.report.daily.daily_report_summary',compact('accountPayments','creditAccountPayments','debitAccountPayments'));
    }

    //daily report transactional summary details module wise
    public function dalilyReportTransactionalSummaryDetails(Request $request){

        //$date_to = date("Y-m-d h:i:s",strtotime(date("Y-m-d h:i:s")."-1 day"));
        //$date_from = Carbon::parse($request->input('date_from') ?? date("Y-m-d h:i:s",strtotime(date("Y-m-d h:i:s")."-1 day")));
       
        $date_to = Carbon::parse($request->input('date_to'));
        $date_from = Carbon::parse($request->input('date_from') ?? date("Y-m-d h:i:s",strtotime(date("Y-m-d h:i:s")."-0 day")));
       
        $sellInvoices =  SellInvoice::where('branch_id',authBranch_hh())->whereNull('deleted_at')->whereDate('created_at', '>=', $date_from)->whereDate('created_at', '<=', $date_to)->latest()->get();
        $purchaseInvoices =  PurchaseInvoice::where('branch_id',authBranch_hh())->whereNull('deleted_at')->whereDate('created_at', '>=', $date_from)->whereDate('created_at', '<=', $date_to)->latest()->get();
        

        // 2, 2 == selling time receive amount.. 
        $sellingTimeReceivedAmount =  AccountPayment::where('branch_id',authBranch_hh())->where('main_module_id',2)->where('module_id',2)->whereNull('deleted_at')->whereDate('payment_date', '>=', $date_from)->whereDate('payment_date', '<=', $date_to)->sum('payment_amount');
        //2, 4 == sell return amount
        $sellReturnAmount =  AccountPayment::where('branch_id',authBranch_hh())->where('main_module_id',2)->where('module_id',4)->whereNull('deleted_at')->whereDate('payment_date', '>=', $date_from)->whereDate('payment_date', '<=', $date_to)->get();
        
        //1,1 == purchase
        $purchaseingTimePaidAmount =  AccountPayment::where('branch_id',authBranch_hh())->where('main_module_id',1)->where('module_id',1)->whereNull('deleted_at')->whereDate('payment_date', '>=', $date_from)->whereDate('payment_date', '<=', $date_to)->sum('payment_amount');
        
        //2,5 == Receive Sell Due 
        $customerSellDueReceives =  AccountPayment::where('branch_id',authBranch_hh())->where('main_module_id',2)->where('module_id',5)->whereNull('deleted_at')->whereDate('payment_date', '>=', $date_from)->whereDate('payment_date', '<=', $date_to)->get();
        //6,6 == Receive Customer Previous Due
        $customerPreviousDueReceives =  AccountPayment::where('branch_id',authBranch_hh())->where('main_module_id',6)->where('module_id',6)->whereNull('deleted_at')->whereDate('payment_date', '>=', $date_from)->whereDate('payment_date', '<=', $date_to)->get();
        //7,7 == Customer Loan
        $customerAddLoans =  AccountPayment::where('branch_id',authBranch_hh())->where('main_module_id',7)->where('module_id',7)->whereNull('deleted_at')->whereDate('payment_date', '>=', $date_from)->whereDate('payment_date', '<=', $date_to)->get();
        //9,9 == Customer Advance
        $customerAddAdvances =  AccountPayment::where('branch_id',authBranch_hh())->where('main_module_id',9)->where('module_id',9)->whereNull('deleted_at')->whereDate('payment_date', '>=', $date_from)->whereDate('payment_date', '<=', $date_to)->get();
        return view('backend.report.daily.daily_report_details',compact('sellInvoices','purchaseInvoices','sellingTimeReceivedAmount','purchaseingTimePaidAmount','customerSellDueReceives','customerPreviousDueReceives','customerAddLoans','customerAddAdvances','sellReturnAmount'));
    }



    public function dailyTransactionalProfitReport(Request $request){
        
        $date_to = Carbon::parse($request->input('date_to'));
        $date_from = Carbon::parse($request->input('date_from') ?? date("Y-m-d h:i:s",strtotime(date("Y-m-d h:i:s")."-10 day")));
       
        $sellInvoice =  SellInvoice::select('total_payable_amount','total_paid_amount','total_due_amount','total_discount_amount',
        'total_profit','total_profit_from_product')->where('branch_id',authBranch_hh())->whereNull('deleted_at')->whereDate('created_at', '>=', $date_from)->whereDate('created_at', '<=', $date_to)->latest()->get();
        $data['totalPayableAmount'] = $sellInvoice->sum('total_payable_amount');
        $data['totalPaidAmount'] = $sellInvoice->sum('total_paid_amount');
        $data['totalDueAmount'] = $sellInvoice->sum('total_due_amount');
        $data['totalDiscountAmount'] = $sellInvoice->sum('total_discount_amount');
        $data['totalProfitAmount'] = $sellInvoice->sum('total_profit');
        $data['totalProfitFromProductAmount'] = $sellInvoice->sum('total_profit_from_product');
        return view('backend.report.daily.daily_profit_report',$data);
    }


    public function dailyTransactionalLadgerReport(Request $request){
        
        $date_to = Carbon::parse($request->input('date_to'));
        $date_from = Carbon::parse($request->input('date_from') ?? date("Y-m-d h:i:s",strtotime(date("Y-m-d h:i:s")."-10 day")));
       
        $sellInvoice =  SellInvoice::select('total_payable_amount','total_paid_amount','total_due_amount','total_discount_amount',
        'total_profit','total_profit_from_product')->where('branch_id',authBranch_hh())->whereNull('deleted_at')->whereDate('created_at', '>=', $date_from)->whereDate('created_at', '<=', $date_to)->latest()->get();
        $data['totalPayableAmount'] = $sellInvoice->sum('total_payable_amount');
        $data['totalPaidAmount'] = $sellInvoice->sum('total_paid_amount');
        $data['totalDueAmount'] = $sellInvoice->sum('total_due_amount');
        $data['totalDiscountAmount'] = $sellInvoice->sum('total_discount_amount');
        $data['totalProfitAmount'] = $sellInvoice->sum('total_profit');
        $data['totalProfitFromProductAmount'] = $sellInvoice->sum('total_profit_from_product');
        return view('backend.report.daily.daily_ledger_report',$data);
    }


}
