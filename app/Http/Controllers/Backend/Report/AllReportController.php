<?php

namespace App\Http\Controllers\Backend\Report;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Backend\Purchase\PurchaseInvoice;
use App\Models\Backend\Sell\SellInvoice;

class AllReportController extends Controller
{
   
    public function dalilyTransactionalReportSummary(Request $request){
        $date_to = Carbon::parse($request->input('date_to'));
        $date_from = Carbon::parse($request->input('date_from') ?? date("Y-m-d h:i:s",strtotime(date("Y-m-d h:i:s")."-0 day")));
        
        return view('backend.report.daily.daily_report_summary');
    }

    public function dalilyReportTransactionalSummaryDetails(Request $request){

        $date_to = Carbon::parse($request->input('date_to'));
        $date_from = Carbon::parse($request->input('date_from') ?? date("Y-m-d h:i:s",strtotime(date("Y-m-d h:i:s")."-200 day")));
        
        $sellInvoices =  SellInvoice::whereNull('deleted_at')->whereDate('created_at', '>=', $date_from)->whereDate('created_at', '<=', $date_to)->get();
        $purchaseInvoices =  PurchaseInvoice::whereNull('deleted_at')->whereDate('created_at', '>=', $date_from)->whereDate('created_at', '<=', $date_to)->get();
        return view('backend.report.daily.daily_report_details',compact('sellInvoices','purchaseInvoices'));
    }
}
