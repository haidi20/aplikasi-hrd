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
            $table->date('tanggal')->nullable();
            $table->integer('shift')->nullable();
            $table->double('mulai')->default(0);
            $table->double('selesai')->default(0);
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
