<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHaulingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hauling', function(Blueprint $table){
            $table->increments('id');
            $table->integer('karyawan_id')->unsigned();
            $table->string('unit')->nullable();
            $table->string('nik')->nullable();
            $table->string('tipe')->nullable();
            $table->string('seam')->nullable();
            $table->date('tanggal')->nullable();
            $table->time('jam')->nullable();
            $table->double('tonase')->default(0);
            $table->integer('trip')->default(0);
            $table->integer('jarak')->default(0);
            $table->integer('shift')->default(0);
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
        Schema::dropIfExists('hauling');
    }
}
