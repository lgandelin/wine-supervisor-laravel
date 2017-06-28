<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCellarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cellars', function (Blueprint $table) {
            $table->uuid('id')->primary('id');
            $table->string('id_ws')->nullable();
            $table->uuid('user_id')->nullable();
            $table->uuid('technician_id')->nullable();
            $table->string('name')->nullable();
            $table->datetime('first_activation_date')->nullable();
            $table->datetime('subscription_start_date')->nullable();
            $table->datetime('subscription_end_date')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('subscription_type')->nullable();
            $table->text('address')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('city')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
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
        Schema::drop('cellars');
    }
}
