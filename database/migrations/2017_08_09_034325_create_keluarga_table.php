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
