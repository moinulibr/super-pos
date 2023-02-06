<?php

namespace App\Models\Backend\CartSell;

use App\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\Backend\Customer\Customer;
use App\Models\Backend\Reference\Reference;
use App\Models\Backend\Payment\AccountPayment;
use App\Models\Backend\CartSell\EditSellCartProduct;
use App\Models\Backend\Customer\CustomerShippingAddress;

class EditSellCartInvoice extends Model
{

    public function customer()
    {
        return $this->belongsTo(Customer::class,'customer_id','id');
    }
    public function referenceBy()
    {
        return $this->belongsTo(Reference::class,'reference_id','id');
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class,'created_by','id');
    }
    public function shipping()
    {
        return $this->hasOne(CustomerShippingAddress::class,'id','shipping_id');
    }

    public function sellProducts()
    {
        return $this->hasMany(SellProduct::class,'sell_invoice_id','id');
    }
    //edit sell cart product
    public function editSellCartProducts()
    {
        return $this->hasMany(EditSellCartProduct::class,'edit_sell_cart_invoice_id','id')->where('status',1);
    } 
    //edit sell cart product
    public function editSellCartProductsStock()
    {
        return $this->hasMany(EditSellCartProductStock::class,'edit_sell_cart_invoice_id','id')->where('status',1);
    }
    //edit sell cart product
    public function editSellCartAllProducts()
    {
        return $this->hasMany(EditSellCartProduct::class,'edit_sell_cart_invoice_id','id');
    } 
    //edit sell cart product
    public function editSellCartAllProductsStock()
    {
        return $this->hasMany(EditSellCartProductStock::class,'edit_sell_cart_invoice_id','id');
    }

    public function invoicePayment()
    {
        return $this->hasMany(AccountPayment::class,'main_module_invoice_id','id')->where('main_module_id',getModuleIdBySingleModuleLebel_hh("Sell"));
    } 
    public function moduleWiseInvoicePayment()
    {
        return $this->hasMany(AccountPayment::class,'module_invoice_id','id')->where('module_id',getModuleIdBySingleModuleLebel_hh("Sell"));
    }

    //after refunded amount
    public function totalInvoicePayableAmountAfterRefund()
    {
        return number_format($this->total_payable_amount - $this->total_refunded_amount,2,'.','');
    }

    //total item after refunded item.
    public function totalSellItemAfterRefund()
    {
        return $this->hasMany(SellProduct::class,'sell_invoice_id','id')->select('id','total_quantity')->where('total_quantity','>',0)->count();
    }



}
