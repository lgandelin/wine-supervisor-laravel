<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTechnicianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('technicians', function (Blueprint $table) {
            $table->boolean('opt_in')->after('technician_code')->default(0)->nullable();
        });

        Schema::table('guests', function (Blueprint $table) {
            $table->boolean('opt_in')->after('read_only')->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('technicians', function (Blueprint $table) {
            $table->dropColumn('opt_in');
        });

        Schema::table('guests', function (Blueprint $table) {
            $table->dropColumn('opt_in');
        });
    }
}
