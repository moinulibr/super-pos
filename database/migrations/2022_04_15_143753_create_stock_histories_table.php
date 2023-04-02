<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('stock_histories')){
            Schema::create('stock_histories', function (Blueprint $table) {
                $table->id();
                $table->integer('branch_id')->nullable();
                $table->integer('stock_id')->nullable()->comment('main character');
                $table->integer('product_stock_id')->nullable()->comment('main character');
                $table->integer('product_id')->nullable()->comment('main character');
                $table->integer('stock_changing_type_id')->nullable();
                $table->string('stock_changing_sign',5)->nullable()->comment('it alway + or -');
                $table->text('stock_changing_history')->nullable()->comment('json data store here from stock id to stock id');

                $table->decimal('stock',20,3)->nullable()->comment('real product (as product purchase unit) stock');
                
                $table->integer('main_module_invoice_id',)->nullable()->comment('main module invoice id = like sell, purchase primary id, (child is sell return, purchase return)');
                $table->string('main_module_invoice_no',50)->nullable()->comment('main module invoice = like sell, purchase invoice no, (child is sell return, purchase return)');
                $table->string('main_module_invoice_created_date',30)->nullable()->comment('main module invoice created date = like sell, purchase created date');
              
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
        Schema::dropIfExists('stock_histories');
    }
}
