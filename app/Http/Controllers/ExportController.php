<?php

namespace App\Http\Controllers;

use App\Providers\PaginatorServiceProvider ;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;
use Excel;
use DB;

use App\Models\Pengaturan;
use App\Models\Karyawan;
use App\Models\Setabsen;
use App\Models\Potongan;
use App\Models\Tambahan;
use App\Models\Hauling;
use App\Models\Biodata;
use App\Models\Absen;
use App\Models\Trip;
use App\Models\Hour;

class ExportController extends Controller
{
    public function meter()
    {
        //request
        $bulan          = request('bulan',date('n'));
        $tahun          = request('tahun',date('Y'));
        // tanggal
        $mulai          = Carbon::now()->month($bulan)->year($tahun)->startOfMonth();
        $selesai        = Carbon::now()->month($bulan)->year($tahun)->endOfMonth();
        $akhir          = $mulai->copy()->addMonth()->startOfMonth();
        // tahun
        $tahunSekarang  = Carbon::now();
        $tahunAwal      = Carbon::now()->subYear(18);
        // total harga, list bulan
        $totalHarga     = Hour::nominalHM()->kondisi($mulai,$selesai);
        $listBulan      = config('hrd.bulan');

        $karyawan       = Hour::groupBy('karyawan_id')->orderBy('updated_at','desc')->orderBy('created_at','desc')->get();

        $listKodeKolom    = config('hrd.kode_kolom');
        $jumlahKodeKolom  = count($listKodeKolom);

        $jumlahKaryawan = count($karyawan) + 8;
        $jumlahTanggal  = $selesai->format('d');
        if ($jumlahTanggal == 30) {
            $kodeKolom  = 'AF8';
            $kodeKolomBor = 'AG';
        }elseif($jumlahTanggal == 31){
            $kodeKolom  = 'AH8';
            $kodeKolomBor = 'AH';
        }else{
            $kodeKolom  = 'AD8';
            $kodeKolomBor = 'AE';
        }

        $meter          = [] ;
        for ($date = $mulai->copy(); $date->diffInDays($akhir) ; $date->addDay()) {
            $meter[$date->format('Y-m-d')] = Hour::select('karyawan_id',DB::raw("sum(total_harga) as total"))
                                            ->where('tanggal',$date->format('Y-m-d'))
                                            ->groupBy('karyawan_id')
                                            ->pluck('total','karyawan_id');
        }

        $view = [$mulai,$akhir,$karyawan,$meter,$totalHarga,$listBulan,$tahunSekarang,$tahunAwal] ;

        // return view('meter.export',compact(
        //     'mulai','akhir','karyawan','meter','totalHarga','listBulan', 'tahunSekarang','tahunAwal'
        // ));

        Excel::create('HM_Alat' , function($excel) use ($view,$listKodeKolom,$jumlahKodeKolom,$kodeKolomBor,$jumlahKaryawan,$kodeKolom){
            $excel->sheet('mySheet' , function($sheet) use ($view,$listKodeKolom,$jumlahKodeKolom,$kodeKolomBor,$jumlahKaryawan,$kodeKolom){
                $sheet->setWidth('A',4);
                $sheet->setWidth('B',35);
                for ($i=0; $i < $jumlahKodeKolom ; $i++) {
                    $sheet->setWidth($listKodeKolom[$i], 17);
                }
                $sheet->setWidth('AG', 17);
                // baris
                $sheet->setBorder('A6:'.$kodeKolomBor.$jumlahKaryawan, 'thin', "D8572C");
                $sheet->getStyle('A6:'.$kodeKolomBor.'6')->applyFromArray(array(
                    'fill' => array(
                        'type'  => \PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'BFBFBF')
                    )
                ));
                $sheet->getStyle('C7:'.$kodeKolom)->applyFromArray(array(
                    'fill' => array(
                        'type'  => \PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'D9D9D9')
                    )
                ));
                $sheet->loadView('meter.export')->with('mulai',$view[0])
                                                ->with('akhir',$view[1])
                                                ->with('karyawan',$view[2])
                                                ->with('meter',$view[3])
                                                ->with('totalHarga',$view[4])
                                                ->with('listBulan',$view[5])
                                                ->with('tahunSekarang',$view[6])
                                                ->with('tahunAwal',$view[7]);
            });
        })->download('xlsx');
    }

    public function karyawan($mulai)
    {
        return hauling::groupBy('karyawan_id')
                      ->whereMonth('tanggal' , $mulai->format('m'))
                      ->whereyear('tanggal' , $mulai->format('Y'))
                      ->orderBy('updated_at','desc')
                      ->orderBy('created_at','desc');
    }

    public function trip()
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

        $listKodeKolom    = config('hrd.kode_kolom');
        $jumlahKodeKolom  = count($listKodeKolom);

        $jumlahKaryawan = count($karyawan) + 8;
        $jumlahTanggal  = $selesai->format('d');
        if ($jumlahTanggal == 30) {
            $kodeKolom  = 'AF8';
            $kodeKolomBor = 'AG';
        }elseif($jumlahTanggal == 31){
            $kodeKolom  = 'AH8';
            $kodeKolomBor = 'AH';
        }else{
            $kodeKolom  = 'AD8';
            $kodeKolomBor = 'AE';
        }

        // return view('trip.export',compact(
        //     'mulai','akhir','karyawan','totalTrip','nominalTrip','totalNominalTrip','listBulan','tahunSekarang','tahunAwal',
        //     'selesai','listKodeKolom','jumlahKodeKolom','kodeKolomBor','jumlahKaryawan'
        // ));
        Excel::create('Houling_Trip' , function($excel) use ($mulai,$akhir,$karyawan,$totalTrip,$nominalTrip,$totalNominalTrip,$listBulan,$tahunSekarang,$tahunAwal,$selesai,$kodeKolom,$listKodeKolom,$jumlahKodeKolom,$kodeKolomBor,$jumlahKaryawan){
            $excel->sheet('mySheet' , function($sheet) use ($mulai,$akhir,$karyawan,$totalTrip,$nominalTrip,$totalNominalTrip,$listBulan,$tahunSekarang,$tahunAwal,$selesai,$kodeKolom,$listKodeKolom,$jumlahKodeKolom,$kodeKolomBor,$jumlahKaryawan){
                $sheet->setWidth('A',4);
                $sheet->setWidth('B',35);
                for ($i=0; $i < $jumlahKodeKolom ; $i++) {
                    $sheet->setWidth($listKodeKolom[$i], 17);
                }
                $sheet->setWidth('AG', 17);
                // baris
                $sheet->setBorder('A6:'.$kodeKolomBor.$jumlahKaryawan, 'thin', "D8572C");
                $sheet->getStyle('A6:'.$kodeKolomBor.'6')->applyFromArray(array(
                    'fill' => array(
                        'type'  => \PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'BFBFBF')
                    )
                ));
                $sheet->getStyle('C7:'.$kodeKolom)->applyFromArray(array(
                    'fill' => array(
                        'type'  => \PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'D9D9D9')
                    )
                ));
                // $sheet->setAutoSize(false);
                $sheet->loadView('trip.export')->with('mulai',$mulai)
                                               ->with('akhir',$akhir)
                                               ->with('karyawan',$karyawan)
                                               ->with('tahunAwal',$tahunAwal)
                                               ->with('listBulan',$listBulan)
                                               ->with('totalTrip',$totalTrip)
                                               ->with('nominalTrip',$nominalTrip)
                                               ->with('totalNominalTrip',$totalNominalTrip)
                                               ->with('tahunSekarang',$tahunSekarang);
            });
        })->download('xlsx');
    }

    public function absen()
    {
        \DB::enableQueryLog();

        $kodeAbsen        = config('hrd.kode_absen_excel');
        $bulan            = request('bulan', date('n'));
        $tahun            = request('tahun', date('Y'));

        $mulai            = Carbon::now()->month($bulan)->year($tahun)->startOfMonth();
        // $selesai         = Carbon::now()->month($bulan)->year($tahun)->endOfMonth();
        $akhir            = $mulai->copy()->addMonth()->startOfMonth();
        $sekarang         = Carbon::now();

        $karyawan         = Karyawan::nama()->orderBy('updated_at','desc')->orderBy('created_at','desc')->get();
        $jmlAbsen         = $this->jmlAbsen($mulai,$akhir);
        $totalAbsen       = Absen::seluruhStatus($mulai,$akhir)->pluck('total','karyawan_id');
        $jumlahKaryawan   = count($karyawan)+7;


        // return view('absen.export',compact('mulai','akhir','kodeAbsen','karyawan','totalAbsen','jmlAbsen'));

        Excel::create('Absensi' , function($excel) use ($kodeAbsen,$karyawan,$totalAbsen,$jmlAbsen,$sekarang,$jumlahKaryawan){
            $excel->sheet('mySheet' , function($sheet) use ($kodeAbsen,$karyawan,$totalAbsen,$jmlAbsen,$sekarang,$jumlahKaryawan){

                $sheet->setWidth('O', 6);
                $sheet->setWidth('B',35);
                $sheet->setWidth(array(
                    'C'     =>  3,'D'     =>  3,'E'     =>  3,'F'     =>  3,
                    'G'     =>  3,'H'     =>  3,'I'     =>  3,'J'     =>  3,
                    'K'     =>  3,'L'     =>  3,'M'     =>  4,'N'     =>  3,
                ));
                $sheet->setBorder('A6:O'.$jumlahKaryawan, 'thin', "D8572C");
                $sheet->getStyle('A6:O6')->applyFromArray(array(
                    'fill' => array(
                        'type'  => \PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => '92D050')
                    )
                ));
                $sheet->getStyle('D7:E7')->applyFromArray(array(
                    'fill' => array(
                        'type'  => \PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'FCD5B4')
                    )
                ));
                $sheet->getStyle('F7:G7')->applyFromArray(array(
                    'fill' => array(
                        'type'  => \PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => '92D050')
                    )
                ));
                $sheet->getStyle('J7')->applyFromArray(array(
                    'fill' => array(
                        'type'  => \PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'FFFF00')
                    )
                ));
                $sheet->getStyle('K7')->applyFromArray(array(
                    'fill' => array(
                        'type'  => \PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'BFBFBF')
                    )
                ));
                $sheet->getStyle('L7')->applyFromArray(array(
                    'fill' => array(
                        'type'  => \PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => '00B0F0')
                    )
                ));
                $sheet->getStyle('M7')->applyFromArray(array(
                    'fill' => array(
                        'type'  => \PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => '963634')
                    )
                ));
                $sheet->getStyle('N7')->applyFromArray(array(
                    'fill' => array(
                        'type'  => \PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'FF0000')
                    )
                ));
                // $sheet->mergeCells('A2:A3');
                // $sheet->setAutoSize(true);
                // $sheet->set_column('A:A', 20) ;
                // $sheet->getStyle('A1:P2')->getAlignment()->setWrapText(true);
                $sheet->loadView('absen.export')->with('kodeAbsen',$kodeAbsen)
                                                ->with('karyawan',$karyawan)
                                                ->with('totalAbsen',$totalAbsen)
                                                ->with('jmlAbsen',$jmlAbsen)
                                                ->with('sekarang',$sekarang);
            });
        })->download('xlsx');
    }

    public function jmlAbsen($mulai,$akhir)
    {
        $jumlah_H   = Absen::seluruhStatus($mulai,$akhir)->where('status','H')->pluck('total','karyawan_id') ;
        $jumlah_IR  = Absen::seluruhStatus($mulai,$akhir)->where('status','IR')->pluck('total','karyawan_id') ;
        $jumlah_I   = Absen::seluruhStatus($mulai,$akhir)->where('status','I')->pluck('total','karyawan_id') ;
        $jumlah_S   = Absen::seluruhStatus($mulai,$akhir)->where('status','S')->pluck('total','karyawan_id') ;
        $jumlah_S1  = Absen::seluruhStatus($mulai,$akhir)->where('status','S')->pluck('total','karyawan_id') ;
        $jumlah_A   = Absen::seluruhStatus($mulai,$akhir)->where('status','A')->pluck('total','karyawan_id') ;
        $jumlah_Mi  = Absen::seluruhStatus($mulai,$akhir)->where('status','Mi')->pluck('total','karyawan_id') ;
        $jumlah_CT  = Absen::seluruhStatus($mulai,$akhir)->where('status','CT')->pluck('total','karyawan_id') ;
        $jumlah_L   = Absen::seluruhStatus($mulai,$akhir)->where('status','L')->pluck('total','karyawan_id') ;
        $jumlah_M   = Absen::seluruhStatus($mulai,$akhir)->where('status','M')->pluck('total','karyawan_id') ;
        $jumlah_OFF = Absen::seluruhStatus($mulai,$akhir)->where('status','OFF')->pluck('total','karyawan_id') ;
        $jumlah_X   = Absen::seluruhStatus($mulai,$akhir)->where('status','X')->pluck('total','karyawan_id') ;

        $daftar = [
            $jumlah_H, $jumlah_IR,$jumlah_I,$jumlah_S,$jumlah_S1,$jumlah_A,$jumlah_Mi,$jumlah_CT,
            $jumlah_L,$jumlah_M,$jumlah_OFF,$jumlah_X
        ];

        return $daftar ;
    }
}
