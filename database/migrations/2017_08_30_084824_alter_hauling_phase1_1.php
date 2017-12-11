<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterHaulingPhase11 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hauling', function (Blueprint $table) {
            if (Schema::hasColumn('hauling', 'unit','nik')) {
                $table->dropColumn('unit');
                $table->dropColumn('nik');
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
        Schema::table('hauling', function (Blueprint $table) {
            $table->string('unit');
            $table->double('nik');
        });
    }
}
