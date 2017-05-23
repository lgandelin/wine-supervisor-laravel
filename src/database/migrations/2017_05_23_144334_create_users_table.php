<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->uuid('id')->primary('id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->string('remember_token')->nullable();
            $table->text('address')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('city')->nullable();
            $table->string('phone')->nullable();
            $table->datetime('last_connection_date')->nullable();
            $table->datetime('creation_date')->nullable();
            $table->datetime('update_date')->nullable();
            $table->boolean('opt_in')->nullable();
            $table->boolean('is_administrator')->nullable();
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
        Schema::drop('users');
    }
}
