<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellProfitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('sell_profits')){
            Schema::create('sell_profits', function (Blueprint $table) {
                $table->integer('branch_id')->nullable();
               
                $table->string('date',30)->nullable()->comment('date');
                $table->integer('module_id')->nullable()->comment('Module id 1= regular sell, 2=sell return,3=edited less amount, 4=edited more amount,5=overall discount');
                
                $table->string('invoice_no',30)->nullable()->comment('Module invoice no');
                $table->integer('invoice_id')->nullable()->comment('Module invoice id ');

                $table->tinyInteger('cdf_type_id')->nullable()->comment('c=credit,d=debit,f=fund');
                $table->decimal('sell_amount',20,2)->default(0);
                $table->decimal('purchase_amount',20,2)->default(0);
                $table->decimal('profit',20,2)->default(0);
                $table->decimal('cdc_amount',20,2)->default(0)->comment('after credit/debit calculation amount');
                
                $table->integer('user_id')->nullable()->comment('user like: customer');

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
        Schema::dropIfExists('sell_profits');
    }
}
