<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSalesTableUpdateFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn('jury_note');
            $table->dropColumn('jury_opinion');
            $table->string('image')->after('description')->nullable();
            $table->text('wines')->after('image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->text('jury_note')->after('title')->nullable();
            $table->text('jury_opinion')->after('jury_note')->nullable();
            $table->dropColumn('image');
            $table->dropColumn('wines');
        });
    }
}
