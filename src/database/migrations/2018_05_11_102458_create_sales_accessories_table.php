<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesAccessoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_accessories', function (Blueprint $table) {
            $table->uuid('id')->primary('id');
            $table->boolean('is_active')->nullable();
            $table->string('title')->nullable();
            $table->string('title_en')->nullable();
            $table->string('image')->nullable();
            $table->text('accessories')->nullable();
            $table->text('accessories_en')->nullable();
            $table->string('link')->nullable();
            $table->string('link_history')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->text('comments')->nullable();
            $table->text('comments_en')->nullable();
            $table->string('text_color')->nullable();
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
        Schema::drop('sales_accessories');
    }
}
