<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCellarHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cellar_history', function (Blueprint $table) {
            $table->uuid('id')->primary('id');
            $table->uuid('cellar_id')->nullable();
            $table->uuid('user_id')->nullable();
            $table->uuid('admin_id')->nullable();
            $table->string('column')->nullable();
            $table->string('old_value')->nullable();
            $table->string('new_value')->nullable();
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
        Schema::drop('cellar_history');
    }
}
