<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateContentsTableLangFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contents', function (Blueprint $table) {
            $table->string('title_en')->nullable()->after('title');
            $table->text('text_en')->nullable()->after('text');
        });

        Schema::table('sales', function (Blueprint $table) {
            $table->string('title_en')->nullable()->after('title');
            $table->string('comments_en')->nullable()->after('comments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contents', function (Blueprint $table) {
            $table->dropColumn('title_en');
            $table->dropColumn('text_en');
        });

        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn('title_en');
            $table->dropColumn('comments_en');
        });
    }
}
