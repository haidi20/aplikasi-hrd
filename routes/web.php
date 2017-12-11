<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::auth();

Route::group(['middleware' => 'auth'], function(){
    Route::get('/', function () {
        return redirect()->route('pemberitahuan.index');
    });

    Route::group(['prefix' => 'master', 'namespace' => 'Master', 'as' => 'master::'], function(){

        Route::get('keluarga/{id}', 'KeluargaController@edit')->name('keluarga.editt');
        Route::resource('departemen', 'DepartemenController');
        Route::resource('karyawan', 'KaryawanController');
        Route::resource('keluarga', 'KeluargaController');
        Route::resource('jabatan', 'JabatanController');
        Route::resource('biodata', 'BiodataController');
        Route::resource('site', 'SiteController');
        Route::resource('alat', 'AlatController');

    });

    Route::get('kirim','MailController@kirim');

    Route::get('absen/export', 'ExportController@absen')->name('absen.export');
    Route::get('meter/export', 'ExportController@meter')->name('meter.export');
    Route::get('trip/export', 'ExportController@trip')->name('trip.export');

    Route::get('pemberitahuan','PemberitahuanController@index')->name('pemberitahuan.index');
    Route::post('absen', 'AbsenController@save')->name('absen.update');
    Route::get('absen', 'AbsenController@index')->name('absen.index');
    Route::resource('pengaturan','PengaturanController');
    Route::resource('waktu-hauling','WaktuController');
    Route::resource('setabsen','SetabsenController');
    Route::resource('tambahan','TambahanController');
    Route::resource('potongan','PotonganController');
    Route::resource('setemail','SetMailController');
    Route::resource('hauling', 'HaulingController');
    Route::resource('laporan','LaporanController');
    Route::resource('payrol','PayrolController');
    Route::resource('meter','MeterController');
    Route::resource('hour', 'HourController');
    Route::resource('trip', 'TripController');
    Route::resource('slip', 'SlipController');


    Route::get('test', 'AbsenController@test');
});
