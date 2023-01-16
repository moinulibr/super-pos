<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEditSellCartInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('edit_sell_cart_invoices')){
            Schema::create('edit_sell_cart_invoices', function (Blueprint $table) {
                $table->id();
                $table->integer('branch_id')->nullable();
                $table->tinyInteger('sell_type')->nullable()->comment('1=final sell, 2=quatation , 3=draft, 4=others');
                
                $table->integer('sell_invoice_id')->nullable();
                $table->string('sell_invoice_no',30)->nullable();

                $table->decimal('total_sell_item_before_edit',20,2)->default(0)->comment('sell creating time, total sell item');
                $table->decimal('total_sell_item_after_edit',20,2)->default(0)->comment('total sell item after edit');
                $table->decimal('total_item',20,2)->default(0)->comment('total_sell_item_before_edit +- total_sell_item_after_edit');
                $table->decimal('total_sell_quantity_before_edit',20,2)->default(0);
                $table->decimal('subtotal',20,2)->default(0)->comment('only total product sell price, before discount and others cost');
                $table->decimal('discount_amount',20,2)->default(0)->comment('before or after edit.. final field');
                $table->string('discount_type',12)->nullable()->comment('percentage, fixed');
                $table->decimal('total_discount',20,2)->default(0)->comment('before or after edit.. final field');
                $table->decimal('vat_amount',20,2)->default(0)->comment('before or after edit.. final field');
                $table->decimal('total_vat',20,2)->default(0)->comment('before or after edit.. final field');
                $table->decimal('shipping_cost',20,2)->default(0)->comment('before or after edit.. final field');
                $table->decimal('others_cost',20,2)->default(0)->comment('before or after edit.. final field');
                $table->decimal('round_amount',20,2)->default(0)->comment('before or after edit.. final field');
                $table->string('round_type',2)->nullable()->comment('plus(+), minus(-)');
                $table->decimal('total_payable_amount_before_edit',20,2)->default(0)->comment('(subtotal + total_vat) - (discount + shipping_cost + others_cost +- round_amount)');
                $table->decimal('total_payable_amount_after_edit',20,2)->default(0)->comment('(subtotal + total_vat) - (discount + shipping_cost + others_cost +- round_amount)');
                $table->decimal('total_paid_amount_before_edit',20,2)->default(0)->comment('total paid amount before edit');
                $table->decimal('total_due_amount_before_edit',20,2)->default(0)->comment('total due amount before edit'); 
                $table->decimal('total_paid_amount_after_edit',20,2)->default(0)->comment('total paid amount after edit');
                $table->decimal('total_due_amount_after_edit',20,2)->default(0)->comment('total due amount after edit');

                $table->decimal('total_paid_amount',20,2)->default(0)->comment('total_paid_amount_before_edit +- total_paid_amount_after_edit');
                $table->decimal('total_due_amount',20,2)->default(0)->comment('total_due_amount_before_edit +- total_due_amount_after_edit');
                $table->decimal('reference_amount',20,2)->default(0);
                
                $table->decimal('total_selling_amount_before_edit',20,2)->default(0)->comment('(sold_price * total_sell_qty_before_edit)');
                $table->decimal('total_selling_amount_after_edit',20,2)->default(0)->comment('(sold_price * total_sell_qty_after_edit)');
                $table->decimal('total_sold_amount',20,2)->default(0)->comment('total_selling_amount_after_edit - total_selling_amount_before_edit');
                

                //$table->decimal('purchase_price',20,2)->nullable();
                $table->decimal('total_selling_purchase_amount_before_edit',20,2)->default(0)->comment('total_sell_qty_before_edit * sold_price');
                $table->decimal('total_selling_purchase_amount_after_edit',20,2)->default(0)->comment('total_sell_qty_after_edit * sold_price');
                $table->decimal('total_purchase_amount',20,2)->default(0)->comment('total_selling_purchase_amount_after_edit - total_selling_purchase_amount_before_edit');
              

                $table->decimal('total_selling_profit_before_edit',20,2)->default(0)->comment('total_selling_purchase_amount_before_edit - total_selling_amount_before_edit');
                $table->decimal('total_selling_profit_after_edit',20,2)->default(0)->comment('total_selling_purchase_amount_after_edit - total_selling_amount_after_edit');
                $table->decimal('total_profit',20,2)->default(0)->comment('total_selling_profit_before_edit +- total_selling_profit_after_edit');

                 
                $table->tinyInteger('qty_change_type')->default(0)->comment('update type : 1 = plus, 2= minus');
                
                $table->decimal('total_update_qty',20,3)->default(0)->comment('total_sell_qty_after_edit - total_sell_qty_before_edit ...when updating');
                $table->decimal('total_quantity',20,3)->default(0)->comment('total_sell_qty_after_edit + total_sell_qty_before_edit');
                
                $table->decimal('total_delivered_qty',20,3)->default(0)->comment('');
                $table->decimal('remaining_delivery_qty_before_edit',20,3)->default(0);
                $table->decimal('remaining_delivery_qty_after_edit',20,3)->default(0);


                $table->string('payment_status',50)->nullable()->comment('Full Paid, Full Due, Partial Paid');
                $table->string('payment_type',20)->nullable()->comment('parital payment, full payment');
                
                $table->integer('customer_id')->nullable();
                $table->string('customer_phone',20)->nullable();
                $table->integer('customer_type_id')->nullable()->comment('1=Permanent, 2=Temporary');
                $table->integer('shipping_id')->nullable();
                $table->text('shipping_note')->nullable();
                $table->text('receiver_details')->nullable();
                $table->integer('reference_id')->nullable();
                $table->text('sell_note')->nullable();
                $table->string('sell_date',25)->nullable();
             
                $table->tinyInteger('status')->nullable();

                $table->integer('created_by')->nullable();
                $table->softDeletes();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('edit_sell_cart_invoices');
    }
}
