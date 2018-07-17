<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTambahanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('tambahan', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('karyawan_id')->unsigned();
        $table->string('kategori')->nullable();
        $table->double('nominal')->default(0);
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
        Schema::dropIfExists('tambahan');
    }
}
