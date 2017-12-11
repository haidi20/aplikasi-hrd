<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Karyawan;

class LaporanController extends Controller
{
    public function index()
    {
        $warna        = 'absen' ;
        $pilihan      = '';
        $karyawan     = Karyawan::nama()->orderBy('updated_at','desc')->orderBy('created_at','desc')->paginate(10);


        return view('laporan.index',compact('warna','pilihan','karyawan'));
    }
}
