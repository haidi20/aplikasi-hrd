<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterKaryawanPhase11 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('karyawan', function (Blueprint $table) {
            $table->double('bpjs_tk')->default(0);
            $table->double('bpjs_kes')->default(0);
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
            $table->dropColumn('bpjs_tk');
            $table->dropColumn('bpjs_kes');
        });
    }
}
