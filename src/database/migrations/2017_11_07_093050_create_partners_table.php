<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partners', function (Blueprint $table) {
            $table->uuid('id')->primary('id');
            $table->string('name')->nullable();
            $table->string('image')->nullable();
            $table->string('image_width')->nullable();
            $table->string('image_height')->nullable();
            $table->string('url')->nullable();
            $table->integer('position')->nullable();
            $table->date('display_start_date')->nullable();
            $table->date('display_end_date')->nullable();
            $table->boolean('is_active')->nullable();
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
        Schema::drop('partners');
    }
}
