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
                
                $table->decimal('delivered_total_qty',20,3)->default(0)->comment('total delivered qty, where ever return/refund or not.. ');
                $table->decimal('remaining_delivery_qty',20,3)->default(0);
                $table->decimal('total_delivered_qty',20,3)->default(0);

                $table->decimal('reduced_base_stock_remaining_delivery',20,3)->default(0)->comment('reduced_base_stock_remaining_delivery :- reduced base stock , but not delivery this stock. (remaining delivery)');
                $table->decimal('reduceable_delivered_qty',20,3)->default(0)->comment('delivered qty, which is ready to reduce from main stock qty when we return/refund qty.. this field is basically used for return/refunded time, increment stock qty in the main product_stocks table qty');
                $table->string('total_reduceable_qty',0)->default(0)->comment('Its a vartual field. It will be deleted after a certain time.... There are two action of this field... first one is: when delivery this product, reduced_base_stock_remaining_delivery will be minus until zero, and reduceable_delivered_qty field will be plus.. Second one is: when return this product, quantity of this field will be reduce/decrease/minus same as return quantity ------------------');
                $table->string('remaining_delivery_unreduced_qty',30)->nullable()->comment('remaining delivery unreduced qty : unreduced from main stock.. due to have not stock availabe');
                $table->string('remaining_delivery_unreduced_qty_date',30)->nullable()->comment('remaining delivery qty date : unreduced from main stock.. due to have not stock availabe');


                $table->tinyInteger('status')->nullable();
                $table->tinyInteger('delivery_status')->nullable();
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
        Schema::dropIfExists('sell_product_stocks');
    }
}
