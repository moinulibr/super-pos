<?php
namespace App\Traits\Backend\Payment;

use App\Models\Backend\Customer\CustomerTransactionHistory;
use App\Models\Backend\Payment\AccountPayment;




/**
 * Stock changing trait
 * 
 */
trait CustomerPaymentProcessTrait
{
    //use Stock;

    protected $processingOfAllCustomerTransactionRequestData;

    //customer transaction statement, transaction type == tt
    protected $ctsTTModuleId;
    protected $ctsCustomerId;
    protected $ttModuleInvoicsDataArrayFormated;
    protected $ctsCdsTypeId;
    protected $amount;
    protected $ctsCurrentPaymentAmount;

    private $ctsPaymentChangingAmount;
    private $ctsPaymentMainAmount;
    private $ctsCdsChangingTypeId;

    
    /*
    * Processing Payment
    */
    public function processingOfAllCustomerTransaction()
    {   
        $this->insertCustomerTransactionHistory();
        return true;
    }

    //insert account payment invoice
    protected function insertCustomerTransactionHistory()
    {   
        $lastAmountOfThisCustomer = $this->lastCdcAmountWithCalculation();;
        
        $customerTransaction = new CustomerTransactionHistory();
        $rand = rand(01,99);
        $makeInvoice = date("iHsymd").$rand;
        $customerTransaction->branch_id = authBranch_hh();
      
        $customerTransaction->ledger_page_no =  $this->processingOfAllCustomerTransactionRequestData['ledger_page_no'];
        $customerTransaction->next_payment_date = $this->processingOfAllCustomerTransactionRequestData['next_payment_date'] ? date('Y-m-d',strtotime($this->processingOfAllCustomerTransactionRequestData['next_payment_date'])) : NULL;
        $customerTransaction->created_date = date('Y-m-d');
        $customerTransaction->tt_module_id = $this->ctsTTModuleId;
        
        $customerTransaction->tt_module_invoice_no = $this->ttModuleInvoicsDataArrayFormated['invoice_no'];
        $customerTransaction->tt_module_invoice_id = $this->ttModuleInvoicsDataArrayFormated['invoice_id'];
        
        $customerTransaction->tt_main_module_invoice_no = $this->ttModuleInvoicsDataArrayFormated['tt_main_module_invoice_no'];
        $customerTransaction->tt_main_module_invoice_id = $this->ttModuleInvoicsDataArrayFormated['tt_main_module_invoice_id'];
        
        $customerTransaction->cdf_type_id = $this->ctsCdsTypeId;
        $customerTransaction->amount = $this->ctsPaymentMainAmount;//$this->amount;
        $customerTransaction->sell_amount = $this->processingOfAllCustomerTransactionRequestData['sell_amount'];
        $customerTransaction->sell_paid = $this->processingOfAllCustomerTransactionRequestData['sell_paid'];
        $customerTransaction->sell_due = $this->processingOfAllCustomerTransactionRequestData['sell_due'];
        $customerTransaction->user_id = $this->ctsCustomerId;
        $customerTransaction->received_by = authId_hh();
        $customerTransaction->short_note = $this->processingOfAllCustomerTransactionRequestData['short_note'];
        $customerTransaction->save();

        
        $customerTransaction->cdc_amount = $lastAmountOfThisCustomer;
        $customerTransaction->save();
        return $customerTransaction;
    }

    //this method will be called : begin of the line
    private function lastCdcAmountWithCalculation(){

        $lastPaymentAmount = CustomerTransactionHistory::select('cdc_amount','user_id')->where('user_id',$this->ctsCustomerId)->latest()->first();
        if($lastPaymentAmount)
        {
            $lastAmount = $lastPaymentAmount->cdc_amount;
        }else{
            $lastAmount = 0;
        }

        $mainAmount = 0;
        $changingAmount = 0;
        $changeAmountWithCalculation = $lastAmount;
        $ctsCdfType = $this->ctsCdsTypeId;
        if(getCTSModuleBySingleModuleId_hp($this->ctsTTModuleId) == 'Sell'){
            $mainAmount = $this->processingOfAllCustomerTransactionRequestData['sell_due'];;
            $changingAmount = $this->processingOfAllCustomerTransactionRequestData['sell_due'];
            $changeAmountWithCalculation = $lastAmount + $changingAmount;
            $ctsCdfType = 2;//$this->ctsCdsTypeId; //plus or minus +/-
        } 
        else if(getCTSModuleBySingleModuleId_hp($this->ctsTTModuleId) == 'Previous Due'){
            $mainAmount = $this->amount;
            $changingAmount = $this->amount;
            $changeAmountWithCalculation = $lastAmount + $changingAmount;
            $ctsCdfType = 2;//$this->ctsCdsTypeId; //plus or minus +/-
        }
        else if(getCTSModuleBySingleModuleId_hp($this->ctsTTModuleId) == 'Sell Return'){
            $mainAmount = $this->amount;
            $changingAmount = $this->sellReturnFormulaCalculation();
            $changeAmountWithCalculation = $lastAmount - $changingAmount;
            $ctsCdfType = 1;//$this->ctsCdsTypeId; //plus or minus +/-
        }
        else if(getCTSModuleBySingleModuleId_hp($this->ctsTTModuleId) == 'Quotation'){
            $mainAmount = $this->amount;
            $changingAmount = 0;
            $changeAmountWithCalculation = $lastAmount + $changingAmount;
            $ctsCdfType = 3;//no change
        }
        else if(getCTSModuleBySingleModuleId_hp($this->ctsTTModuleId) == 'Sell Due Payment'){
            $mainAmount = $this->amount;
            $changingAmount = $this->amount;//$this->commonFormulaCalculation($ttModuleIdDue = 2,$ttModuleIdPaid = 7);
            $changeAmountWithCalculation = $lastAmount - $changingAmount;
            $ctsCdfType = 1;//Paid    => 2= sell due , 7= sell due payment
        }
        else if(getCTSModuleBySingleModuleId_hp($this->ctsTTModuleId) == 'Previous Due Payment'){
            $mainAmount = $this->amount;
            $changingAmount = $this->commonFormulaCalculation($ttModuleIdDue = 1,$ttModuleIdPaid = 8);
            $changeAmountWithCalculation = $lastAmount - $changingAmount;
            $ctsCdfType = 1;//Paid    => 1= Previous Due , 8=Previous Due Payment
        }
        else if(getCTSModuleBySingleModuleId_hp($this->ctsTTModuleId) == 'Change Payment Date'){
            $mainAmount = $this->amount;
            $changingAmount = 0;
            $changeAmountWithCalculation = $lastAmount + $changingAmount;
            $ctsCdfType = 3;//no change
        }
        else if(getCTSModuleBySingleModuleId_hp($this->ctsTTModuleId) == 'Overall Sell Discount'){
            $mainAmount = $this->amount;
            $changingAmount = $this->commonFormulaCalculation($ttModuleIdDue = 2,$ttModuleIdPaid = 11);
            $changeAmountWithCalculation = $lastAmount - $changingAmount;
            $ctsCdfType = 1;//Paid   => 2= sell due , 7= Overall Sell Discount
        }
        else if(getCTSModuleBySingleModuleId_hp($this->ctsTTModuleId) == 'Advance'){
            $mainAmount = $this->amount;
            $changingAmount = $this->amount;//$this->commonFormulaCalculation($ttModuleIdDue = 2,$ttModuleIdPaid = 5);
            $changeAmountWithCalculation = $lastAmount - $changingAmount;
            $ctsCdfType = 1;//Paid
        }
        else if(getCTSModuleBySingleModuleId_hp($this->ctsTTModuleId) == 'Loan'){
            $mainAmount = $this->amount;
            $changingAmount = $this->amount;//$this->commonFormulaCalculation($ttModuleIdDue = 2,$ttModuleIdPaid = 4);
            $changeAmountWithCalculation = $lastAmount + $changingAmount;
            $ctsCdfType = 2;//Due
        }
        else if(getCTSModuleBySingleModuleId_hp($this->ctsTTModuleId) == 'Sell Return Payment'){
            //next time maybe implement. not now
            $mainAmount = $this->amount;
            $changingAmount = $this->amount;
            $changeAmountWithCalculation = $lastAmount - $changingAmount;
            $ctsCdfType = 1;//Paid   => 
        }
        else if(getCTSModuleBySingleModuleId_hp($this->ctsTTModuleId) == 'Loan Payment'){
            //next time maybe implement. not now
            $mainAmount = $this->amount;
            $changingAmount = 0;
            $changeAmountWithCalculation = $lastAmount - $changingAmount;
            $ctsCdfType = 1;//Paid
        }else if(getCTSModuleBySingleModuleId_hp($this->ctsTTModuleId) == 'Advance Payment'){
            //next time maybe implement. not now
            $mainAmount = $this->amount;
            $changingAmount = 0;
            $changeAmountWithCalculation = $lastAmount + $changingAmount;
            $ctsCdfType = 2;//Due
        }
        $this->ctsPaymentMainAmount = $mainAmount;
        $this->ctsCdsChangingTypeId = $ctsCdfType;
        return $this->ctsPaymentChangingAmount = $changeAmountWithCalculation;

        allCTSModule_hp();//its when check only
        getCTSModuleBySingleModuleId_hp($this->ctsTTModuleId);//its when check only
    }

    //sell return calculation formula
    private function sellReturnFormulaCalculation(){
        $sellInvoiceId = $this->ttModuleInvoicsDataArrayFormated['tt_main_module_invoice_id'];
        $sellCreatingTime = CustomerTransactionHistory::select('tt_main_module_invoice_id','user_id','sell_amount','sell_paid','sell_due','tt_module_id','cdf_type_id')
        ->where('user_id',$this->ctsCustomerId)
        ->where('tt_module_id',2)//sell creating time - sell due
        ->where('tt_main_module_invoice_id',$sellInvoiceId)
        ->get();

        $sellDueReceiveAmount = CustomerTransactionHistory::select('tt_main_module_invoice_id','user_id','amount','tt_module_id','cdf_type_id')
        ->where('user_id',$this->ctsCustomerId)
        ->where('tt_module_id',7)//Sell Due Payment
        ->where('tt_main_module_invoice_id',$sellInvoiceId)
        ->sum('amount');

        $sellOverallDiscountAmount = CustomerTransactionHistory::select('tt_main_module_invoice_id','user_id','amount','tt_module_id','cdf_type_id')
        ->where('user_id',$this->ctsCustomerId)
        ->where('tt_module_id',11) //"Overall Sell Discount",
        ->where('tt_main_module_invoice_id',$sellInvoiceId)
        ->sum('amount');

        $sellTotalReturnAmount = CustomerTransactionHistory::select('tt_main_module_invoice_id','user_id','amount','tt_module_id','cdf_type_id')
        ->where('user_id',$this->ctsCustomerId)
        ->where('tt_module_id',6)//"Sell Return",
        ->where('tt_main_module_invoice_id',$sellInvoiceId)
        ->sum('amount');

        $totalSellInvoiceAmount = $sellCreatingTime->sum('sell_amount') - ( $sellTotalReturnAmount + $sellOverallDiscountAmount);
        $getTotalSellInvoicePaidAmount = $sellCreatingTime->sum('sell_paid') + $sellDueReceiveAmount;
        
        $totalSellInvoicePaidAmount = $getTotalSellInvoicePaidAmount;
        if($totalSellInvoiceAmount > $getTotalSellInvoicePaidAmount){
            $totalSellInvoicePaidAmount = $getTotalSellInvoicePaidAmount;
        } 
        else if($totalSellInvoiceAmount < $getTotalSellInvoicePaidAmount){
            $totalSellInvoicePaidAmount = $totalSellInvoiceAmount;
        }
        else if($totalSellInvoiceAmount == $getTotalSellInvoicePaidAmount){
            $totalSellInvoicePaidAmount = $totalSellInvoiceAmount;
        }
        $totalSellInvoiceDueAmount = $totalSellInvoiceAmount - $totalSellInvoicePaidAmount ;// $sellCreatingTime->sum('sell_due');

        $returnAmount = 0;
        if($totalSellInvoiceDueAmount > 0 ){
            if($totalSellInvoiceDueAmount == $this->amount){
                $returnAmount = $totalSellInvoiceDueAmount;
            }
            else if($totalSellInvoiceDueAmount > $this->amount){
                $returnAmount = $this->amount;
            }
            else if( $totalSellInvoiceDueAmount < $this->amount){
                $returnAmount = $totalSellInvoiceDueAmount;
            }
        }else{
            $returnAmount = 0;
        }
        return $returnAmount;
    }

    //make all formula for all module
    private function commonFormulaCalculation($ttModuleIdDue,$ttModuleIdPaid){
        $totalFirstTimeDueAmount = CustomerTransactionHistory::select('user_id','amount','tt_module_id','cdf_type_id')
                            ->where('user_id',$this->ctsCustomerId)
                            ->where('tt_module_id',$ttModuleIdDue)
                            ->sum('amount');
        $totalPaidAmount = CustomerTransactionHistory::select('user_id','amount','tt_module_id','cdf_type_id')
                            ->where('user_id',$this->ctsCustomerId)
                            ->where('tt_module_id',$ttModuleIdPaid)
                            ->sum('amount');
        $totalDueAmount = $totalFirstTimeDueAmount - $totalPaidAmount;

        $changeableAmount = 0;
        if($totalDueAmount > 0){
            $dueChangeAmount = 0;
            if($totalDueAmount == $this->amount){
                $dueChangeAmount = $totalDueAmount;
            }
            else if($totalDueAmount > $this->amount){
                $dueChangeAmount = $this->amount;
            }
            else if($totalDueAmount < $this->amount){
                $dueChangeAmount = $totalDueAmount;
            }
            $changeableAmount = $dueChangeAmount;
        }else{
            $changeableAmount = 0;
        }
        return $changeableAmount;
    }




}
