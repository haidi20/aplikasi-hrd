<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKeluargaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('keluarga', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('biodata_id')->unsigned();
          $table->string('jenis')->nullable(); // Istri, Anak,
          $table->string('nama')->nullable();
          $table->date('tanggal_lahir')->nullable();
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
          $table->string('jenis_kelamin')->nullable();
          $table->string('pekerjaan')->nullable();
          $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('keluarga');
    }
}
