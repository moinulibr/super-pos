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

                $table->decimal('total_sell_item',20,2)->default(0)->comment('total_sell_item');
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
                
                $table->decimal('total_payable_amount',20,2)->default(0)->comment('total_payable_amount');
                $table->decimal('total_paid_amount',20,2)->default(0)->comment('total_paid_amount +- total_paid_amount');
                $table->decimal('total_due_amount',20,2)->default(0)->comment('total_due_amount +- total_due_amount');
                $table->decimal('reference_amount',20,2)->default(0);
                
                $table->decimal('total_sold_amount',20,2)->default(0)->comment('total_selling_amount - total_selling_amount');
                $table->decimal('total_purchase_amount',20,2)->default(0)->comment('total_selling_purchase_amount - total_selling_purchase_amount');
                $table->decimal('total_profit_from_product',20,2)->default(0)->comment('total_selling_profit +- total_selling_profit');
                $table->decimal('total_profit',20,2)->default(0)->comment('total_selling_profit +- total_selling_profit');
                 
                $table->decimal('total_quantity',20,3)->default(0)->comment('total_sell_qty + total_sell_qty');
                
                $table->decimal('total_delivered_qty',20,3)->default(0)->comment('');
               
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
