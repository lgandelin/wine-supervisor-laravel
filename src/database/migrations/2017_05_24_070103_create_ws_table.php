<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ws', function (Blueprint $table) {
            $table->uuid('id')->primary('id');
            $table->string('id_ws')->nullable();
            $table->string('board_type')->nullable();
            $table->datetime('first_activation_date')->nullable();
            $table->datetime('deactivation_date')->nullable();
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
        Schema::drop('ws');
    }
}
