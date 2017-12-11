<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterHourPhase6 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hour', function (Blueprint $table) {
            $table->double('mulai_des')->nullable();
            $table->double('selesai_des')->nullable();
            $table->double('total_des')->nullable();
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
            $table->dropColumn('mulai_des');
            $table->dropColumn('selesai_des');
            $table->dropColumn('total_des');
        });
    }
}
