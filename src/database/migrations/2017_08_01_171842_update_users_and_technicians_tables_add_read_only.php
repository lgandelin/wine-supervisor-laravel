<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersAndTechniciansTablesAddReadOnly extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('read_only')->nullable()->after('cd_password');
        });

        Schema::table('technicians', function (Blueprint $table) {
            $table->boolean('read_only')->nullable()->after('super_tech');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('read_only');
        });


        Schema::table('technicians', function (Blueprint $table) {
            $table->dropColumn('read_only');
        });
    }
}
