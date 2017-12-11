<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterKaryawanPhase8 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('karyawan', function (Blueprint $table) {
            $table->string('status_kerja')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('karyawan', function (Blueprint $table) {
            $table->dropColumn('status_kerja');
        });
    }
}
