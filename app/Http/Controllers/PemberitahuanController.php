<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Http\Controllers\Controller ;

use Carbon\Carbon ;

use App\rumus\Payrol;
use App\Models\Potongan;
use App\Models\Tambahan;
use App\Models\Karyawan;
use App\Models\Biodata;

class PemberitahuanController extends Controller
{
    public function index()
    {
        $sekarang                   = Carbon::now();
        $masaKtp                    = Biodata::join('karyawan','biodata.id','=','karyawan.biodata_id')
                                             ->select('karyawan.nik','biodata.*')
                                             ->get();
        $masaKontrak                = Karyawan::all();
        $finger                     = '';
        $potongan                   = [];
        $tambahan                   = [];
        $ktp                        = [];
        $kontrak                    = [];
        $statusKtp                  = [];
        $statusKontrak              = [];
        $masaBerlakuKtp             = [];
        $masaBerlakuKontrak         = [];

        if ($sekarang->format('d') == 10 || $sekarang->format('d') == 20 || $sekarang->format('d') == 25 || $sekarang->format('d') == 30  ) {

            $finger   =
            '<div class="row">
              <div class="col-md-12">
                <div class="alert alert-success" role="alert">
                  <td><h5>Mohon di Upload Data Finger</h5></td>
                  <td><h5>'.$sekarang->format('d-m-Y').'</h5></td>
                </div>
              </div>
            </div>';
        }

        if ($sekarang->format('d') == 28 ) {
            $potongan = Potongan::where('kategori','Kasbon')->orderBy('created_at','desc')->get();
            $tambahan = Tambahan::where('kategori','rapel')->orderBy('created_at','desc')->get();
        }

        foreach ($masaKtp as $index => $item){
            $akhirKtp               = plain_date($item->akhir_ktp);
            if ($akhirKtp) {
                $tanggalAkhirKtp    = Carbon::parse($akhirKtp);
                if ($sekarang->format('m-d') <= $tanggalAkhirKtp->format('m-d')){
                    $kondisiKtp     = $sekarang->diffInDays($tanggalAkhirKtp->addDay());
                }else{
                    $kondisiKtp     = $sekarang->diffInDays($tanggalAkhirKtp);
                }
                if ($kondisiKtp >= 0 && $kondisiKtp <= 10) {
                    $masaBerlakuKtp[$item->id]= $kondisiKtp ;
                    $ktp[]      = $item ;
                    if ($sekarang->format('m-d') <= $tanggalAkhirKtp->format('m-d')) {
                        $statusKtp[$item->id] = '-';
                    }else{
                        $statusKtp[$item->id] = '+';
                    }
                }
            }
        }

        foreach ($masaKontrak as $index => $item) {
            $akhirKontrak             = plain_date($item->tanggal_keluar);
            if ($akhirKontrak) {
              $tanggalAkhirKontrak    = Carbon::parse($akhirKontrak);
              $kondisiKontrak         = $sekarang->diffInDays($tanggalAkhirKontrak);
              if ($kondisiKontrak >= 0 && $kondisiKontrak <= 10) {
                  $masaBerlakuKontrak[$item->id] = $kondisiKontrak ;
                  $kontrak[]          = $item ;
                  if ($sekarang->format('m-d') <= $tanggalAkhirKontrak->format('m-d')) {
                      $statusKontrak[$item->id]= '-';
                  }else{
                      $statusKontrak[$item->id]= '+';
                  }
              }
            }
        }


        session()->put('warna','pemberitahuan');
        session()->put('pilihan','');

        return view('pemberitahuan.index',compact(
            'ktp','kontrak','masaBerlakuKtp','masaBerlakuKontrak','potongan','tambahan',
            'finger','statusKtp','statusKontrak'
        ));
    }
}
