<?php
namespace App\Traits\Backend\Customer\Logical;

use App\Models\Backend\Customer\Customer;

/*
* 
*/
trait ManagingCalculationOfCustomerSummaryTrait
{

    protected function managingCustomerCalculation($customerId,$dbField,$calType,$amount)
    {
        $databaseField = $this->getCustomerDBFieldByInteger($dbField);
        $this->updateCustomerCalculationField($customerId,$databaseField,$calType,$amount);
        $this->finalAllCalculation($customerId);
        return true;
    }

    //get customer db field by integer number
    //which integer is stored in the customerDatabaseFiled array
    private function getCustomerDBFieldByInteger($key)
    {
        $arrayLabel = "";
        if(array_key_exists($key,$this->customerDatabaseFiled()))
        {
            $arrayLabel = $this->customerDatabaseFiled()[$key];
        }
        return $arrayLabel;
    }
    
     
    //update calculation field
    protected function updateCustomerSpecificField($customerId,$databaseField,$calType,$amount)
    {
        $dbField = $this->getCustomerDBFieldByInteger($databaseField);
        //1='plus', 2='minus'
        $existingCustomerData = Customer::select('id',"$dbField")->where('id',$customerId)->first();
        $amountAfterCalculation = 0;
        if($calType == 1)
        {
            $amountAfterCalculation = $existingCustomerData->{$dbField} + $amount;
        }else{
            $changeableAmount = 0;
            if($existingCustomerData->{$dbField} == 0){
                $changeableAmount = 0;
            }
            else if($existingCustomerData->{$dbField} == $amount){
                $changeableAmount = 0;
            }
            else if($existingCustomerData->{$dbField} > $amount){
                $changeableAmount = $existingCustomerData->{$dbField} - $amount;
            }
            else if($existingCustomerData->{$dbField} < $amount && $existingCustomerData->{$dbField} > 0){
                $changeableAmount = 0;
            }
            //$amountAfterCalculation = $existingCustomerData->{$dbField} - $amount;
            $amountAfterCalculation = $changeableAmount;
        }
        $existingCustomerData->{$dbField} = $amountAfterCalculation;
        $existingCustomerData->save();
        return $existingCustomerData->{$dbField};
    }

    //update calculation field
    private function updateCustomerCalculationField($customerId,$dbField,$calType,$amount)
    {
        //1='plus', 2='minus'
        $existingCustomerData = Customer::select('id',"$dbField")->where('id',$customerId)->first();
        $amountAfterCalculation = 0;
        if($calType == 1)
        {
            $amountAfterCalculation = $existingCustomerData->{$dbField} + $amount;
        }else{
            $changeableAmount = 0;
            if($existingCustomerData->{$dbField} == 0){
                $changeableAmount = 0;
            }
            else if($existingCustomerData->{$dbField} == $amount){
                $changeableAmount = 0;
            }
            else if($existingCustomerData->{$dbField} > $amount){
                $changeableAmount = $existingCustomerData->{$dbField} - $amount;
            }
            else if($existingCustomerData->{$dbField} < $amount && $existingCustomerData->{$dbField} > 0){
                $changeableAmount = 0;
            }
            //$amountAfterCalculation = $existingCustomerData->{$dbField} - $amount;
            $amountAfterCalculation = $changeableAmount;
        }
        $existingCustomerData->{$dbField} = $amountAfterCalculation;
        $existingCustomerData->save();
        return $existingCustomerData->{$dbField};
    }

   //customer database all calculationable field
    private function customerDatabaseFiled()
    {
        return [
             1 => 'previous_due' , //just note, never change this value
             2 => 'previous_advance' , //just note, never change this value
             3 => 'previous_loan' , //just note, never change this value
             4 => 'previous_return' , //just note, never change this value

             5 => 'previous_due_paid' , //just note, never change this value
             6 => 'previous_advance_paid' , //just note, never change this value
             7 => 'previous_loan_paid' , //just note, never change this value
             8 => 'previous_return_paid' , //just note, never change this value

             9 => 'previous_due_paid_now' ,
            10 => 'previous_advance_paid_now' ,
            11 => 'previous_loan_paid_now' ,
            12 => 'previous_return_paid_now' ,

            13 => 'previous_total_due' ,
            14 => 'previous_total_advance' ,
            15 => 'previous_total_loan' ,
            16 => 'previous_total_return' ,

            17 => 'current_due' ,
            18 => 'current_advance' ,
            19 => 'current_loan' ,
            20 => 'current_return' ,

            21 => 'current_paid_due' ,
            22 => 'current_paid_advance',
            23 => 'current_paid_loan',
            24 => 'current_paid_return' ,

            25 => 'current_total_due' ,
            26 => 'current_total_advance' ,
            27 => 'current_total_loan' ,
            28 => 'current_total_return' ,

            29 => 'total_due' ,
            30 => 'total_advance' ,
            31 => 'total_loan' ,
            32 => 'total_return' ,

            33 => 'current_total_sell_amount' ,
            34 => 'current_total_sell_reference_amount' ,
            35 => 'current_total_sell_profit_amount' ,

            36 => 'total_sell_amount',
            36 => 'total_sell_reference_amount' ,
            37 => 'total_sell_profit_amount' ,
            38 => 'total_discount_amount' ,
        ];
    }

    //final all calculation 
    private function finalAllCalculation($customerId)
    {
        $existingData = Customer::select('id','previous_due','previous_advance','previous_loan','previous_return','previous_due_paid_now','previous_advance_paid_now','previous_loan_paid_now','previous_return_paid_now','previous_total_due','previous_total_advance','previous_total_loan','previous_total_return',
            'current_due','current_advance','current_loan','current_return','current_paid_due','current_paid_advance','current_paid_loan','current_paid_return','current_total_due','current_total_advance','current_total_loan','current_total_return','total_due','total_advance','total_loan','total_return','current_total_sell_amount','total_sell_amount','total_discount_amount')
        ->where('id',$customerId)
        ->first();

        //total previous due = previous_due - previous_due_paid_now 
        $previousTotalDue =  $existingData->previous_due - $existingData->previous_due_paid_now;
        $previousTotalAdvance =  $existingData->previous_advance - $existingData->previous_advance_paid_now;
        $previousTotalLoan =  $existingData->previous_loan - $existingData->previous_loan_paid_now;
        $previousTotalReturn =  $existingData->previous_return - $existingData->previous_return_paid_now;

        $existingData->previous_total_due = $previousTotalDue;
        $existingData->previous_total_advance = $previousTotalAdvance;
        $existingData->previous_total_loan = $previousTotalLoan;
        $existingData->previous_total_return = $previousTotalReturn;

        $currentTotalDue =  $existingData->current_due - $existingData->current_paid_due;
        $currentTotalAdvance =  $existingData->current_advance - $existingData->current_paid_advance;
        $currentTotalLoan =  $existingData->current_loan - $existingData->current_paid_loan;

        //return part is exceptional---think more about return..
        //temporary current_return == current_paid_return => both are equal
        //$currentTotalReturn =  $existingData->current_return - $existingData->current_paid_return;
        $currentTotalReturn =  $existingData->current_paid_return;

        $existingData->current_total_due = $currentTotalDue;
        $existingData->current_total_advance = $currentTotalAdvance;
        $existingData->current_total_loan =  $currentTotalLoan;

        $existingData->current_total_return = $currentTotalReturn;

        $existingData->total_due = $previousTotalDue + $currentTotalDue;
        $existingData->total_advance = $previousTotalAdvance + $currentTotalAdvance;
        $existingData->total_loan = $previousTotalLoan + $currentTotalLoan;
        $existingData->total_return = $previousTotalReturn + $currentTotalReturn;

        //$existingData->total_sell_amount = $existingData->total_sell_amount + $existingData->current_total_sell_amount;
        //$existingData->total_sell_amount = $existingData->total_discount_amount + $existingData->current_total_sell_amount;
        $existingData->total_sell_amount = $existingData->current_total_sell_amount;
        $existingData->save();
        return true;
        //$kd = $existingData->previous_due;
        //$kd = $existingData->previous_advance;
        //$kd = $existingData->previous_loan;
        //$kd = $existingData->previous_return;

        //$kd = $existingData->previous_due_paid_now;
        //$kd = $existingData->previous_advance_paid_now;
        //$kd = $existingData->previous_loan_paid_now;
        //$kd = $existingData->previous_return_paid_now;

        //$kd = $existingData->current_due;
        //$kd = $existingData->current_advance;
        //$kd = $existingData->current_loan;
        //$kd = $existingData->current_return;
        //$kd = $existingData->current_paid_due;
        //$kd = $existingData->current_paid_advance;
        //$kd = $existingData->current_paid_loan;
        //$kd = $existingData->current_paid_return;

        //$kd = $existingData->current_total_sell_amount;
        //$kd = $existingData->total_sell_amount;
    }

}
