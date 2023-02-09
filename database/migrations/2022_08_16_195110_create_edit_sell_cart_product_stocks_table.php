<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEditSellCartProductStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('edit_sell_cart_product_stocks')){
            Schema::create('edit_sell_cart_product_stocks', function (Blueprint $table) {
                $table->id();
                $table->integer('branch_id')->nullable();
                $table->integer('edit_sell_cart_invoice_id')->nullable();
                $table->integer('edit_sell_cart_product_id')->nullable()->comment('edit sell cart product relationship table pid');
                
                $table->integer('sell_invoice_id')->nullable();
                $table->integer('sell_product_id')->nullable()->comment('sell product relationship table pid');
                
                $table->string('sell_invoice_no',30)->nullable();

                $table->integer('product_id')->nullable();
                $table->integer('stock_id')->nullable();
                $table->integer('product_stock_id')->nullable()->comment('product stock id');
                
                $table->decimal('mrp_price',20,2)->default(0);
                $table->decimal('regular_sell_price',20,2)->default(0);
                $table->decimal('sold_price',20,2)->default(0);
                $table->decimal('total_sold_amount',20,2)->default(0);
                $table->decimal('purchase_price',20,2)->default(0);
                $table->decimal('total_purchase_amount',20,2)->default(0);
               
                $table->tinyInteger('qty_change_type')->default(0)->comment('update type : 1 = plus, 2= minus');
                
                $table->decimal('total_quantity',20,3)->default(0)->comment('total_sell_qty_after_edit + total_sell_qty_before_edit');
                
               $table->decimal('total_profit',20,2)->default(0)->comment('total_selling_profit_after_edit +- total_selling_profit_before_edit');
                
                $table->decimal('total_delivered_qty',20,3)->default(0)->comment('');
                
                $table->decimal('reduced_base_stock_remaining_delivery',20,3)->default(0)->comment('');
                $table->decimal('reduceable_delivered_qty',20,3)->default(0)->comment('');
                $table->string('remaining_delivery_unreduced_qty',30)->nullable()->comment('');
                $table->string('remaining_delivery_unreduced_qty_date',30)->nullable()->comment('');


                $table->tinyInteger('status')->nullable();
                //have to check
                $table->text('sell_cart')->nullable()->comment('json: (invoice creating time) all field');
              
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
        Schema::dropIfExists('edit_sell_cart_product_stocks');
    }
}
