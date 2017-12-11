<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterHourPhase16 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('hour', function (Blueprint $table) {
          if (Schema::hasColumn('hour', 'mulai','selesai')) {
              $table->dropColumn('mulai');
              $table->dropColumn('selesai');
          }
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
            $table->double('mulai')->default(0);
            $table->double('selesai')->default(0);
        });
    }
}
