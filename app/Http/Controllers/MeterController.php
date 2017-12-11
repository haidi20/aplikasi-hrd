<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
use DB;

use App\Models\Pengaturan;
use App\Models\Karyawan;
use App\Models\Hour;

class MeterController extends Controller
{
    public function hour($mulai)
    {
        return Hour::groupBy('karyawan_id')
                   ->whereMonth('tanggal' , $mulai->format('m'))
                   ->whereyear('tanggal' , $mulai->format('Y'))
                   ->where('total_des','!=',null)
                   ->where('total_des','!=',0)
                   ->orderBy('created_at','desc');
    }

    public function index()
    {
        //request
        $bulan          = request('bulan',date('n'));
        $tahun          = request('tahun',date('Y'));
        // tanggal
        $mulai          = Carbon::now()->month($bulan)->year($tahun)->startOfMonth();
        $selesai        = Carbon::now()->month($bulan)->year($tahun)->endOfMonth();
        $akhir          = $mulai->copy()->addMonth()->startOfMonth();
        // tahun
        $tahunAwal      = Carbon::now()->subYear(18);
        $tahunSekarang  = Carbon::now();
        // total harga, list bulan
        $totalHarga     = Hour::nominalHM2()->kondisi($mulai,$selesai);
        $listBulan      = config('hrd.bulan');

        if (request('rekap')) {
            $view       = 'meter.rekap' ;
            $karyawan   = $this->hour($mulai)->get();
        }else{
            $view       = 'meter.index' ;
            $karyawan   = $this->hour($mulai)->paginate(10);
        }

        $jam            = [];
        $meter          = [];
        $totalHargaa    = [];
        foreach ($karyawan as $index => $item) {
            $peng_batasJam    = Pengaturan::where('id',$item->karyawan->pengaturan_id)->value('jam_alat');
            $peng_alatBiasa   = Pengaturan::where('id',$item->karyawan->pengaturan_id)->value('alat_biasa');
            $peng_alatSpesial = Pengaturan::where('id',$item->karyawan->pengaturan_id)->value('alat_spesial');
            for ($date = $mulai->copy(); $date->diffInDays($akhir) ; $date->addDay()) {
                $jam[$date->format('Y-m-d')]  = Hour::select('karyawan_id',DB::raw("sum(total_des) as total"))
                                                    ->where('tanggal',$date->format('Y-m-d'))
                                                    ->groupBy('karyawan_id')
                                                    ->pluck('total','karyawan_id');
                // dd($jam[$date->format('Y-m-d')]);
                if (array_get($jam[$date->format('Y-m-d')],$item->karyawan_id) < $peng_batasJam) {
                    $meter[$date->format('Y-m-d')][$item->karyawan_id] = array_get($jam[$date->format('Y-m-d')],$item->karyawan_id) * $peng_alatBiasa;
                }
                if(array_get($jam[$date->format('Y-m-d')],$item->karyawan_id) >= $peng_batasJam){
                    $meter[$date->format('Y-m-d')][$item->karyawan_id] = array_get($jam[$date->format('Y-m-d')],$item->karyawan_id) * $peng_alatSpesial;
                }
            }
            if (array_get($totalHarga,$item->karyawan_id) < $peng_batasJam) {
                $totalHargaa[$item->karyawan_id]                       = array_get($totalHarga,$item->karyawan_id) * $peng_alatBiasa;
            }
            if (array_get($totalHarga,$item->karyawan_id) >= $peng_batasJam) {
                $totalHargaa[$item->karyawan_id]                       = array_get($totalHarga,$item->karyawan_id) * $peng_alatSpesial;
            }
        }

        // return $meter ;

        session()->put('warna','meter');
        session()->put('pilihan','');

        return view($view,compact(
            'mulai','akhir','karyawan','meter','totalHarga','totalHargaa','listBulan', 'tahunSekarang','tahunAwal',
            'hourId','nama','selesai','warna','pilihan','jam'
        ));
    }
}
