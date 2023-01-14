<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('product_stocks')){
            Schema::create('product_stocks', function (Blueprint $table) {
                
                $table->id();
                $table->integer('branch_id')->nullable();
                $table->integer('stock_id')->nullable();
                $table->integer('product_id')->nullable();
                $table->decimal('available_base_stock',20,3)->default(0.000)->comment('no change, same to product purchase unit');
                $table->decimal('reduced_base_stock_remaining_delivery',20,3)->default(0.000)->comment('reduced_base_stock_remaining_delivery:- reduced base stock , but not delivery this stock. (remaining delivery)');
                $table->decimal('negative_sold_base_stock',20,3)->default(0.000)->comment('sold this stock, but not available then. so its negative stock. when purchase product and received stock, then this stock have to minus, but not effect on main base stock - just minus from this stock - available_base_stock');
                $table->decimal('used_base_stock',20,3)->default(0.000)->comment('used base unit stock  including stock transfer');
                
                $table->decimal('available_stock',20,3)->default(0.000)->comment('delete this field later..');
                $table->decimal('used_stock',20,3)->default(0.000)->comment('delete this field later..total used stock including stock transfer');
                $table->decimal('alert_quantity',20,3)->default(0);
                $table->tinyInteger('stock_lock_applicable')->default(0)->comment('delete this field later..0 = is regular process, 1= activate, never transfer or sell from this stock');
                $table->decimal('stock_lock_quantity',20,3)->nullable()->comment('delete this field later..');

                $table->string('verified',25)->nullable();
                $table->integer('verified_by')->nullable();
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
        Schema::dropIfExists('product_stocks');
    }
}
