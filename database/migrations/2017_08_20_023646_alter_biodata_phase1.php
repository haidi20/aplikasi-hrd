<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterBiodataPhase1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('biodata', function($table){
            $table->string('ktp')->nullable();
            $table->date('akhir_ktp')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('biodata', function($table){
            $table->dropColumn('ktp');
            $table->dropColumn('akhir_ktp');
        });
    }
}
