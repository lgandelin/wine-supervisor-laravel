<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateWsTableAddActivationCode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ws', function (Blueprint $table) {
            $table->string('activation_code')->after('board_type')->nullable();
            $table->integer('cd_ws_id')->after('id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ws', function (Blueprint $table) {
            $table->dropColumn('activation_code');
            $table->dropColumn('cd_ws_id');
        });
    }
}
