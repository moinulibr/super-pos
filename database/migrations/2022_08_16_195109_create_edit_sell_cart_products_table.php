<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEditSellCartProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('edit_sell_cart_products')){
            Schema::create('edit_sell_cart_products', function (Blueprint $table) {
                $table->id();
                $table->integer('branch_id')->nullable();
                $table->integer('edit_sell_cart_invoice_id')->nullable();
                $table->integer('sell_invoice_id')->nullable();

                $table->string('sell_invoice_no',30)->nullable();

                $table->integer('product_id')->nullable();
                $table->integer('unit_id')->nullable();
                $table->integer('supplier_id')->nullable();
                $table->integer('main_product_stock_id')->nullable()->comment('product stock id');
                
                $table->tinyInteger('product_added_type')->nullable()->comment('1=edit, 2=add');
                $table->tinyInteger('product_stock_type')->nullable()->comment('1=single, 2=multiple');
                
                $table->string('custom_code',50)->nullable()->comment('product custom_code');
                $table->decimal('total_sell_qty_before_edit',20,3)->default(0)->comment('creating time sell quantity');
                $table->decimal('total_sell_qty_after_edit',20,3)->default(0)->comment('when editing');


                $table->decimal('sold_price',20,2)->default(0)->comment('creating time');

                $table->decimal('discount_amount',20,2)->default(0)->comment('creating time');
                $table->string('discount_type',12)->nullable()->comment('percentage, fixed');
                $table->decimal('total_discount',20,2)->default(0)->comment('creating time');

                $table->decimal('reference_commission',20,2)->default(0);
                
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
        Schema::dropIfExists('edit_sell_cart_products');
    }
}
