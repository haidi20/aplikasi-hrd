<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSetabsenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('setabsen', function (Blueprint $table) {
          $table->increments('id');
          $table->double('ir')->default(0);
          $table->double('i')->default(0);
          $table->double('s')->default(0);
          $table->double('s1')->default(0);
          $table->double('a')->default(0);
          $table->double('x')->default(0);
          $table->double('mi')->default(0);
          $table->double('ct')->default(0);
          $table->double('l')->default(0);
          $table->double('m')->default(0);
          $table->double('off')->default(0);
          $table->date('tanggal')->nullable();
          $table->double('lembur')->default(0);
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
        Schema::dropIfExists('setabsen');
    }
}
