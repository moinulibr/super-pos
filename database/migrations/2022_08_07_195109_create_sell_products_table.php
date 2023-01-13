<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('sell_products')){
            Schema::create('sell_products', function (Blueprint $table) {
                $table->id();
                $table->integer('branch_id')->nullable();
                $table->integer('sell_invoice_id')->nullable();
                $table->integer('product_id')->nullable();
                $table->integer('unit_id')->nullable();
                $table->integer('supplier_id')->nullable();
                $table->integer('main_product_stock_id')->nullable()->comment('product stock id');
                
                $table->tinyInteger('product_stock_type')->nullable()->comment('1=single, 2=multiple');
                
                //$table->text('product_stocks')->nullable()->comment('json:all product stock ids,others stock related information');
                
                $table->string('custom_code',50)->nullable()->comment('product custom_code');
                $table->decimal('total_sell_qty',20,3)->default(0)->comment('creating time sell quantity');

                //$table->decimal('mrp_price',20,2)->nullable();
                //$table->decimal('regular_sell_price',20,2)->nullable();
                $table->decimal('sold_price',20,2)->default(0)->comment('creating time');

                $table->decimal('discount_amount',20,2)->default(0)->comment('creating time');
                $table->string('discount_type',12)->nullable()->comment('percentage, fixed');
                $table->decimal('total_discount',20,2)->default(0)->comment('creating time');

                $table->decimal('reference_commission',20,2)->default(0);
                
                $table->decimal('total_selling_amount',20,2)->default(0)->comment('sell creating time total qty wise sold price (sold_price * total_sell_qty)');
                $table->decimal('total_refunded_amount',20,2)->default(0)->comment('refunded time total qty wise sold price (sold_price * total_refunded_qty)');
                $table->decimal('total_sold_amount',20,2)->default(0)->comment('total_selling_amount - total_refunded_amount');
                //previous field : total_sold_price

                //$table->decimal('purchase_price',20,2)->nullable();
                $table->decimal('total_selling_purchase_amount',20,2)->default(0)->comment('creating time');
                $table->decimal('total_refunding_purchase_amount',20,2)->default(0)->comment('refunded time total purchase price');
                $table->decimal('total_purchase_amount',20,2)->default(0)->comment('total_selling_purchase_amount - total_refunding_purchase_amount');
                //previous field : total_purchase_price

                $table->decimal('total_selling_profit',20,2)->default(0)->comment('sell creating time totoal profit');
                $table->decimal('total_refunded_reduced_profit',20,2)->default(0)->comment('refunded time reduce profit');
                $table->decimal('total_profit_from_product',20,2)->default(0)->comment('without extra cost.. total_selling_profit - total_refunded_reduced_profit');
                $table->decimal('total_profit',20,2)->default(0)->comment('total_selling_profit - total_refunded_reduced_profit (should be- without extra all cost)');

                $table->decimal('total_quantity',20,3)->default(0)->comment('quantity - total_refunded_qty');
                $table->decimal('total_refunded_qty',20,3)->default(0)->comment('refunded time, refunded qty');
                $table->decimal('refunded_received_qty',20,3)->default(0)->comment('refunded received qty');
                $table->decimal('delivered_qty',20,3)->default(0)->comment('total delivered qty');

                $table->text('liability_type')->nullable()->comment('default-null, 1=Warranty,2=Guarantee.json:w_g_type,w_g_type_day,identityNumber');
                $table->string('identity_number',50)->nullable();
                $table->text('cart')->nullable()->comment('json:p.name,custom_code,unit_name,wharehouse_id,warehouse_rack_id,sold_price');

                $table->tinyInteger('status')->nullable();
                $table->tinyInteger('delivery_status')->nullable()->comment('total_quantity == delivered_qty ? delivered : purtial delivered');

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
        Schema::dropIfExists('sell_products');
    }
}
