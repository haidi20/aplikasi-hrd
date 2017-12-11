<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterBiodataPhase2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('biodata', function (Blueprint $table) {
            $table->string('kewarganegaraan')->nullable();
            $table->string('warganegara')->nullable();
            $table->string('nama_depan')->nullable();
            $table->string('nama_belakang')->nullable();
            $table->string('rt')->nullable();
            $table->string('rw')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kelurahan')->nullable();
            $table->string('kota')->nullable();
            $table->string('status_rumah')->nullable();
            $table->string('pendidikan_terakhir')->nullable();
            $table->string('instansi_pendidikan')->nullable();
            $table->string('jurusan')->nullable();
            $table->date('tahun_masuk')->nullable();
            $table->date('tahun_kelulusan')->nullable();
            $table->double('nilai_akhir')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('biodata', function (Blueprint $table) {
          $table->dropColumn('kewarganegaraan');
          $table->dropColumn('warganegara');
          $table->dropColumn('nama_depan');
          $table->dropColumn('nama_belakang');
          $table->dropColumn('alamat_ktp');
          $table->dropColumn('rt');
          $table->dropColumn('rw');
          $table->dropColumn('kecamatan');
          $table->dropColumn('kelurahan');
          $table->dropColumn('kota');
          $table->dropColumn('status_rumah');
          $table->dropColumn('pendidikan_terakhir');
          $table->dropColumn('instansi_pendidikan');
          $table->dropColumn('jurusan');
          $table->dropColumn('tahun_masuk');
          $table->dropColumn('tahun_kelulusan');
          $table->dropColumn('nilai_akhir');
        });
    }
}
