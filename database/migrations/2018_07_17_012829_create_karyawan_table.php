<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKaryawanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('karyawan', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('biodata_id')->unsigned();
          $table->integer('departemen_id')->unsigned();
          $table->integer('jabatan_id')->unsigned();
          $table->integer('site_id')->unsigned();
          $table->integer('setabsen_id')->unsigned();

          $table->string('golongan')->nullable();
          $table->string('status')->nullable();
          $table->string('status_kerja')->nullable();
          $table->double('gapok')->default(0);
          $table->double('uang_makan')->default(0);
          $table->double('tunjangan')->default(0);
          $table->date('tanggal_masuk')->nullable();
          $table->string('kode')->nullable();
          $table->string('nrp')->nullable();
          $table->integer('npwp')->unsigned();
          $table->integer('jamsostek')->unsigned();
          $table->integer('rekening')->unsigned();
          $table->integer('bpjs')->unsigned();
          $table->string('jenis_bank');
          $table->string('status_pernikahan');
          $table->string('foto');
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
          $table->string('simper')->nullable();
          $table->string('finger_print')->nullable();
          $table->double('tunjangan_jabatan')->default(0);
          $table->double('sa_harian')->default(0);
          $table->double('bpjs_tk')->default(0);
          $table->double('bpjs_kes')->default(0);
          $table->string('jenis_kerja')->nullable();
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
        Schema::dropIfExists('karyawan');
    }
}
