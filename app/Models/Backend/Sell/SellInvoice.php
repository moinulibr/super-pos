<?php

namespace App\Models\Backend\Sell;

use App\Models\Backend\Customer\Customer;
use App\Models\Backend\Customer\CustomerShippingAddress;
use App\Models\Backend\Payment\AccountPayment;
use App\Models\Backend\Reference\Reference;
use App\User;
use Illuminate\Database\Eloquent\Model;

class SellInvoice extends Model
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
        return $this->hasMany(SellProduct::class,'sell_invoice_id','id')->whereNull('deleted_at');
    }

    public function sellProductsAllData()//with deleted data
    {
        return $this->hasMany(SellProduct::class,'sell_invoice_id','id');
    }

    public function invoicePayment()
    {
        return $this->hasMany(AccountPayment::class,'main_module_invoice_id','id')->where('main_module_id',getModuleIdBySingleModuleLebel_hh("Sell"));
    } 
    public function moduleWiseInvoicePayment()
    {
        return $this->hasMany(AccountPayment::class,'module_invoice_id','id')->where('module_id',getModuleIdBySingleModuleLebel_hh("Sell"));
    }

    //payble amount with all amount , before and after return
    public function totalInvoicePayableAmountWithAllAmount()
    {   
        $invoicePlusableCharge = $this->total_vat + $this->shipping_cost + $this->others_cost  + $this->round_amount;
        
        return number_format((($this->total_sold_amount + $this->total_refunded_amount + $invoicePlusableCharge)),2,'.','');
    }

    //payble amount before refunded without discount
    public function totalInvoicePayableAmountBeforeReturnWithoutDiscount()
    {   
        $invoicePlusableCharge = $this->total_vat + $this->shipping_cost + $this->others_cost + $this->round_amount;
        
        return number_format((($this->total_sold_amount + $this->total_refunded_amount + $invoicePlusableCharge)),2,'.','');
    }

    //payble amount before refunded after discount
    public function totalInvoicePayableAmountBeforeRefundAfterDiscount()
    {   
        $invoicePlusableCharge = $this->total_vat + $this->shipping_cost + $this->others_cost + $this->round_amount;
        $invoiceMinusableCost = $this->total_discount;
        return number_format((($this->total_sold_amount + $invoicePlusableCharge + $this->total_refunded_amount)-( $invoiceMinusableCost)),2,'.','');
    
        /* //total_discount, total_vat	, shipping_cost, others_cost, round_amount, round_type//total_payable_amount, adjustment_amount, refund_charge, adjustment_type, reference_amount//total_refunded_amount, 
            //formula:- 
            $invoicePlusableCharge = $this->total_vat + $this->shipping_cost + $this->others_cost + $this->refund_charge;
            $invoiceMinusableCost = $this->total_discount + $this->reference_amount;
            
            if($this->round_type ==	'+'){
                $invoicePlusableCharge = $invoicePlusableCharge + $this->round_amount;
            }else{
                $invoiceMinusableCost = $invoiceMinusableCost + $this->round_amount;
            }

            if($this->adjustment_type = '+'){
                $invoicePlusableCharge = $invoicePlusableCharge + $this->adjustment_amount;
            }else{
                $invoiceMinusableCost = $invoiceMinusableCost + $this->adjustment_amount;
            }
            return number_format((($this->total_selling_amount + $invoicePlusableCharge) - ($invoiceMinusableCost)),2,'.','');
        *///total_sold_amount ==total_selling_amount - total_refunded_amount
        //return number_format($this->total_selling_amount - $this->total_refunded_amount,2,'.','');
    }

    //payble amount after refunded after discount
    public function totalInvoicePayableAmountAfterRefundAfterDiscount()
    {   
        $invoicePlusableCharge = $this->total_vat + $this->shipping_cost + $this->others_cost + $this->round_amount;
        $invoiceMinusableCost = $this->total_discount;
        return number_format((($this->total_sold_amount + $invoicePlusableCharge) - ($invoiceMinusableCost)),2,'.','');
    }



    //total Profit
    public function totalInvoiceProfit()
    {
        $invoicePlusableCharge = $this->refund_charge;//$this->total_vat + $this->shipping_cost + $this->others_cost + $this->refund_charge;
        $invoiceMinusableCost  = $this->total_discount + $this->reference_amount;
        
        if($this->round_type ==	'+'){
            $invoicePlusableCharge = $invoicePlusableCharge + $this->round_amount;
        }else{
            $invoiceMinusableCost = $invoiceMinusableCost + $this->round_amount;
        }

        if($this->adjustment_type = '+'){
            $invoicePlusableCharge = $invoicePlusableCharge + $this->adjustment_amount;
        }else{
            $invoiceMinusableCost = $invoiceMinusableCost + $this->adjustment_amount;
        }
        return number_format((($this->total_profit_from_product + $invoicePlusableCharge) - ($invoiceMinusableCost)),2,'.','');
    }

    //total Profit from product
    public function totalInvoiceProductProfit()
    {
        return number_format($this->total_profit_from_product,2,'.','');
    }

    //total invoice discount with adjustment
    public function totalInvoiceDiscountAmountWithAdjustment()
    {
        $invoiceMinusableCost  = $this->total_discount + $this->reference_amount;
        
        if($this->round_type ==	'+'){
            $invoiceMinusableCost = $invoiceMinusableCost + $this->round_amount;
        }else{
            $invoiceMinusableCost = $invoiceMinusableCost - $this->round_amount;
        }

        if($this->adjustment_type = '+'){
            $invoiceMinusableCost = $invoiceMinusableCost + $this->adjustment_amount;
        }else{
            $invoiceMinusableCost = $invoiceMinusableCost - $this->adjustment_amount;
        }
        return number_format($invoiceMinusableCost,2,'.','');
    }


    //total item after refunded item.
    public function totalSellItemAfterRefund()
    {
        return $this->hasMany(SellProduct::class,'sell_invoice_id','id')->select('id','total_quantity')->where('total_quantity','>',0)->count();
    }


    //quotation
    public function quotation()
    {
        return $this->hasOne(SellQuotation::class,'sell_invoice_id','id');
    }


}
