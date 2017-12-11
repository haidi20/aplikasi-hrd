<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
use Terbilang;
use Excel;
use DB ;

use App\Models\Pengaturan;
use App\Models\Karyawan;
use App\Models\Potongan;
use App\Models\Setabsen;
use App\Models\Tambahan;
use App\Models\Hauling;
use App\Models\Absen;
use App\Models\Hour;

class SlipController extends Controller
{
    public function index()
    {
        if (request('karyawan')) {
            $idKaryawan   = request('karyawan');
        }else{
            $idKaryawan   = Karyawan::pluck('id')->first();
        }
        if (!$idKaryawan) {
            return view('errors.505');
        }

        if (request()->has('hide-pph21')) {
            session()->put('hidePPH21', request('hide-pph21') === 'true');
        }
        $hidePPH21 = session('hidePPH21',false);
        // request
        $bulan            = request('bulan',date('n'));
        $tahun            = request('tahun',date('Y'));
        // bulan
        $listBulan        = config('hrd.bulan');
        $mulai            = Carbon::now()->month($bulan)->year($tahun)->startOfMonth();
        $selesai          = Carbon::now()->month($bulan)->year($tahun)->endOfMonth();
        $akhir            = $mulai->copy()->addMonth()->startOfMonth();
        // tahun
        $tahunSekarang    = Carbon::now();
        $tahunAwal        = Carbon::now()->subYear(18);
        // sekarang
        $sekarang         = Carbon::now();
        // karyawan
        $karyawanAll      = Karyawan::all();
        $karyawan         = Karyawan::where('id',$idKaryawan)->first();
        // absen
        $keteranganAbsenA = config('hrd.keterangan_absenA');
        $listAbsen        = Absen::listAbsen($mulai,$akhir,$idKaryawan);
        $jumlahAbsen      = $this->jumlahAbsen($mulai,$akhir,$idKaryawan);
        $jumlahH          = $this->jmlAbsenHadir($mulai,$akhir,$idKaryawan);
        $jumlahX          = $this->jmlAbsenX($mulai,$akhir,$idKaryawan);
        // hour meter
        $listHM           = Hour::kondisiSlip($mulai,$akhir,$idKaryawan)->pluck('total','tanggal');
        $listNominalHM    = Hour::kondisiSlip($mulai,$akhir,$idKaryawan)->pluck('total_harga','tanggal');
        $HM               = Hour::HM()->kondisi($mulai,$akhir,$idKaryawan);
        $nominalHM        = Hour::nominalHM()->kondisi($mulai,$akhir,$idKaryawan);
        // hauling trip
        $listTrip         = Hauling::kondisiSlip($mulai,$akhir,$idKaryawan)->pluck('trip','tanggal');
        $listNominalTrip  = Hauling::kondisiSlip($mulai,$akhir,$idKaryawan)->pluck('total','tanggal');
        $nominalTrip      = Hauling::NominalTrip()->kondisi($mulai,$akhir,$idKaryawan);
        $trip             = Hauling::totalTrip()->kondisi($mulai,$akhir,$idKaryawan);
        //pengaturan
        $peng_pph21       = Pengaturan::orderBy('id','desc')->where('id',$karyawan->pengaturan_id)->value('pph21');
        // pendapatan tidak tetap
        $uangMakan        = $karyawan->uang_makan * $jumlahH;
        $saHarian         = $karyawan->sa_harian * $jumlahH;
        $rapel            = Tambahan::kondisi()->where('karyawan_id',$karyawan->id)->value('total');
        $proposional      = ($karyawan->gapok / 25) * (25 - array_get($jumlahX,$karyawan->id));
        $totalPendapatan  = $saHarian+$uangMakan+$rapel+
                            array_get($nominalTrip,$karyawan->id)+array_get($nominalHM,$karyawan->id)+
                            $proposional;
        // potongan pph21
        if (session('hidePPH21')) {
            $pph21        = 0;
        }else{
            if ($karyawan->gapok >= $peng_pph21) {
                $pph21          = $totalPendapatan * 0.05 ;
            }else{
                $pph21          = 0;
            }
        }
        // potongan
        $tigaPersen         = $karyawan->gapok * (3/100) ;
        $satuPersen         = $karyawan->gapok * (1/100) ;
        $totalLain_lain     = Potongan::lain()->kondisi()->where('karyawan_id',$karyawan->id)->value('total');
        $totalKasbon        = Potongan::kasbon()->kondisi()->where('karyawan_id',$karyawan->id)->value('total');
        // potongan absen
        $totalNominalIr     = $this->nominalIr($mulai,$akhir,$idKaryawan) * Setabsen::value('ir');
        $totalNominalI      = $this->nominalI($mulai,$akhir,$idKaryawan) * Setabsen::value('i');
        $totalNominalS      = $this->nominalS($mulai,$akhir,$idKaryawan) * Setabsen::value('s');
        $totalNominalS1     = $this->nominalS1($mulai,$akhir,$idKaryawan) * Setabsen::value('s1');
        $totalNominalA      = $this->nominalA($mulai,$akhir,$idKaryawan) * Setabsen::value('a');
        $totalNominalMi     = $this->nominalA($mulai,$akhir,$idKaryawan) * Setabsen::value('mi');
        $totalNominalCt     = $this->nominalA($mulai,$akhir,$idKaryawan) * Setabsen::value('ct');
        $totalNominalOff    = $this->nominalOff($mulai,$akhir,$idKaryawan) * Setabsen::value('off');

        $totalPotonganAbsen = $totalNominalIr+$totalNominalI+$totalNominalS+
                              $totalNominalS1+$totalNominalA+$totalNominalMi+
                              $totalNominalCt+$totalNominalOff;
        $totalpotonganIjin  = $totalNominalIr+$totalNominalI;

        $totalPotongan      = $tigaPersen+$satuPersen+$totalPotonganAbsen+$totalKasbon+$totalNominalI+
                              $totalLain_lain+$pph21;

        $upahBersih         = $totalPendapatan-$totalPotongan;
        $terbilang          = Terbilang::make($upahBersih, ' rupiah');

        session()->put('warna','slip');
        session()->put('pilihan','');

        if (!request('rekap')) {
            return view('slip.index',compact(
                'mulai','akhir','selesai','listBulan','karyawanAll','karyawan','listAbsen','idKaryawan',
                'listHM','listNominalHM','listTrip','listNominalTrip','keteranganAbsenA','jumlahAbsen',
                'trip','nominalTrip','HM','nominalHM','totalLain_lain','tahunSekarang','tahunAwal',
                'totalPotonganAbsen','totalNominalI','pph21','totalPotongan','totalPendapatan','upahBersih',
                'terbilang','sekarang','hidePPH21','warna','pilihan'
            ));
        }else{
            $view = [
                'mulai','akhir','selesai','listBulan','karyawanAll','karyawan','listAbsen','idKaryawan',
                'listHM','listNominalHM','listTrip','listNominalTrip','keteranganAbsenA','jumlahAbsen',
                'trip','nominalTrip','HM','nominalHM','totalLain_lain','tahunSekarang','tahunAwal',
                'totalPotonganAbsen','totalNominalI','pph21','totalPotongan','totalPendapatan','upahBersih',
                'terbilang','sekarang'
            ];
            $variable = [
                $mulai,$akhir,$selesai,$listBulan,$karyawanAll,$karyawan,$listAbsen,$idKaryawan,
                $listHM,$listNominalHM,$listTrip,$listNominalTrip,$keteranganAbsenA,$jumlahAbsen,
                $trip,$nominalTrip,$HM,$nominalHM,$totalLain_lain,$tahunSekarang,$tahunAwal,
                $totalPotonganAbsen,$totalNominalI,$pph21,$totalPotongan,$totalPendapatan,$upahBersih,
                $terbilang,$sekarang
            ];
            // return view('slip.export',compact(
            //     'mulai','akhir','selesai','listBulan','karyawanAll','karyawan','listAbsen','idKaryawan',
            //     'listHM','listNominalHM','listTrip','listNominalTrip','keteranganAbsenA','jumlahAbsen',
            //     'trip','nominalTrip','HM','nominalHM','totalLain_lain','tahunSekarang','tahunAwal',
            //     'totalPotonganAbsen','totalNominalI','pph21','totalPotongan','totalPendapatan','upahBersih',
            //     'terbilang','sekarang'
            // ));
            Excel::create('Slip' , function($excel) use ($view,$variable){
                $excel->sheet('mySheet' , function($sheet) use ($view,$variable){
                    // $sheet->setAutoSize(true);
                    $sheet->mergeCells('A5:A6');$sheet->mergeCells('B5:B6');$sheet->mergeCells('C5:C6');
                    $sheet->mergeCells('D5:D6');$sheet->mergeCells('E5:F5');$sheet->mergeCells('G5:H5');
                    $sheet->setWidth('A',5);$sheet->setWidth('B',12);
                    $sheet->setWidth('F',15);$sheet->setWidth('H',15);
                    for ($i=0; $i <=28 ; $i++) {
                        $sheet->loadView('slip.export')->with($view[$i],$variable[$i]);
                    }
                });
            })->download('xlsx');
        }
    }

    public function jmlAbsenHadir($mulai,$akhir,$idKaryawan)
    {
        return $jumlah_H   = Absen::status($mulai,$akhir,$idKaryawan)->where('status','H')->value('total') ;
    }

    public function nominalCt($mulai,$akhir,$idKaryawan)
    {
        return $jumlah_Ct  = Absen::status($mulai,$akhir,$idKaryawan)->where('status','CT')->value('total') ;
    }

    public function nominalMi($mulai,$akhir,$idKaryawan)
    {
        return $jumlah_Mi  = Absen::status($mulai,$akhir,$idKaryawan)->where('status','Mi')->value('total') ;
    }

    public function nominalA($mulai,$akhir,$idKaryawan)
    {
        return $jumlah_A  = Absen::status($mulai,$akhir,$idKaryawan)->where('status','A')->value('total') ;
    }

    public function nominalS1($mulai,$akhir,$idKaryawan)
    {
        return $jumlah_S1  = Absen::status($mulai,$akhir,$idKaryawan)->where('status','S1')->value('total') ;
    }

    public function nominalS($mulai,$akhir,$idKaryawan)
    {
        return $jumlah_S  = Absen::status($mulai,$akhir,$idKaryawan)->where('status','S')->value('total') ;
    }

    public function nominalIr($mulai,$akhir,$idKaryawan)
    {
        return $jumlah_IR  = Absen::status($mulai,$akhir,$idKaryawan)->where('status','IR')->value('total') ;
    }

    public function nominalI($mulai,$akhir,$idKaryawan)
    {
        return $jumlah_I   = Absen::status($mulai,$akhir,$idKaryawan)->where('status','I')->value('total') ;
    }

    public function nominalOff($mulai,$akhir,$idKaryawan)
    {
        return $jumlah_OFF = Absen::status($mulai,$akhir,$idKaryawan)->where('status','OFF')->value('total') ;
    }

    public function jmlAbsenX($mulai,$akhir,$idKaryawan)
    {
        return $jumlah_H   = Absen::status($mulai,$akhir,$idKaryawan)->where('status','X')->pluck('total','karyawan_id') ;
    }

    public function jumlahAbsen($mulai,$selesai,$idKaryawan)
    {
        $nomor = $idKaryawan ;
        // $selesai = $akhir ;

        $jumlah['H'] = Absen::JumlahStatus($mulai,$selesai,$nomor)->where('status','H')->pluck('status');
        $jumlah['Mi'] = Absen::JumlahStatus($mulai,$selesai,$nomor)->where('status','Mi')->pluck('status');
        $jumlah['IR'] = Absen::JumlahStatus($mulai,$selesai,$nomor)->where('status','IR')->pluck('status');
        $jumlah['CT'] = Absen::JumlahStatus($mulai,$selesai,$nomor)->where('status','CT')->pluck('status');
        $jumlah['I']= Absen::JumlahStatus($mulai,$selesai,$nomor)->where('status','I')->pluck('status');
        $jumlah['L']= Absen::JumlahStatus($mulai,$selesai,$nomor)->where('status','L')->pluck('status');
        $jumlah['S']= Absen::JumlahStatus($mulai,$selesai,$nomor)->where('status','S')->pluck('status');
        $jumlah['M'] = Absen::JumlahStatus($mulai,$selesai,$nomor)->where('status','M')->pluck('status');
        $jumlah['S1'] = Absen::JumlahStatus($mulai,$selesai,$nomor)->where('status','S1')->pluck('status');
        $jumlah['OFF'] = Absen::JumlahStatus($mulai,$selesai,$nomor)->where('status','OFF')->pluck('status');
        $jumlah['A']= Absen::JumlahStatus($mulai,$selesai,$nomor)->where('status','A')->pluck('status');
        $jumlah['X']= Absen::JumlahStatus($mulai,$selesai,$nomor)->where('status','X')->pluck('status');

        return $jumlah ;
    }
}
