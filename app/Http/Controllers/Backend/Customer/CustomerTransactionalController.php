<?php

namespace App\Http\Controllers\Backend\Customer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Traits\Permission\Permission;
use App\Models\Backend\Sell\SellInvoice;
use App\Models\Backend\Customer\Customer;
use App\Traits\Backend\Payment\PaymentProcessTrait;

use App\Models\Backend\Customer\CustomerTransactionHistory;

use App\Traits\Backend\Payment\CustomerPaymentProcessTrait;

use App\Traits\Backend\Sell\Logical\UpdateSellSummaryCalculationTrait;
use App\Traits\Backend\Customer\Logical\ManagingCalculationOfCustomerSummaryTrait;

class CustomerTransactionalController extends Controller
{
    use CustomerPaymentProcessTrait, PaymentProcessTrait, ManagingCalculationOfCustomerSummaryTrait;
    use UpdateSellSummaryCalculationTrait;


    public function history($id)
    {
        //return $this->managingCustomerCalculation($customerId=2,$dbField='total_due',$calType='plus',$amount=10);
        $data['customer'] = Customer::findOrFail($id);
        return view('backend.customer.customer.history.history',$data);
    }

    public function customerTransactionalStatement(Request $request)
    {
        $data['customer'] = Customer::findOrFail($request->id);
        $data['customerTransactionalBalanceSummary'] = CustomerTransactionHistory::select('user_id','cdc_amount')->where('user_id',$request->id)->latest()->first();
        $transactionalSummary =  view('backend.customer.customer.history.transactional_summary',$data)->render();
        $transactionalStatement =  view('backend.customer.customer.history.transactional_statement',$data)->render();
        return response()->json([
            'status' => true,
            'type' => 'success',
            'message' => "Customer updated successfully",
            'transactionalSummary' => $transactionalSummary,
            'transactionalStatement' => $transactionalStatement,
        ]);
    }

    //render next payment data
    public function renderNextPaymentDateModal(Request $request)
    {
        $data['customer'] = Customer::select('id','next_payment_date')->findOrFail($request->id);
        $view =  view('backend.customer.customer.transactionHistory.next_payment_date',$data)->render();
        return response()->json([
            'status' => true,
            'type' => 'success',
            'view' => $view,
        ]);
    }
    //store next payment data
    public function storeNextPaymentDate(Request $request)
    {
        DB::beginTransaction();
        try {
            $data['customer'] = Customer::select('id','next_payment_date')->findOrFail($request->customer_id);
            $data['customer']->update(['next_payment_date'=>$request->next_payment_date]);
    
            $this->processingOfAllCustomerTransactionRequestData = customerTransactionRequestDataProcessing_hp($request);
            $this->amount = 0;
            $this->ctsTTModuleId = getCTSModuleIdBySingleModuleLebel_hp('Change Payment Date');
            $this->ctsCustomerId = $request->customer_id;
            $ttModuleInvoics = [
                'invoice_no' => NULL,
                'invoice_id' => NULL,
                'tt_main_module_invoice_no' => NULL,
                'tt_main_module_invoice_id' => NULL,
            ];
            $this->ttModuleInvoicsDataArrayFormated = $ttModuleInvoics;
            $this->ctsCdsTypeId = getCTSCdfIdBySingleCdfLebel_hp('-');
            $this->processingOfAllCustomerTransaction();
            DB::commit();
            return response()->json([
                'status' => true,
                'type' => 'success',
                'message' => "Next payment date store successfully",
            ]);
        } catch (\Exception  $e) {
            DB::rollback();
            throw $e;
            return response()->json([
                'status' => 'exception',
                'type' => 'warning',
                'message'=>  $e->getMessage()
            ]);
        }
    }


    //add loan
    public function renderAddLoanModal(Request $request)
    {
        $data['customer'] = Customer::select('id','total_loan')->findOrFail($request->id);
        $view =  view('backend.customer.customer.transactionHistory.add_loan',$data)->render();
        return response()->json([
            'status' => true,
            'type' => 'success',
            'view' => $view,
        ]);
    }
    //store loan data
    public function storeAddLoanData(Request $request)
    {
        DB::beginTransaction();
        try {
            //$data['customer'] = Customer::select('id','next_payment_date')->findOrFail($request->customer_id);
            //$data['customer']->update(['next_payment_date'=>$request->next_payment_date]);
    
            //payment process
            if(($request->amount ?? 0) > 0){
                //for payment processing 
                $this->mainPaymentModuleId = getModuleIdBySingleModuleLebel_hh('Customer Loan');
                $this->paymentModuleId = getModuleIdBySingleModuleLebel_hh('Customer Loan');
                $this->paymentCdfTypeId = getCdfIdBySingleCdfLebel_hh('Debit');
                $moduleRelatedData = [
                    'main_module_invoice_no' => NULL,
                    'main_module_invoice_id' => NULL,
                    'module_invoice_no' => NULL,
                    'module_invoice_id' => NULL,
                    'user_id' => $request->customer_id,//client[customer,supplier,others staff]
                ];
                $this->paymentProcessingRequiredOfAllRequestOfModuleRelatedData = $moduleRelatedData;
                $this->paymentProcessingRelatedOfAllRequestData = paymentDataProcessingWhenSellingSubmitFromPos_hh($request);// $paymentAllData;
                $this->invoiceTotalPayingAmount = $request->amount ;
                $this->defaultCashPaymentProcessing();
                //for payment processing 
            } //payment process


            //customer transaction process
            $this->processingOfAllCustomerTransactionRequestData = customerTransactionRequestDataProcessing_hp($request);
            $this->amount = $request->amount;
            $this->ctsTTModuleId = getCTSModuleIdBySingleModuleLebel_hp('Loan');
            $this->ctsCustomerId = $request->customer_id;
            $ttModuleInvoics = [
                'invoice_no' => NULL,
                'invoice_id' => NULL,
                'tt_main_module_invoice_no' => NULL,
                'tt_main_module_invoice_id' => NULL,
            ];
            $this->ttModuleInvoicsDataArrayFormated = $ttModuleInvoics;
            $this->ctsCdsTypeId = getCTSCdfIdBySingleCdfLebel_hp('Due');
            $this->processingOfAllCustomerTransaction();
            //customer transaction process

            //calculation in the customer table
            //$dbField = 19;'current_loan';
            //$calType = 1='plus', 2='minus'
            $this->managingCustomerCalculation($request->customer_id,$dbField = 19 ,$calType = 1,$request->amount);
            //calculation in the customer table

            DB::commit();
            return response()->json([
                'status' => true,
                'type' => 'success',
                'message' => "Date store successfully",
            ]);
        } catch (\Exception  $e) {
            DB::rollback();
            throw $e;
            return response()->json([
                'status' => 'exception',
                'type' => 'warning',
                'message'=>  $e->getMessage()
            ]);
        }
    }


    //add advance
    public function renderAddAdvanceModal(Request $request)
    {
        $data['customer'] = Customer::select('id','total_advance')->findOrFail($request->id);
        $view =  view('backend.customer.customer.transactionHistory.add_advance',$data)->render();
        return response()->json([
            'status' => true,
            'type' => 'success',
            'view' => $view,
        ]);
    }
    //store advance
    public function storeAddAdvance(Request $request)
    {
        DB::beginTransaction();
        try {
            //$data['customer'] = Customer::select('id','total_advance')->findOrFail($request->customer_id);
            //$data['customer']->update(['next_payment_date'=>$request->next_payment_date]);
            
            //payment process
            if(($request->amount ?? 0) > 0){
                //for payment processing 
                $this->mainPaymentModuleId = getModuleIdBySingleModuleLebel_hh('Customer Advance');
                $this->paymentModuleId = getModuleIdBySingleModuleLebel_hh('Customer Advance');
                $this->paymentCdfTypeId = getCdfIdBySingleCdfLebel_hh('Credit');
                $moduleRelatedData = [
                    'main_module_invoice_no' => NULL,
                    'main_module_invoice_id' => NULL,
                    'module_invoice_no' => NULL,
                    'module_invoice_id' => NULL,
                    'user_id' => $request->customer_id,//client[customer,supplier,others staff]
                ];
                $this->paymentProcessingRequiredOfAllRequestOfModuleRelatedData = $moduleRelatedData;
                $this->paymentProcessingRelatedOfAllRequestData = paymentDataProcessingWhenSellingSubmitFromPos_hh($request);// $paymentAllData;
                $this->invoiceTotalPayingAmount = $request->amount ;
                $this->defaultCashPaymentProcessing();
                //for payment processing 
            } //payment process


            //customer transaction
            $this->processingOfAllCustomerTransactionRequestData = customerTransactionRequestDataProcessing_hp($request);
            $this->amount = $request->amount;
            $this->ctsTTModuleId = getCTSModuleIdBySingleModuleLebel_hp('Advance');
            $this->ctsCustomerId = $request->customer_id;
            $ttModuleInvoics = [
                'invoice_no' => NULL,
                'invoice_id' => NULL,
                'tt_main_module_invoice_no' => NULL,
                'tt_main_module_invoice_id' => NULL,
            ];
            $this->ttModuleInvoicsDataArrayFormated = $ttModuleInvoics;
            $this->ctsCdsTypeId = getCTSCdfIdBySingleCdfLebel_hp('Paid');
            $this->processingOfAllCustomerTransaction();

            //calculation in the customer table
            //$dbField = 18;'current_advance';
            //$calType = 1='plus', 2='minus'
            $this->managingCustomerCalculation($request->customer_id,$dbField = 18 ,$calType = 1,$request->amount);
            //calculation in the customer table
            
            DB::commit();
            return response()->json([
                'status' => true,
                'type' => 'success',
                'message' => "Date store successfully",
            ]);
        } catch (\Exception  $e) {
            DB::rollback();
            throw $e;
            return response()->json([
                'status' => 'exception',
                'type' => 'warning',
                'message'=>  $e->getMessage()
            ]);
        }
    }


    //receive previous data
    public function renderReceivePreviousDueModal(Request $request)
    {
        $data['customer'] = Customer::select('id','previous_total_due')->findOrFail($request->id);
        $view =  view('backend.customer.customer.transactionHistory.receive_previous_due',$data)->render();
        return response()->json([
            'status' => true,
            'type' => 'success',
            'view' => $view,
        ]);
    }
    //store receive previous data
    public function storeReceivePreviousDue(Request $request)
    {
        DB::beginTransaction();
        try {
            //$data['customer'] = Customer::select('id')->findOrFail($request->customer_id);
            //$data['customer']->update(['next_payment_date'=>$request->next_payment_date]);
    
            //payment process
            if(($request->amount ?? 0) > 0){
                //for payment processing 
                $this->mainPaymentModuleId = getModuleIdBySingleModuleLebel_hh('Receive Customer Previous Due');
                $this->paymentModuleId = getModuleIdBySingleModuleLebel_hh('Receive Customer Previous Due');
                $this->paymentCdfTypeId = getCdfIdBySingleCdfLebel_hh('Credit');
                $moduleRelatedData = [
                    'main_module_invoice_no' => NULL,
                    'main_module_invoice_id' => NULL,
                    'module_invoice_no' => NULL,
                    'module_invoice_id' => NULL,
                    'user_id' => $request->customer_id,//client[customer,supplier,others staff]
                ];
                $this->paymentProcessingRequiredOfAllRequestOfModuleRelatedData = $moduleRelatedData;
                $this->paymentProcessingRelatedOfAllRequestData = paymentDataProcessingWhenSellingSubmitFromPos_hh($request);// $paymentAllData;
                $this->invoiceTotalPayingAmount = $request->amount ;
                $this->defaultCashPaymentProcessing();
                //for payment processing 
            } //payment process


            //customer transaction
            $this->processingOfAllCustomerTransactionRequestData = customerTransactionRequestDataProcessing_hp($request);
            $this->amount = $request->amount;
            $this->ctsTTModuleId = getCTSModuleIdBySingleModuleLebel_hp('Previous Due Payment');
            $this->ctsCustomerId = $request->customer_id;
            $ttModuleInvoics = [
                'invoice_no' => NULL,
                'invoice_id' => NULL,
                'tt_main_module_invoice_no' => NULL,
                'tt_main_module_invoice_id' => NULL,
            ];
            $this->ttModuleInvoicsDataArrayFormated = $ttModuleInvoics;
            $this->ctsCdsTypeId = getCTSCdfIdBySingleCdfLebel_hp('Paid');
            $this->processingOfAllCustomerTransaction();

            //calculation in the customer table
            //$dbField = 9;'previous_due_paid_now';
            //$calType = 1='plus', 2='minus'
            $this->managingCustomerCalculation($request->customer_id,$dbField = 9 ,$calType = 1,$request->amount);
            //calculation in the customer table
            
            DB::commit();
            return response()->json([
                'status' => true,
                'type' => 'success',
                'message' => "Date store successfully",
            ]);
        } catch (\Exception  $e) {
            DB::rollback();
            throw $e;
            return response()->json([
                'status' => 'exception',
                'type' => 'warning',
                'message'=>  $e->getMessage()
            ]);
        }
    }



    //receive loan data
    public function renderReturnAdvanceAmountModal(Request $request)
    {
        $data['customer'] = Customer::select('id','total_advance')->findOrFail($request->id);
        $view =  view('backend.customer.customer.transactionHistory.return_advance_amount',$data)->render();
        return response()->json([
            'status' => true,
            'type' => 'success',
            'view' => $view,
        ]);
    }
    //store receive loan data
    public function storeReturnAdvanceAmount(Request $request)
    {
        DB::beginTransaction();
        try {
            //$data['customer'] = Customer::select('id')->findOrFail($request->customer_id);
            //$data['customer']->update(['next_payment_date'=>$request->next_payment_date]);
    
            //payment process
            if(($request->amount ?? 0) > 0){
                //for payment processing 
                $this->mainPaymentModuleId = getModuleIdBySingleModuleLebel_hh('Receive Customer Previous Due');
                $this->paymentModuleId = getModuleIdBySingleModuleLebel_hh('Receive Customer Previous Due');
                $this->paymentCdfTypeId = getCdfIdBySingleCdfLebel_hh('Credit');
                $moduleRelatedData = [
                    'main_module_invoice_no' => NULL,
                    'main_module_invoice_id' => NULL,
                    'module_invoice_no' => NULL,
                    'module_invoice_id' => NULL,
                    'user_id' => $request->customer_id,//client[customer,supplier,others staff]
                ];
                $this->paymentProcessingRequiredOfAllRequestOfModuleRelatedData = $moduleRelatedData;
                $this->paymentProcessingRelatedOfAllRequestData = paymentDataProcessingWhenSellingSubmitFromPos_hh($request);// $paymentAllData;
                $this->invoiceTotalPayingAmount = $request->amount ;
                $this->defaultCashPaymentProcessing();
                //for payment processing 
            } //payment process


            //customer transaction
            $this->processingOfAllCustomerTransactionRequestData = customerTransactionRequestDataProcessing_hp($request);
            $this->amount = $request->amount;
            $this->ctsTTModuleId = getCTSModuleIdBySingleModuleLebel_hp('Previous Due Payment');
            $this->ctsCustomerId = $request->customer_id;
            $ttModuleInvoics = [
                'invoice_no' => NULL,
                'invoice_id' => NULL,
                'tt_main_module_invoice_no' => NULL,
                'tt_main_module_invoice_id' => NULL,
            ];
            $this->ttModuleInvoicsDataArrayFormated = $ttModuleInvoics;
            $this->ctsCdsTypeId = getCTSCdfIdBySingleCdfLebel_hp('Paid');
            $this->processingOfAllCustomerTransaction();

            //calculation in the customer table
            //$dbField = 9;'previous_due_paid_now';
            //$calType = 1='plus', 2='minus'
            $this->managingCustomerCalculation($request->customer_id,$dbField = 9 ,$calType = 1,$request->amount);
            //calculation in the customer table
            
            DB::commit();
            return response()->json([
                'status' => true,
                'type' => 'success',
                'message' => "Date store successfully",
            ]);
        } catch (\Exception  $e) {
            DB::rollback();
            throw $e;
            return response()->json([
                'status' => 'exception',
                'type' => 'warning',
                'message'=>  $e->getMessage()
            ]);
        }
    }

    //receive loan data
    public function renderReceiveLoanAmountModal(Request $request)
    {
        $data['customer'] = Customer::select('id','total_loan')->findOrFail($request->id);
        $view =  view('backend.customer.customer.transactionHistory.receive_loan_amount',$data)->render();
        return response()->json([
            'status' => true,
            'type' => 'success',
            'view' => $view,
        ]);
    }
    //store receive loan data
    public function storeReceiveLoanAmount(Request $request)
    {
        DB::beginTransaction();
        try {
            //$data['customer'] = Customer::select('id')->findOrFail($request->customer_id);
            //$data['customer']->update(['next_payment_date'=>$request->next_payment_date]);
    
            //payment process
            if(($request->amount ?? 0) > 0){
                //for payment processing 
                $this->mainPaymentModuleId = getModuleIdBySingleModuleLebel_hh('Receive Customer Previous Due');
                $this->paymentModuleId = getModuleIdBySingleModuleLebel_hh('Receive Customer Previous Due');
                $this->paymentCdfTypeId = getCdfIdBySingleCdfLebel_hh('Credit');
                $moduleRelatedData = [
                    'main_module_invoice_no' => NULL,
                    'main_module_invoice_id' => NULL,
                    'module_invoice_no' => NULL,
                    'module_invoice_id' => NULL,
                    'user_id' => $request->customer_id,//client[customer,supplier,others staff]
                ];
                $this->paymentProcessingRequiredOfAllRequestOfModuleRelatedData = $moduleRelatedData;
                $this->paymentProcessingRelatedOfAllRequestData = paymentDataProcessingWhenSellingSubmitFromPos_hh($request);// $paymentAllData;
                $this->invoiceTotalPayingAmount = $request->amount ;
                $this->defaultCashPaymentProcessing();
                //for payment processing 
            } //payment process


            //customer transaction
            $this->processingOfAllCustomerTransactionRequestData = customerTransactionRequestDataProcessing_hp($request);
            $this->amount = $request->amount;
            $this->ctsTTModuleId = getCTSModuleIdBySingleModuleLebel_hp('Previous Due Payment');
            $this->ctsCustomerId = $request->customer_id;
            $ttModuleInvoics = [
                'invoice_no' => NULL,
                'invoice_id' => NULL,
                'tt_main_module_invoice_no' => NULL,
                'tt_main_module_invoice_id' => NULL,
            ];
            $this->ttModuleInvoicsDataArrayFormated = $ttModuleInvoics;
            $this->ctsCdsTypeId = getCTSCdfIdBySingleCdfLebel_hp('Paid');
            $this->processingOfAllCustomerTransaction();

            //calculation in the customer table
            //$dbField = 9;'previous_due_paid_now';
            //$calType = 1='plus', 2='minus'
            $this->managingCustomerCalculation($request->customer_id,$dbField = 9 ,$calType = 1,$request->amount);
            //calculation in the customer table
            
            DB::commit();
            return response()->json([
                'status' => true,
                'type' => 'success',
                'message' => "Date store successfully",
            ]);
        } catch (\Exception  $e) {
            DB::rollback();
            throw $e;
            return response()->json([
                'status' => 'exception',
                'type' => 'warning',
                'message'=>  $e->getMessage()
            ]);
        }
    }


    //=======================================
    //render.receive.all.invoice.dues.modal
    //store.receiving.all.invoice.dues
    //receive loan data
    public function renderReceiveAllInvoiceDueModal(Request $request)
    {
        $data['customer'] = Customer::select('id','total_due','previous_total_due','name','phone','address')->findOrFail($request->id);
        $data['sellInvoices'] = SellInvoice::select('total_profit','payment_status','invoice_no','id','customer_id','total_due_amount','total_paid_amount','total_payable_amount','sell_date')->where('total_payable_amount','>',0)->whereIn('payment_status',[2,3])->where('customer_id',$request->id)->latest()->get();
        $view =  view('backend.customer.customer.transactionHistory.receive_all_invoice_due',$data)->render();
        return response()->json([
            'status' => true,
            'type' => 'success',
            'view' => $view,
        ]);
    }
    public function storeReceivingAllInvoiceDues(Request $request)
    {   
        ini_set('max_execution_time', 600); 
        DB::beginTransaction();
        try {
            //$data['customer'] = Customer::select('id')->findOrFail($request->customer_id);
            //$data['customer']->update(['next_payment_date'=>$request->next_payment_date]);
            
            /*
            |-----------------------------------------
            | Sell Due Payment Receive
            |-----------------------------------------
            */
                if(isset($request->checked_id)){

                    foreach($request->checked_id as $id){

                        if($request->input('single_invoice_paying_amount_'.$id) > 0){
                          
                            $invoiceData = SellInvoice::select('id','paid_amount','due_amount','total_paid_amount','total_due_amount')->where('id',$id)->first();
                            //change amount from sellinvoice 
                            $invoiceData->paid_amount = $invoiceData->paid_amount + $request->input('single_invoice_paying_amount_'.$id) ?? 0;
                            $invoiceData->due_amount = $invoiceData->due_amount - $request->input('single_invoice_paying_amount_'.$id) ?? 0;
                            $invoiceData->total_due_amount = $invoiceData->total_due_amount - $request->input('single_invoice_paying_amount_'.$id) ?? 0;
                            $invoiceData->total_paid_amount = $invoiceData->total_paid_amount + $request->input('single_invoice_paying_amount_'.$id) ?? 0;
                            $invoiceData->save();
                            $this->updateSellInvoiceCalculation($id);
                           
                            /*
                            |-----------------------------------------
                            | payment process : general
                            |-----------------------------------------
                            */
                                if($request->input('single_invoice_paying_amount_'.$id) > 0){
                                    //for payment processing 
                                    $this->mainPaymentModuleId = getModuleIdBySingleModuleLebel_hh('Sell');
                                    $this->paymentModuleId = getModuleIdBySingleModuleLebel_hh('Receive Sell Due');
                                    $this->paymentCdfTypeId = getCdfIdBySingleCdfLebel_hh('Credit');
                                    $moduleRelatedData = [
                                        'main_module_invoice_no' => $request->input('single_invoice_no_'.$id),
                                        'main_module_invoice_id' => $id,
                                        'module_invoice_no' => $request->input('single_invoice_no_'.$id),
                                        'module_invoice_id' => $id,
                                        'user_id' => $request->customer_id,//client[customer,supplier,others staff]
                                    ];
                                    $this->paymentProcessingRequiredOfAllRequestOfModuleRelatedData = $moduleRelatedData;
                                    $this->paymentProcessingRelatedOfAllRequestData = paymentDataProcessingWhenSellingSubmitFromPos_hh($request);// $paymentAllData;
                                    $this->invoiceTotalPayingAmount = $request->input('single_invoice_paying_amount_'.$id);
                                    $this->defaultCashPaymentProcessing();
                                    //for payment processing 
                                }
                            /*
                            |-----------------------------------------
                            | payment process : general
                            |-----------------------------------------
                            */
                            
                            /*
                            |-----------------------------------------
                            | customer transaction
                            |-----------------------------------------
                            */
                                $requestCTSData = [];
                                $requestCTSData['amount'] = $request->input('single_invoice_paying_amount_'.$id);
                                $requestCTSData['ledger_page_no'] = NULL;
                                $requestCTSData['next_payment_date'] = NULL;
                                $requestCTSData['short_note'] = "Sell Due Payment";
                                $requestCTSData['sell_amount'] = 0;
                                $requestCTSData['sell_paid'] = 0;
                                $requestCTSData['sell_due'] = 0;
                                $this->processingOfAllCustomerTransactionRequestData = customerTransactionRequestDataProcessing_hp($requestCTSData);
                                $this->amount = $request->input('single_invoice_paying_amount_'.$id);
                                $this->ctsTTModuleId = getCTSModuleIdBySingleModuleLebel_hp('Sell Due Payment');
                                $this->ctsCustomerId = $request->customer_id;
                                $ttModuleInvoics = [
                                    'invoice_no' => $request->input('single_invoice_no_'.$id),
                                    'invoice_id' => $id,
                                    'tt_main_module_invoice_no' => $request->input('single_invoice_no_'.$id),
                                    'tt_main_module_invoice_id' => $id,
                                ];
                                $this->ttModuleInvoicsDataArrayFormated = $ttModuleInvoics;
                                $this->ctsCdsTypeId = getCTSCdfIdBySingleCdfLebel_hp('Paid');
                                $this->processingOfAllCustomerTransaction();
                            /*
                            |-----------------------------------------
                            | customer transaction
                            |-----------------------------------------
                            */

                            /*
                            |-----------------------------------------
                            | customer table calculation
                            |-----------------------------------------
                            */
                                //calculation in the customer table
                                //$dbField = 21;'current_paid_due';
                                //$calType = 1='plus', 2='minus'
                                $this->managingCustomerCalculation($request->customer_id,$dbField = 21 ,$calType = 1, $request->input('single_invoice_paying_amount_'.$id));
                                //calculation in the customer table
                            /*
                            |-----------------------------------------
                            | customer table calculation
                            |-----------------------------------------
                            */
                        }//end if
                        
                    }//end foreach  
                }//end if
            /*
            |-----------------------------------------
            | Sell Due Payment Receive
            |-----------------------------------------
            */

            
            /*
            |------------------------------------------------------
            |------------------------------------------------------
            | Overall Discount
            |-----------------------------------------
            */
                if(isset($request->checked_overall_discount_id)){
                    foreach($request->checked_overall_discount_id as $overallId){

                        if($request->input('single_invoice_overall_discount_amount_'.$overallId) > 0){
                        
                            $invoiceData = SellInvoice::select('id','invoice_no','overall_discount_amount','paid_amount','due_amount','total_paid_amount','total_due_amount')->where('id',$overallId)->first();                 
                            $overallDiscountAmountPerInvoice = $request->input('single_invoice_overall_discount_amount_'.$overallId);

                            $totalOverallDiscountAmount = 0;
                            if($invoiceData->total_due_amount >  $overallDiscountAmountPerInvoice) {
                                $totalOverallDiscountAmount = 0 ;
                            }
                            else if($invoiceData->total_due_amount <  $overallDiscountAmountPerInvoice) {
                                $totalOverallDiscountAmount = $overallDiscountAmountPerInvoice - $invoiceData->total_due_amount;
                            }
                            else if($invoiceData->total_due_amount ==  $overallDiscountAmountPerInvoice) {
                                $totalOverallDiscountAmount = 0;
                            }
                            //change amount from sellinvoice 
                            //$invoiceData->paid_amount = $invoiceData->paid_amount + $request->invoice_total_paying_amount ?? 0;
                            //$invoiceData->due_amount = $invoiceData->due_amount - $request->invoice_total_paying_amount ?? 0;
                            $invoiceData->overall_discount_amount =  $overallDiscountAmountPerInvoice ?? 0;
                            $invoiceData->save();
                            $this->updateSellInvoiceCalculation($invoiceData->id);

    
                            /*
                            |----------------------------------------------
                            | payment process : general:- overall discount
                            |-----------------------------------------
                            */
                                if($totalOverallDiscountAmount > 0){
                                    //for payment processing 
                                    $this->mainPaymentModuleId = getModuleIdBySingleModuleLebel_hh('Sell');
                                    $this->paymentModuleId = getModuleIdBySingleModuleLebel_hh('Overall Sell Discount');
                                    $this->paymentCdfTypeId = getCdfIdBySingleCdfLebel_hh('Debit');
                                    $moduleRelatedData = [
                                        'main_module_invoice_no' => $invoiceData->invoice_no,
                                        'main_module_invoice_id' => $invoiceData->id,
                                        'module_invoice_no' => $invoiceData->invoice_no,
                                        'module_invoice_id' => $invoiceData->id,
                                        'user_id' => $request->customer_id,//client[customer,supplier,others staff]
                                    ];
                                    $this->paymentProcessingRequiredOfAllRequestOfModuleRelatedData = $moduleRelatedData;
                                    $this->paymentProcessingRelatedOfAllRequestData = paymentDataProcessingWhenSellingSubmitFromPos_hh($request);// $paymentAllData;
                                    $this->invoiceTotalPayingAmount = $overallDiscountAmountPerInvoice ?? 0 ;
                                    $this->defaultCashPaymentProcessing();
                                }
                            /*
                            |----------------------------------------------
                            | payment process : general:- overall discount
                            |----------------------------------------------
                            */
                            
                            /*
                            |-----------------------------------------
                            | customer transaction : Overall Discount
                            |-----------------------------------------
                            */
                                $requestCTSData = [];
                                $requestCTSData['amount'] = $overallDiscountAmountPerInvoice ?? 0 ;
                                $requestCTSData['ledger_page_no'] = NULL;
                                $requestCTSData['next_payment_date'] = NULL;
                                $requestCTSData['short_note'] = "Overall Sell Discount";
                                $requestCTSData['sell_amount'] = 0;
                                $requestCTSData['sell_paid'] = 0;
                                $requestCTSData['sell_due'] = 0;
                                $this->processingOfAllCustomerTransactionRequestData = customerTransactionRequestDataProcessing_hp($requestCTSData);
                                $this->amount = $overallDiscountAmountPerInvoice ?? 0 ;
                                
                                $this->ctsTTModuleId = getCTSModuleIdBySingleModuleLebel_hp('Overall Sell Discount');
                                $this->ctsCustomerId = $request->customer_id;
                                $ttModuleInvoics = [
                                    'invoice_no' => $invoiceData->invoice_no,
                                    'invoice_id' => $invoiceData->id,

                                    'tt_main_module_invoice_no' => $invoiceData->invoice_no,
                                    'tt_main_module_invoice_id' => $invoiceData->id,
                                ];
                                $this->ttModuleInvoicsDataArrayFormated = $ttModuleInvoics;
                                $this->ctsCdsTypeId = getCTSCdfIdBySingleCdfLebel_hp('Paid');
                                $this->processingOfAllCustomerTransaction();
                            /*
                            |-----------------------------------------
                            | customer transaction : Overall Discount
                            |-----------------------------------------
                            */
                            //calculation in the customer table
                            //$dbField = 38;'total_discount_amount';
                            //$calType = 1='plus', 2='minus'
                            $this->updateCustomerSpecificField($request->customer_id,$dbField = 38 ,$calType = 1,$overallDiscountAmountPerInvoice ?? 0 );


                            /*
                            |-----------------------------------------
                            | customer table calculation
                            |-----------------------------------------
                            */
                                //calculation in the customer table
                                //$dbField = 21;'current_paid_due';
                                //$calType = 1='plus', 2='minus'
                                $this->managingCustomerCalculation($request->customer_id,$dbField = 21 ,$calType = 1, $overallDiscountAmountPerInvoice ?? 0);
                                //calculation in the customer table
                            /*
                            |-----------------------------------------
                            | customer table calculation
                            |-----------------------------------------
                            */
                        }//end if

                    }//end foreach
                }//end if - isset
            /*
            |------------------------------------------------------
            | Overall Discount
            |-----------------------------------------------------
            |------------------------------------------------------
            */



            /*
            |-----------------------------------------
            | customer transaction : Next payment date
            |-----------------------------------------
            */
                if($request->total_paying_amount <  $request->total_customer_due_amount && 
                    $request->next_payment_date != NULL && $request->overall_total_discount_or_remaining_amount > 0
                ){
                    $data['customer'] = Customer::select('id','next_payment_date')->findOrFail($request->customer_id);
                    $data['customer']->update(['next_payment_date'=>$request->next_payment_date]);
            
                    $this->processingOfAllCustomerTransactionRequestData = customerTransactionRequestDataProcessing_hp($request);
                    $this->amount = 0;
                    $this->ctsTTModuleId = getCTSModuleIdBySingleModuleLebel_hp('Change Payment Date');
                    $this->ctsCustomerId = $request->customer_id;
                    $ttModuleInvoics = [
                        'invoice_no' => NULL,
                        'invoice_id' => NULL,
                        'tt_main_module_invoice_no' => NULL,
                        'tt_main_module_invoice_id' => NULL,
                    ];
                    $this->ttModuleInvoicsDataArrayFormated = $ttModuleInvoics;
                    $this->ctsCdsTypeId = getCTSCdfIdBySingleCdfLebel_hp('-');
                    $this->processingOfAllCustomerTransaction();
                }
            /*
            |-----------------------------------------
            | customer transaction : Next payment date
            |-----------------------------------------
            */
           

            DB::commit();
            return response()->json([
                'status' => true,
                'type' => 'success',
                'message' => "Date store successfully",
            ]);
        } catch (\Exception  $e) {
            DB::rollback();
            throw $e;
            return response()->json([
                'status' => 'exception',
                'type' => 'warning',
                'message'=>  $e->getMessage()
            ]);
        }

        /* 
            return $request;
            $request->customer_given_amount;
            $request->current_total_paying_amount;
            $request->customer_id;
            $request->checked_id;
            $request->checked_overall_discount_id;
            $request->overall_discount_remaining_Type;
            $request->overall_total_discount_or_remaining_amount;
            $request->sell_invoice_id;
            $request->single_invoice_due_amount_461;
            $request->input('single_invoice_due_amount_');
            $request->single_invoice_profit_amount_461;
            $request->input('single_invoice_profit_amount_');
            $request->single_invoice_paying_amount_461;
            $request->input('single_invoice_paying_amount_');//paying due amount now
            $request->single_invoice_overall_discount_amount_465;
            $request->input('single_invoice_overall_discount_amount_');//overall paying amount now
            $request->total_current_due_amount; //current due amount
            $request->total_customer_due_amount;
            $request->total_overall_discount_amount;//overall discount amount
            $request->total_paying_amount; //total paying amount
            //---------------
            $request->next_payment_date; 
        */
    }


}
