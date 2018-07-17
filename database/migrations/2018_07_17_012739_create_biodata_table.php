<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateBiodataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('biodata', function (Blueprint $table) {
          $table->increments('id');
          $table->string('nama_panggilan')->nullable();
          $table->string('nama_lengkap')->nullable();
          $table->string('tempat_lahir')->nullable();
          $table->date('tanggal_lahir')->nullable();
          $table->string('status')->nullable();
          $table->string('pendidikan')->nullable();
          $table->string('alamat')->nullable();
          $table->string('agama')->nullable();
          $table->string('ktp')->nullable();
          $table->date('akhir_ktp')->nullable();
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
        Schema::dropIfExists('biodata');
    }
}
