<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersAndTechniciansTablesDeleteLogin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('login');
        });

        Schema::table('technicians', function (Blueprint $table) {
            $table->dropColumn('login');
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
            $table->string('login')->nullable();
        });

        Schema::table('technicians', function (Blueprint $table) {
            $table->string('login')->nullable();
        });
    }
}
