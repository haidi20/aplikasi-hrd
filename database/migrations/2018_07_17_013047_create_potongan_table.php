<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePotonganTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('potongan', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('karyawan_id')->unsigned();
          $table->string('kategori')->nullable();
          $table->double('nominal')->nullable();
          $table->date('tanggal')->nullable();
          $table->string('keterangan')->nullable();
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
        Schema::dropIfExists('potongan');
    }
}
