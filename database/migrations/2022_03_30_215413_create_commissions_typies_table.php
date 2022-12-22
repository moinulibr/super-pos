<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommissionsTypiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('commissions_typies')){
            Schema::create('commissions_typies', function (Blueprint $table) {
                $table->id();
                $table->integer('branch_id')->nullable();
                $table->string('name',50)->nullable();
                $table->text('description')->nullable();
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
        Schema::dropIfExists('commissions_typies');
    }
}
