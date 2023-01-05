<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellProductStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('sell_product_stocks')){
            Schema::create('sell_product_stocks', function (Blueprint $table) {
                $table->id();
                $table->integer('branch_id')->nullable();
                $table->integer('sell_invoice_id')->nullable();
                $table->integer('sell_product_id')->nullable()->comment('sell product relationship table pid');
                $table->integer('product_id')->nullable();
                $table->integer('stock_id')->nullable();
                $table->integer('product_stock_id')->nullable()->comment('product stock id');
                $table->decimal('total_sell_qty',20,3)->default(0)->comment('sell creating time');
                $table->decimal('mrp_price',20,2)->default(0);
                $table->decimal('regular_sell_price',20,2)->default(0);
                $table->decimal('sold_price',20,2)->default(0);
                $table->decimal('purchase_price',20,2)->default(0);
                
                $table->decimal('total_selling_amount',20,2)->default(0)->comment('sell creating time total qty wise sold price (sold_price * total_sell_qty)');
                $table->decimal('total_refunded_amount',20,2)->default(0)->comment('refunded time total qty wise sold price (sold_price * total_refunded_qty)');
                $table->decimal('total_sold_amount',20,2)->default(0)->comment('total_selling_amount - total_refunded_amount');
                //total_sold_price previous column
                

                $table->decimal('total_selling_purchase_amount',20,2)->default(0)->comment('sell refunded time total qty wise purchase price (purchase_price * total_sell_qty)');
                $table->decimal('total_refunding_purchase_amount',20,2)->default(0)->comment('sell refunded time total qty wise purchase price (purchase_price * total_refunded_qty) total refunded qty purchase  price');
                $table->decimal('total_purchase_amount',20,2)->default(0)->comment('total_selling_purchase_amount - total_refunding_purchase_amount');
                //total_purchase_price previous column

                $table->decimal('total_quantity',20,3)->default(0)->comment('total_sell_qty - total_refunded_qty');
                
                $table->decimal('total_refunded_qty',20,3)->default(0)->comment('sell refunded time, total refunded qty');
                $table->decimal('total_refunded_received_qty',20,3)->default(0)->comment('refunded received qty');

                $table->decimal('total_selling_profit',20,2)->default(0)->comment('total_selling_amount - total_selling_purchase_amount');
                $table->decimal('refunded_reduced_profit',20,2)->default(0)->comment('total_refunded_amount - total_refunding_purchase_amount');
                $table->decimal('total_profit_from_product',20,2)->default(0)->comment('total profit : total_selling_profit - refunded_reduced_profit');
                $table->decimal('total_profit',20,2)->default(0)->comment('total profit : total_selling_profit - refunded_reduced_profit  (should be- without extra all cost)');
                

                


                $table->decimal('ict_total_delivered_qty',20,3)->default(0)->comment('invoice creating time');
                $table->decimal('ict_remaining_delivery_qty',20,3)->default(0)->comment('invoice creating time');
                
                $table->decimal('remaining_delivery_qty',20,3)->default(0);
                $table->decimal('total_delivered_qty',20,3)->default(0);


                $table->tinyInteger('status')->nullable();
                $table->tinyInteger('delivery_status')->nullable();

                $table->decimal('delivered_qty',20,3)->default(0)->comment('creating time');
      
                //ict_isp_qty ->comment('instantly processed quantity for delivery. Meaning thant, this quantity is ready to delivery');
                $table->decimal('stock_process_instantly_qty',20,3)->default(0)->comment('stock processed instantly quantity');
                $table->decimal('stock_process_instantly_qty_reduced',20,3)->default(0)->default(0)->comment('stock_process_instantly_qty_reduce_status :- this field depend on reduced_base_stock_remaining_delivery field of product_stocks table.');
                $table->decimal('stock_process_later_qty',20,3)->default(0)->comment('stock processe latter quantity');
                $table->string('stock_process_later_date')->nullable();
                $table->decimal('total_stock_remaining_process_qty',20,3)->default(0)->comment('stock processe latter quantity');
                $table->decimal('total_stock_processed_qty',20,3)->default(0)->comment('stock processe latter quantity');


                //have to check
                $table->text('ict_stock_process_cart')->nullable()->comment('json: (invoice creating time) ict_stock_process_instantly_qty,ict_stock_process_instantly_qty_reduced,ict_stock_process_later_qty,ict_stock_process_later_date,ict_total_stock_remaining_process_qty,ict_total_stock_processed_qty');
                /* $table->decimal('ict_stock_process_instantly_qty',20,3)->default(0)->comment('(invoice creating time) stock processed instantly quantity');
                $table->decimal('ict_stock_process_instantly_qty_reduced',20,3)->default(0)->default(0)->comment('(invoice creating time) stock_process_instantly_qty_reduce_status :- this field depend on reduced_base_stock_remaining_delivery field of product_stocks table.');
                
                $table->decimal('ict_stock_process_later_qty',20,3)->default(0)->comment('(invoice creating time) stock processe latter quantity');
                $table->string('ict_stock_process_later_date')->nullable();
                $table->decimal('ict_total_stock_remaining_process_qty',20,3)->default(0)->comment('(invoice creating time) stock processe latter quantity');
                $table->decimal('ict_total_stock_processed_qty',20,3)->default(0)->comment('(invoice creating time) stock processe latter quantity'); */
                //have to check


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
        Schema::dropIfExists('sell_product_stocks');
    }
}
