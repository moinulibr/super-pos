<?php

namespace App\Models\Backend\Payment;

use App\Models\Backend\Customer\Customer;
use App\Models\Backend\Supplier\Supplier;
use App\User;
use Illuminate\Database\Eloquent\Model;

class AccountPayment extends Model
{
    public function paymentMethods()
    {
        return $this->belongsTo(PaymentMethod::class,'payment_method_id','id');
    }

    public function paymentAccount()
    {
        return $this->belongsTo(Account::class,'account_id','id');
    }

    public function accountPaymentInvoice()
    {
        return $this->belongsTo(AccountPaymentInvoice::class,'account_payment_invoice_id','id');
    }

    public function customers()
    {
        return $this->belongsTo(Customer::class,'user_id','id');
    }
    public function suppliers()
    {
        return $this->belongsTo(Supplier::class,'user_id','id');
    }  
    public function createdBY()
    {
        return $this->belongsTo(User::class,'received_by','id');
    }
}
