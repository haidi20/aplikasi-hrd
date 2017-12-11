<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterKaryawanPhase3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('karyawan', function (Blueprint $table) {
            $table->integer('npwp')->unsigned();
            $table->integer('jamsostek')->unsigned();
            $table->integer('rekening')->unsigned();
            $table->integer('bpjs')->unsigned();
            $table->string('jenis_bank');
            $table->string('status_pernikahan');
            $table->string('sim');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('karyawan', function (Blueprint $table) {
            //
        });
    }
}
