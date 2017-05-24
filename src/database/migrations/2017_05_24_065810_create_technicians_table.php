<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTechniciansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('technicians', function (Blueprint $table) {
            $table->uuid('id')->primary('id');
            $table->string('company')->nullable();
            $table->string('registration')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->string('remember_token')->nullable();
            $table->text('address')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('city')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('status')->nullable();
            $table->datetime('last_connection_date')->nullable();
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
        Schema::drop('technicians');
    }
}
