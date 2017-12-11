<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller ;

use Carbon\Carbon ;
use DB ;

use App\Models\Pengaturan;
use App\Models\Karyawan;
use App\Models\Hauling;
use App\Models\Trip ;

class TripController extends Controller
{
    public function karyawan($mulai)
    {
        return hauling::groupBy('karyawan_id')
                      ->whereMonth('tanggal' , $mulai->format('m'))
                      ->whereyear('tanggal' , $mulai->format('Y'))
                      ->orderBy('updated_at','desc')
                      ->orderBy('created_at','desc');
    }

    public function index()
    {
      \DB::enableQueryLog() ;

      //request
      $bulan            = request('bulan',date('n'));
      $tahun            = request('tahun',date('Y'));
      // tanggal
      $mulai            = Carbon::now()->month($bulan)->year($tahun)->startOfMonth();
      $selesai          = Carbon::now()->month($bulan)->year($tahun)->endOfMonth();
      $akhir            = $mulai->copy()->addMonth()->startOfMonth();
      // tahun
      $tahunSekarang    = Carbon::now();
      $tahunAwal        = Carbon::now()->subYear(18);
      // total trip, list bulan
      // $nominalTrip      = Hauling::nominalTrip()->kondisi($mulai,$selesai);
      $listBulan        = config('hrd.bulan');
      //pilihan warna
      session()->put('warna','trip');
      session()->put('pilihan','');

      if (request('rekap')) {
          $view         = 'trip.rekap' ;
          $karyawan     = $this->karyawan($mulai)->get();
      }else{
          $view         = 'trip.index' ;
          $karyawan     =  $this->karyawan($mulai)->paginate(10);
      }

      $totalTrip        = [];
      $nominalTrip      = [];
      $totalNominalTrip = [];
      foreach ($karyawan as $index => $item){
          for ($date = $mulai->copy(); $date->diffInDays($akhir) ; $date->addDay()) {
              $totalTrip[$date->format('Y-m-d')] = Hauling::select('karyawan_id',DB::raw("SUM(trip) as 'total'"))
                                                          ->where('tanggal',$date->format('Y-m-d'))
                                                          ->groupBy('karyawan_id')
                                                          ->pluck('total','karyawan_id');

              $biasa                          = Pengaturan::where('id',$item->karyawan->pengaturan_id)->value('biasa');
              $lumayan                        = Pengaturan::where('id',$item->karyawan->pengaturan_id)->value('lumayan');
              $bonus                          = Pengaturan::where('id',$item->karyawan->pengaturan_id)->value('bonus');

              if (array_get($totalTrip[$date->format('Y-m-d')],$item->karyawan->id) == 0 ) {
                  $nominalTrip[$date->format('Y-m-d')][$item->karyawan->id] =0;
              }
              if (array_get($totalTrip[$date->format('Y-m-d')],$item->karyawan->id) >= 1 && array_get($totalTrip[$date->format('Y-m-d')],$item->karyawan->id) <= 4) {
                  $nominalTrip[$date->format('Y-m-d')][$item->karyawan->id] =array_get($totalTrip[$date->format('Y-m-d')],$item->karyawan->id) * $biasa ;
              }
              if (array_get($totalTrip[$date->format('Y-m-d')],$item->karyawan->id) >= 5) {
                  $nominalTrip[$date->format('Y-m-d')][$item->karyawan->id] =array_get($totalTrip[$date->format('Y-m-d')],$item->karyawan->id) * $lumayan ;
              }
              if (array_get($totalTrip[$date->format('Y-m-d')],$item->karyawan->id) == 120) {
                  $nominalTrip[$date->format('Y-m-d')][$item->karyawan->id] =array_get($totalTrip[$date->format('Y-m-d')],$item->karyawan->id) + $bonus ;
              }

              $totalNominalTrip[$item->karyawan->id] = array_sum(array_pluck($nominalTrip,$item->karyawan->id));
          }
      }

      return view($view,compact(
          'mulai','akhir','karyawan','totalTrip','nominalTrip','totalNominalTrip','listBulan','tahunSekarang','tahunAwal',
          'selesai'
      ));
    }

    public function create()
    {
        $action = route('trip.store');
        $method = 'POST' ;

        return view('trip.form',compact('action','method')) ;
    }

    public function store()
    {
        $this->validate(request(),[
            'biasa'   => 'required|numeric',
            'lumayan' => 'required|numeric',
            'bonus'   => 'required|numeric',
        ]);

        $trip = new Trip ;
        $trip->biasa    = str_replace(',', '.', str_replace('.', '', request('biasa'))) ;
        $trip->lumayan  = str_replace(',', '.', str_replace('.', '', request('lumayan'))) ;
        $trip->bonus    = str_replace(',', '.', str_replace('.', '', request('bonus'))) ;
        $trip->save() ;

        return redirect()->route('trip.create')->with('note','Data Berhasil Masuk');

    }



    // $biasa                          = Pengaturan::where('id',$item->karyawan->pengaturan_id)->value('biasa');
    // $lumayan                        = Pengaturan::where('id',$item->karyawan->pengaturan_id)->value('lumayan');
    // $bonus                          = Pengaturan::where('id',$item->karyawan->pengaturan_id)->value('bonus');
    // $nominalTrip[$item->karyawan->id] = array_get($totalTrip[$item->karyawan->id],$item->karyawan->id);
    //
    // if ($nominalTrip[$item->karyawan->id] >= 1 && $nominalTrip[$item->karyawan->id] <= 4) {
    //     $hasilNominalTrip[$date->format('Y-m-d')][$item->karyawan->id] = $nominalTrip[$item->karyawan->id] * $biasa ;
    // }
    // if ($nominalTrip[$item->karyawan->id] >= 5) {
    //     $hasilNominalTrip[$date->format('Y-m-d')][$item->karyawan->id] = $nominalTrip[$item->karyawan->id] * $lumayan ;
    // }
    // if ($nominalTrip[$item->karyawan->id] == 120) {
    //     $hasilNominalTrip[$date->format('Y-m-d')][$item->karyawan->id] = $nominalTrip[$item->karyawan->id] + $bonus ;
    // }
}
