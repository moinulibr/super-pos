<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->integer('branch_id')->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone',15)->unique();
            $table->integer('user_role_id')->nullable();
            $table->tinyInteger('user_type')->default(4)->comment('1=developer, 2=supper admin, 3=admin, 4=staff');
            $table->timestamp('email_verified_at')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
