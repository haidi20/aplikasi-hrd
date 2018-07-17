<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHourTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('hour', function (Blueprint $table) {
         $table->increments('id');
         $table->integer('karyawan_id')->unsigned();
         $table->integer('alat_id')->unsigned();
         $table->date('tanggal')->nullable();
         $table->integer('shift')->nullable();
         $table->time('mulai');
         $table->time('selesai');
         $table->double('total')->default(0);
         $table->double('total_harga')->default(0);
         $table->double('mulai_des')->nullable();
         $table->double('selesai_des')->nullable();
         $table->double('total_des')->nullable();
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
        Schema::dropIfExists('hour');
    }
}
