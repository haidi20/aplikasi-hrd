<?php

namespace App\Http\Controllers;

use App\Providers\PaginatorServiceProvider ;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;
use Excel;
use DB;

use App\Models\Pengaturan;
use App\Models\Setabsen;
use App\Models\Karyawan;
use App\Models\Biodata;
use App\Models\Absen;

class AbsenController extends Controller
{
    public function karyawan()
    {
        return Karyawan::nama()
                       ->orderBy('updated_at','desc')
                       ->orderBy('created_at','desc');
    }

    public function index()
    {
        $bulan            = request('bulan', date('n'));
        $tahun            = request('tahun', date('Y'));
        $nama             = request('nama');

        if (request('rekap')) {
            $view = 'absen.rekap' ;
            $karyawan = $this->karyawan()->get();
        }elseif (request('laporan')) {
            return redirect()->route('laporan.index');
        }else{
            $view = 'absen.index' ;
            $karyawan = $this->karyawan()->paginate(10);
        }

        session()->put('warna','absen');
        session()->put('pilihan','');

        $mulai            = Carbon::now()->month($bulan)->year($tahun)->startOfMonth();
        $selesai          = Carbon::now()->month($bulan)->year($tahun)->endOfMonth();
        $akhir            = $mulai->copy()->addMonth()->startOfMonth();
        $tahunSekarang    = Carbon::now();
        $tahunAwal        = Carbon::now()->subYear(18);
        $method           = 'POST';
        $totalAbsen       = Absen::seluruhStatus($mulai,$selesai)->pluck('total','karyawan_id');

        $listAbsen        = [];
        $listPengaturan   = [];
        $listAlpa         = [];

        for($date=$mulai->copy(); $date->diffInDays($akhir); $date->addDay()){
            $listAbsen[$date->format('Y-m-d')] = Absen::where('tanggal', $date)->pluck('status','karyawan_id');
        }

        foreach ($karyawan as $index => $item) {
            $pengaturan   = Pengaturan::where('id',$item->pengaturan_id)->get();
            if ($pengaturan){
                $biasa    = Pengaturan::where('id',$item->pengaturan_id)->value('biasa');
                $lumayan  = Pengaturan::where('id',$item->pengaturan_id)->value('lumayan');
                $bonus    = Pengaturan::where('id',$item->pengaturan_id)->value('bonus');
                $alpa     = Setabsen::where('id',$item->setabsen_id)->value('a');
                $listPengaturan[$item->id]         = 'Hauling Trip = Rp.'. number_format($biasa,2).' '.
                                                     'Rp.'. number_format($lumayan,2).' Rp.'. number_format($bonus,2);
                $listAlpa[$item->id]               = 'Nominal Alpa = Rp.'. number_format($alpa,2);
            }
        }

        $listBulan        = config('hrd.bulan');
        $kodeAbsen        = config('hrd.kode_absen');
        $keteranganAbsen  = config('hrd.keterangan_absen');

        return view($view,compact(
            'karyawan','mulai','akhir', 'listBulan', 'kodeAbsen', 'keteranganAbsen',
            'method', 'listAbsen','warnaAbsen','tahunSekarang','tahunAwal','totalAbsen',
            'selesai','listPengaturan','listAlpa'
        ));
    }

    public function save (Request $request)
    {
        \DB::enableQueryLog();
        return $excel ;
        if(request('import')){
            $this->validate(request(),[
                'excel'  => 'required'
            ]);
            $path = request()->file('excel');
            $data = Excel::load($path, function($reader) {})->get();
            if(!empty($data) && $data->count()){
                foreach ($data as $key => $value){
                    $tanggal      = $value->tanggal;
                    $karyawan_id  = $value->karyawan_id;
                    $absenImport  = Absen::firstOrCreate(compact('tanggal','karyawan_id'));
                    $absenImport->status = $value->status ;
                    // dd($absenImport);
                    $absenImport->save();
                    return redirect()->back()->with(['bulan' => request('bulan'),'page' => request('page')]);
                }
            }
        }

        $status = [] ;
        $status = request('status');

        foreach ($status as $tanggal => $item) {
            foreach ($item as $karyawan_id => $status) {
                $absen = Absen::firstOrCreate(compact('tanggal', 'karyawan_id'));
                $absen->status = $status ;
                // dd($absen);
                $absen->save() ;
            }
        }

        return redirect()->back()->with(['bulan' => request('bulan'),'page' => request('page')]);
    }

    public function test()
    {
      $path = storage_path('data/StandardReport.xls');

      $reader = Excel::load($path)->get();

      $startId = 4;

      $idAbsenKaryawan = [];

      // dd($reader);
      foreach ($reader as $index => $item) {
        foreach ($item as $index2 => $item2) {
          foreach ($item2 as $index3 => $item3) {
            echo $item3;
          }
        }
      }


      // return $idAbsenKaryawan;
    }
}
