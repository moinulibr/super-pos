<?php

namespace App\Http\Controllers\Backend\Customer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Traits\Permission\Permission;
use App\Models\Backend\Customer\Customer;
use App\Models\Backend\Customer\CustomerTransactionHistory;
use App\Models\Backend\Sell\SellInvoice;
use App\Traits\Backend\Payment\CustomerPaymentProcessTrait;

use App\Traits\Backend\Customer\Logical\ManagingCalculationOfCustomerSummaryTrait;

use App\Traits\Backend\Payment\PaymentProcessTrait;

class CustomerTransactionalController extends Controller
{
    use CustomerPaymentProcessTrait, PaymentProcessTrait, ManagingCalculationOfCustomerSummaryTrait;


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
        $data['customer'] = Customer::select('id','total_due','previous_total_due')->findOrFail($request->id);
        $data['sell'] = SellInvoice::select('id','customer_id','total_due_amount','total_paid_amount','total_payable_amount','sell_date')->where('customer_id',$request->id)->latest()->get();
        $view =  view('backend.customer.customer.transactionHistory.receive_all_invoice_due',$data)->render();
        return response()->json([
            'status' => true,
            'type' => 'success',
            'view' => $view,
        ]);
    }
    public function storeReceivingAllInvoiceDues(Request $request)
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


}
