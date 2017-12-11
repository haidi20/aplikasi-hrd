<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePengaturanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengaturan', function (Blueprint $table) {
            $table->increments('id');
            $table->double('biasa')->default(0);
            $table->double('lumayan')->default(0);
            $table->double('bonus')->default(0);
            $table->double('sa_harian')->default(0);
            $table->double('uang_makan')->defualt(0);
            $table->double('alat_biasa')->default(0);
            $table->double('alat_spesial')->default(0);
            $table->double('kasbon')->default(0);
            $table->double('pph21')->default(0);
            $table->double('lain_lain')->default(0);
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
        Schema::dropIfExists('pengaturan');
    }
}
