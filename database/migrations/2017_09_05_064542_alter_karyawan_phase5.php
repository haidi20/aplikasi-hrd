<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterKaryawanPhase5 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('karyawan', function (Blueprint $table) {
            $table->string('fiskal');
            $table->date('tanggal_keluar')->nullable();
            $table->string('masa_kerja')->nullable();
            $table->string('nama_atasan')->nullable();
            $table->string('divisi')->nullable();
            $table->string('cara_bayar')->nullable();
            $table->string('cabang_bank')->nullable();
            $table->string('sim_a')->nullable();
            $table->string('sim_b')->nullable();
            $table->string('sim_b2')->nullable();
            $table->string('sim_c')->nullable();
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
          $table->dropColumn('fiskal');
          $table->dropColumn('tanggal_keluar');
          $table->dropColumn('masa_kerja');
          $table->dropColumn('nama_atasan');
          $table->dropColumn('divisi');
          $table->dropColumn('cara_bayar');
          $table->dropColumn('cabang_bank');
          $table->dropColumn('sim_a');
          $table->dropColumn('sim_b');
          $table->dropColumn('sim_b2');
          $table->dropColumn('sim_c');
        });
    }
}
