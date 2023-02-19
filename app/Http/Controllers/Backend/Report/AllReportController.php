<?php

namespace App\Http\Controllers\Backend\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AllReportController extends Controller
{
    public function dalilyReportSummary(){
        return view('backend.report.daily.daily');
    } 
    
    public function dalilyTransactionalReportSummary(){
        return view('backend.report.daily.daily_report');
    }
}
