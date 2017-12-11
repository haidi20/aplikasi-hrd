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
          $table->string('golongan')->nullable();
          $table->string('status')->nullable();
          $table->double('gapok')->default(0);
          $table->double('uang_makan')->default(0);
          $table->double('tunjangan')->default(0);
          $table->date('tanggal_masuk')->nullable();
          $table->string('kode')->nullable();
          $table->string('nrp')->nullable();
          $table->timestamps();

          /*$table->foreign('nama_panggilan_id')->references('id')
                ->on('biodata')->onDelete('cascade');
          $table->foreign('departemen_id')->references('id')
                ->on('departemen')->onDelete('cascade');
          $table->foreign('jabatan_id')->references('id')
                ->on('jabatan')->onDelete('cascade');*/
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
