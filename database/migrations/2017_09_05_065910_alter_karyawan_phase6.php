<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterKaryawanPhase6 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('karyawan', function (Blueprint $table) {
          if(Schema::hasColumn('karyawan', 'sim')){
              $table->dropColumn('sim');
          }
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
            $table->string('sim') ;
        });
    }
}
