<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterKeluargaPhase2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('keluarga', function (Blueprint $table) {
            $table->string('jenis_kelamin')->nullable();
            $table->string('pendidikan_terakhir')->nullable();
            $table->string('pekerjaan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('keluarga', function (Blueprint $table) {
            $table->dropColumn('jenis_kelamin');
            $table->dropColumn('pendidikan_terakhir');
            $table->dropColumn('pekerjaan');
        });
    }
}
