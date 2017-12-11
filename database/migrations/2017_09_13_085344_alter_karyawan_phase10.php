<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterKaryawanPhase10 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('karyawan', function (Blueprint $table) {
            $table->double('tunjangan_jabatan')->default(0);
            $table->double('sa_harian')->default(0);
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
            $table->dropColumn('tunjangan_jabatan');
            $table->dropColumn('sa_harian');
        });
    }
}
