<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterHourPhase17 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hour', function (Blueprint $table) {
          $table->time('mulai');
          $table->time('selesai');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hour', function (Blueprint $table) {
          $table->dropColumn('mulai');
          $table->dropColumn('selesai');
        });
    }
}
