<?php

namespace App\Http\Controllers\Backend\Reference;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Backend\Sell\SellInvoice;

class ReferenceHistoryController extends Controller
{
    
    public function referenceWiseSellList($id)
    {
        $data['sellInvoices'] = SellInvoice::where('reference_id',$id)->latest()->paginate(50);
        
        $sellInvoice = SellInvoice::select('total_payable_amount','total_paid_amount','total_due_amount','total_discount_amount')->where('reference_id',$id)->get();
        $data['totalPayableAmount'] = $sellInvoice->sum('total_payable_amount');
        $data['totalPaidAmount'] = $sellInvoice->sum('total_paid_amount');
        $data['totalDueAmount'] = $sellInvoice->sum('total_due_amount');
        $data['totalDiscountAmount'] = $sellInvoice->sum('total_discount_amount');
        return view('backend.reference.referenceHistory.sell.list',$data);   
    }


}
