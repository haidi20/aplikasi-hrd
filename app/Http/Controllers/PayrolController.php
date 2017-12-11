<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
use Session;
use Excel;
use DB;

use App\Models\Pengaturan;
use App\Models\Departemen;
use App\Models\Setabsen;
use App\Models\Karyawan;
use App\Models\Potongan;
use App\Models\Tambahan;
use App\Models\Jabatan;
use App\Models\Hauling;
use App\Models\Absen;
use App\Models\Trip;
use App\Models\Hour;

class PayrolController extends Controller
{
    public function karyawan()
    {
        return Karyawan::namaFind()
                       ->kodeFind()
                       ->jabatanFind()
                       ->departemenFind()
                       ->orderBy('updated_at','desc')
                       ->orderBy('created_at','desc');
    }

    public function hauling($mulai)
    {
        return hauling::groupBy('karyawan_id')
                      ->whereMonth('tanggal' , $mulai->format('m'))
                      ->whereyear('tanggal' , $mulai->format('Y'))
                      ->orderBy('updated_at','desc')
                      ->orderBy('created_at','desc') ;
    }

    public function hour($mulai)
    {
        return Hour::groupBy('karyawan_id')
                   ->whereMonth('tanggal' , $mulai->format('m'))
                   ->whereyear('tanggal' , $mulai->format('Y'))
                   ->where('total_des','!=',null)
                   ->where('total_des','!=',0);
    }

    public function index()
    {
        if(request('potongan')) {
            return redirect()->route('potongan.index');
        }elseif(request('tambahan')) {
            return redirect()->route('tambahan.index');
        }

        $listBulan            = config('hrd.bulan');
        $bulan                = request('bulan',date('n'));
        $tahun                = request('tahun',date('Y'));
        $mulai                = Carbon::now()->month($bulan)->year($tahun)->startOfMonth();
        $akhir                = Carbon::now()->month($bulan)->Year($tahun)->endOfMonth();
        $selesai              = $mulai->copy()->addMonth()->startOfMonth();
        $tahunSekarang        = Carbon::now();
        $tahunAwal            = Carbon::now()->subYear(18);
        // $akhir = $mulai->copy()->addMonth()->startOfMonth();

        if (request('rekap')) {
            $karyawan = $this->karyawan()->get();
        }else{
            $karyawan = $this->karyawan()->paginate(10);
        }

        $karyawanAll_A        = $this->karyawan()->get();
        $karyawanAll_B        = Karyawan::all();
        $kodeAll              = Karyawan::groupBy('kode')->get();
        $jabatanAll           = Jabatan::all();
        $departemenAll        = Departemen::all();
        $perKaryawan          = Karyawan::select('id','biodata_id')->nama()->get();
        $kodeAbsen            = config('hrd.kode_absen');

        //absen
        $jmlAbsen             = $this->jmlAbsen($mulai,$akhir);
        $jmlAbsenHadir        = $this->jmlAbsenHadir($mulai,$akhir);
        $jmlAbsenX            = $this->jmlAbsenX($mulai,$akhir);
        $jmlAbsenM            = $this->jmlAbsenM($mulai,$akhir);
        $jmlAbsenL            = $this->jmlAbsenL($mulai,$akhir);
        $totalAbsen           = Absen::seluruhStatus($mulai,$akhir)->pluck('total','karyawan_id');
        $totalPotonganAbsen   = [];
        //trip
        $hauling              = $this->hauling($mulai)->paginate(10);
        // $totalTrip            = Hauling::TotalTrip()->kondisi($mulai,$akhir);
        //meter
        $hour                 = $this->hour($mulai)->paginate(10);
        $HM                   = Hour::HM()->kondisi($mulai,$akhir);
        // $nominalHM            = Hour::nominalHM()->kondisi($mulai,$akhir);
        //hide pph21
        if(request()->has('hide-pph21')){
            session()->put('hidePPH21', request('hide-pph21') === 'true');
        }
        $hidePPH21 = session('hidePPH21', false);

        //rapel / lain-lain
        $rapel                = [];
        //pendapatan tidak tetap
        $totalUangMakanM      = [];
        $totalUangMakanL      = [];
        $totalUangMakanH      = [];
        $totalUangMakan       = [];
        $totalSaHarian        = [];
        // potongan
        $totalKasbon          = [];
        $totalPotonganIjin    = [];
        $totalLain_lain       = [];

        $totalPendapatan      = [];
        $totalPotongan        = [];

        $pph21                = [];
        $proposional          = [];
        // array trip
        $totalTrip            = [];
        $jmlTrip              = [];
        $nominalTrip          = [];
        $totalNominalTrip     = [];

        $thp                  = [];
        $gapok                = [];
        $satuPersen           = [];
        $tigaPersen           = [];

        $ar_HM                = [];
        $nominalHM            = [];
        $ar_Trip              = [];
        $jam                  = [];
        $meter                = [];
        $totalHargaa          = [];

        foreach ($hour as $index => $item) {
          $peng_batasJam    = Pengaturan::where('id',$item->karyawan->pengaturan_id)->value('jam_alat');
          $peng_alatBiasa   = Pengaturan::where('id',$item->karyawan->pengaturan_id)->value('alat_biasa');
          $peng_alatSpesial = Pengaturan::where('id',$item->karyawan->pengaturan_id)->value('alat_spesial');
          if (array_get($HM,$item->karyawan_id) < $peng_batasJam) {
              $nominalHM[$item->karyawan_id]                         = array_get($HM,$item->karyawan_id) * $peng_alatBiasa;
          }
          if (array_get($HM,$item->karyawan_id) >= $peng_batasJam) {
              $nominalHM[$item->karyawan_id]                         = array_get($HM,$item->karyawan_id) * $peng_alatSpesial;
          }
        }

        foreach ($hauling as $index => $item){
            for ($date = $mulai->copy(); $date->diffInDays($selesai); $date->addDay()) {
                $totalTrip[$date->format('Y-m-d')] = Hauling::select('karyawan_id',DB::raw("SUM(trip) as 'total'"))
                                                            ->where('tanggal',$date->format('Y-m-d'))
                                                            ->groupBy('karyawan_id')
                                                            ->pluck('total','karyawan_id');

                $biasa                          = Pengaturan::where('id',$item->karyawan->pengaturan_id)->value('biasa');
                $lumayan                        = Pengaturan::where('id',$item->karyawan->pengaturan_id)->value('lumayan');
                $bonusTrip                      = Pengaturan::where('id',$item->karyawan->pengaturan_id)->value('bonus');

                if (array_get($totalTrip[$date->format('Y-m-d')],$item->karyawan->id) == 0 ) {
                    $nominalTrip[$date->format('Y-m-d')][$item->karyawan->id] = 0;
                }
                if (array_get($totalTrip[$date->format('Y-m-d')],$item->karyawan->id) >= 1 && array_get($totalTrip[$date->format('Y-m-d')],$item->karyawan->id) <= 4) {
                    $nominalTrip[$date->format('Y-m-d')][$item->karyawan->id] =array_get($totalTrip[$date->format('Y-m-d')],$item->karyawan->id) * $biasa ;
                }
                if (array_get($totalTrip[$date->format('Y-m-d')],$item->karyawan->id) >= 5) {
                    $nominalTrip[$date->format('Y-m-d')][$item->karyawan->id] =array_get($totalTrip[$date->format('Y-m-d')],$item->karyawan->id) * $lumayan ;
                }
                if (array_get($totalTrip[$date->format('Y-m-d')],$item->karyawan->id) >= 120) {
                    $nominalTrip[$date->format('Y-m-d')][$item->karyawan->id] =array_get($totalTrip[$date->format('Y-m-d')],$item->karyawan->id) + $bonusTrip ;
                }
                $jmlTrip[$item->karyawan->id]           = array_sum(array_pluck($totalTrip,$item->karyawan->id)) ;
            }
            $totalNominalTrip[$item->karyawan->id]  = array_sum(array_pluck($nominalTrip,$item->karyawan->id));
        }

        foreach ($karyawan as $index => $item) {
            $pengaturan                     = Pengaturan::where('id',$item->pengaturan_id)->get();
            $potongan                       = Potongan::where('karyawan_id',$item->id)->get();
            $setAbsen                       = Setabsen::where('id',$item->setabsen_id)->get();
            $tambahan                       = Tambahan::where('karyawan_id',$item->id)->get();
            $absen                          = Absen::where('karyawan_id',$item->id)->get();
            if ($pengaturan && $potongan && $setAbsen && $tambahan && $absen) {
                //bonus trip
                $peng_pph21                     = Pengaturan::orderBy('id','desc')->where('id',$item->pengaturan_id)->value('pph21');

                //pendapatan tidak tetap
                $totalUangMakanM[$item->id]     = ($item->uang_makan * 2) * array_get($jmlAbsenM,$item->id);
                $totalUangMakanL[$item->id]     = ($item->uang_makan * 2) * array_get($jmlAbsenL,$item->id);
                $totalUangMakanH[$item->id]     = $item->uang_makan * array_get($jmlAbsenHadir,$item->id);
                $totalUangMakan[$item->id]      = $totalUangMakanH[$item->id] + $totalUangMakanL[$item->id] + $totalUangMakanM[$item->id]  ;

                $totalSaHarian[$item->id]       = $item->sa_harian * array_get($jmlAbsenHadir,$item->id);

                //potongan
                $tigaPersen[$item->id]          = $item->gapok * (3/100) ;
                $satuPersen[$item->id]          = $item->gapok * (1/100) ;
                $totalKasbon[$item->id]         = Potongan::where('karyawan_id',$item->id)
                                                          ->whereYear('tanggal',$mulai->format('Y'))
                                                          ->whereMonth('tanggal',$mulai->format('m'))
                                                          ->kasbon()->kondisi()->value('total');
                $totalLain_lain[$item->id]      = Potongan::where('karyawan_id',$item->id)
                                                          ->whereYear('tanggal',$mulai->format('Y'))
                                                          ->whereMonth('tanggal',$mulai->format('m'))
                                                          ->lain()->kondisi()->value('total');

                //absen
                $totalNominaIr[$item->id]       = array_get($this->nominalIr($mulai,$akhir),$item->id) * Setabsen::value('ir');
                $totalNominalI[$item->id]       = array_get($this->nominalI($mulai,$akhir),$item->id) * Setabsen::value('i');
                $totalNominalS[$item->id]       = array_get($this->nominalS($mulai,$akhir),$item->id) * Setabsen::value('s');
                $totalNominalS1[$item->id]      = array_get($this->nominalS1($mulai,$akhir),$item->id) * Setabsen::value('s1');
                $totalNominalA[$item->id]       = array_get($this->nominalA($mulai,$akhir),$item->id) * Setabsen::value('a');
                $totalNominalMi[$item->id]      = array_get($this->nominalA($mulai,$akhir),$item->id) * Setabsen::value('mi');
                $totalNominalCt[$item->id]      = array_get($this->nominalA($mulai,$akhir),$item->id) * Setabsen::value('ct');
                $totalNominalOff[$item->id]     = array_get($this->nominalOff($mulai,$akhir),$item->id) * Setabsen::value('off');

                $totalPotonganAbsen[$item->id]  = $totalNominaIr[$item->id]+$totalNominalI[$item->id]+$totalNominalS[$item->id]+
                                                  $totalNominalS1[$item->id]+$totalNominalA[$item->id]+$totalNominalMi[$item->id]+
                                                  $totalNominalCt[$item->id]+$totalNominalOff[$item->id];
                $totalPotonganIjin[$item->id]   = $totalNominaIr[$item->id]+$totalNominalI[$item->id];

                //rapel / lain-lain
                $rapel[$item->id]               = Tambahan::kondisi()->whereYear('tanggal',$mulai->format('Y'))
                                                                     ->whereMonth('tanggal',$mulai->format('m'))
                                                                     ->where('karyawan_id',$item->id)
                                                                     ->value('total');

                //gaji proposional
                $proposional[$item->id]         = ($item->gapok / 25) * (25 - array_get($jmlAbsenX,$item->id));

                //total pendapatan
                $totalPendapatan[$item->id]     = $totalSaHarian[$item->id]+$totalUangMakan[$item->id]+
                                                  array_get($nominalTrip,$item->id)+array_get($nominalHM,$item->id)+
                                                  $rapel[$item->id]+$proposional[$item->id];

                // hm dan hour
                $ar_HM[$item->id]               = array_get($nominalHM,$item->id);
                $ar_Trip[$item->id]             = array_get($nominalTrip,$item->id);

                //potongan pph21
                if(session('hidePPH21')){
                    $pph21[$item->id]           = 0;
                    // return 'hide true' ;
                }else{
                    if ($item->gapok >= $peng_pph21) {
                        $pph21[$item->id]       = $totalPendapatan[$item->id] * 0.05;
                    }else{
                        $pph21[$item->id]       = 0;
                    }
                    // return 'hide false';
                }

                //total potongan
                $totalPotongan[$item->id]       = $tigaPersen[$item->id]+$satuPersen[$item->id]+$totalPotonganAbsen[$item->id]+
                                                  $totalKasbon[$item->id]+$totalPotonganIjin[$item->id]+$totalLain_lain[$item->id]+
                                                  $pph21[$item->id];

                $thp[$item->id]                 = $totalPendapatan[$item->id]-$totalPotongan[$item->id];
                $gapok[$item->id]               = $item->gapok;

                $biasa                          = Pengaturan::where('id',$item->pengaturan_id)->value('biasa');
                $lumayan                        = Pengaturan::where('id',$item->pengaturan_id)->value('lumayan');
                $bonus                          = Pengaturan::where('id',$item->pengaturan_id)->value('bonus');
                $alpa                           = Setabsen::where('id',$item->setabsen_id)->value('a');
                $listPengaturan[$item->id]      = 'Hauling Trip = Rp.'. number_format($biasa,2).' '.
                                                     'Rp.'. number_format($lumayan,2).' Rp.'. number_format($bonus,2);
                $listAlpa[$item->id]            = 'Nominal Alpa = Rp.'. number_format($alpa,2) ;
            }
        }
        // total jml keseluruhan
        $jmlTotalThp                        = $thp?array_sum($thp):0;
        $jmlTotalPotongan                   = array_sum($totalPotongan);
        $jmlTotalPph21                      = array_sum($pph21);
        $jmlTotalLain_lain                  = array_sum($totalLain_lain);
        $jmlTotalIjin                       = array_sum($totalPotonganIjin);
        $jmlTotalKasbon                     = array_sum($totalKasbon);
        $jmlTotalAbsen                      = array_sum($totalPotonganAbsen);
        $jmlTotalSatuPersen                 = array_sum($satuPersen);
        $jmlTotalTigaPersen                 = array_sum($tigaPersen);
        $jmlTotalPendapatan                 = array_sum($totalPendapatan);
        $jmlTotalRapel                      = array_sum($rapel);
        $jmlTotalNominalHM                  = array_sum($ar_HM == ''?0:$ar_HM);
        $jmlTotalNominalTrip                = array_sum($ar_Trip == ''?0:$ar_Trip);
        $jmlTotalUangMakan                  = array_sum($totalUangMakan);
        $jmlTotalSaHarian                   = array_sum($totalSaHarian);
        $jmlTotalProposional                = array_sum($proposional);
        $jmlTotalGapok                      = array_sum($gapok);

        session()->put('warna','payroll');
        session()->put('pilihan','');

        // untuk export
        $jumlahKaryawan                     = count($karyawan) + 8;

        if (!request('rekap')) {
            return view('payrol.index',compact(
                'karyawan','kodeAbsen','mulai','akhir','listBulan','jmlAbsen','totalAbsen',
                'totalTrip','bonusTrip','nominalTrip','HM','nominalHM', 'totalUangMakan','totalSaHarian',
                'totalKasbon','totalLain_lain','tigaPersen','satuPersen','tahunSekarang',
                'tahunAwal','rapel','totalPendapatan','totalPotonganAbsen','totalPotonganIjin','pph21','totalPotongan',
                'thp','proposional','hidePPH21','karyawanAll_B','kodeAll','jabatanAll','departemenAll','jmlTotalThp','jmlTotalPotongan',
                'jmlTotalPph21','jmlTotalLain_lain','jmlTotalIjin','jmlTotalKasbon','jmlTotalAbsen','jmlTotalSatuPersen','jmlTotalTigaPersen',
                'jmlTotalPendapatan','jmlTotalRapel','jmlTotalNominalHM','jmlTotalNominalTrip','jmlTotalUangMakan','jmlTotalSaHarian',
                'jmlTotalProposional','jmlTotalGapok','warna','pilihan','totalNominalTrip','jmlTrip'
            ));
        }else{
            $view = [
              'karyawan','kodeAbsen','mulai','akhir','listBulan','jmlAbsen','totalAbsen',
              'totalTrip','bonusTrip','nominalTrip','HM','nominalHM', 'totalUangMakan','totalSaHarian',
              'totalKasbon','totalLain_lain','tigaPersen','satuPersen','tahunSekarang',
              'tahunAwal','rapel','totalPendapatan','totalPotonganAbsen','totalPotonganIjin','pph21','totalPotongan',
              'thp','proposional','hidePPH21','karyawanAll_A','kodeAll','jabatanAll','departemenAll','jmlTotalThp','jmlTotalPotongan',
              'jmlTotalPph21','jmlTotalLain_lain','jmlTotalIjin','jmlTotalKasbon','jmlTotalAbsen','jmlTotalSatuPersen','jmlTotalTigaPersen',
              'jmlTotalPendapatan','jmlTotalRapel','jmlTotalNominalHM','jmlTotalNominalTrip','jmlTotalUangMakan','jmlTotalSaHarian',
              'jmlTotalProposional','jmlTotalGapok'
            ];
            $variable = [
              $karyawan,$kodeAbsen,$mulai,$akhir,$listBulan,$jmlAbsen,$totalAbsen,
              $totalTrip,$bonusTrip,$nominalTrip,$HM,$nominalHM, $totalUangMakan,$totalSaHarian,
              $totalKasbon,$totalLain_lain,$tigaPersen,$satuPersen,$tahunSekarang,
              $tahunAwal,$rapel,$totalPendapatan,$totalPotonganAbsen,$totalPotonganIjin,$pph21,$totalPotongan,
              $thp,$proposional,$hidePPH21,$karyawanAll_A,$kodeAll,$jabatanAll,$departemenAll,$jmlTotalThp,$jmlTotalPotongan,
              $jmlTotalPph21,$jmlTotalLain_lain,$jmlTotalIjin,$jmlTotalKasbon,$jmlTotalAbsen,$jmlTotalSatuPersen,$jmlTotalTigaPersen,
              $jmlTotalPendapatan,$jmlTotalRapel,$jmlTotalNominalHM,$jmlTotalNominalTrip,$jmlTotalUangMakan,$jmlTotalSaHarian,
              $jmlTotalProposional,$jmlTotalGapok
            ];

            // return count($variable);

            Excel::create('Payroll' , function($excel) use ($view,$variable,$jumlahKaryawan){
                $excel->sheet('mySheet' , function($sheet) use ($view,$variable,$jumlahKaryawan){
                    $sheet->mergeCells('A6:A7');$sheet->mergeCells('B6:B7');$sheet->mergeCells('C6:C7');
                    $sheet->mergeCells('D6:D7');$sheet->mergeCells('E6:E7');$sheet->mergeCells('F6:F7');
                    $sheet->mergeCells('G6:G7');$sheet->mergeCells('H6:H7');$sheet->mergeCells('I6:I7');
                    $sheet->mergeCells('J6:V6');$sheet->mergeCells('W6:Z6');$sheet->mergeCells('AA6:AE6');
                    $sheet->mergeCells('AF6:AF7');$sheet->mergeCells('AG6:AG7');$sheet->mergeCells('AH6:AN6');
                    $sheet->mergeCells('AO6:AO7');$sheet->mergeCells('AP6:AP7');
                    $sheet->setWidth('A',4);$sheet->setWidth('B',24);$sheet->setWidth('D',40);
                    $sheet->setWidth('E',4);$sheet->setWidth('F',21);$sheet->setWidth('G',18);
                    $sheet->setWidth('H',18);$sheet->setWidth('I',18);$sheet->setWidth('J',5);
                    $sheet->setWidth('K',5);$sheet->setWidth('L',5);$sheet->setWidth('M',5);
                    $sheet->setWidth('N',5);$sheet->setWidth('O',5);$sheet->setWidth('P',5);
                    $sheet->setWidth('Q',5);$sheet->setWidth('R',5);$sheet->setWidth('S',5);
                    $sheet->setWidth('T',5);$sheet->setWidth('U',5);$sheet->setWidth('V',5);
                    $sheet->setWidth('W',18);$sheet->setWidth('X',18);$sheet->setWidth('Y',18);
                    $sheet->setWidth('Z',18);
                    $sheet->setWidth('AA',10);$sheet->setWidth('AB',18);$sheet->setWidth('AC',18);
                    $sheet->setWidth('AD',18);$sheet->setWidth('AE',18);$sheet->setWidth('AF',19);
                    $sheet->setWidth('AG',18);$sheet->setWidth('AH',18);$sheet->setWidth('AI',18);
                    $sheet->setWidth('AJ',18);$sheet->setWidth('AK',18);$sheet->setWidth('AL',18);
                    $sheet->setWidth('AM',18);$sheet->setWidth('AN',18);$sheet->setWidth('AO',18);
                    $sheet->setWidth('AP',18);
                    $sheet->setBorder('A6:AP'.$jumlahKaryawan, 'thin', "D8572C");
                    $sheet->getStyle('A6:V7')->applyFromArray(array(
                        'fill' => array(
                            'type'  => \PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => '00B050')
                        )
                    ));
                    $sheet->getStyle('W6:AA6')->applyFromArray(array(
                        'fill' => array(
                            'type'  => \PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => '92CDDC')
                        )
                    ));
                    $sheet->getStyle('W7:AE7')->applyFromArray(array(
                        'fill' => array(
                            'type'  => \PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => '92CDDC')
                        )
                    ));
                    $sheet->getStyle('AF6:AP6')->applyFromArray(array(
                        'fill' => array(
                            'type'  => \PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => '00B050')
                        )
                    ));
                    $sheet->getStyle('AH7:AN7')->applyFromArray(array(
                        'fill' => array(
                            'type'  => \PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => '00B050')
                        )
                    ));
                    for ($i=0; $i <=49 ; $i++) {
                        $sheet->loadView('payrol.export')->with($view[$i],$variable[$i]);
                    }
                });
            })->download('xlsx');
        }
    }

    public function jmlTotalThp($jmlTotalThp)
    {
        $varJmlTotalThp = $jmlTotalThp ;
        return $varJmlTotalThp ;
    }

    public function nominalCt($mulai,$akhir)
    {
        return $jumlah_Ct  = Absen::seluruhStatus($mulai,$akhir)->where('status','CT')->pluck('total','karyawan_id') ;
    }

    public function nominalMi($mulai,$akhir)
    {
        return $jumlah_Mi  = Absen::seluruhStatus($mulai,$akhir)->where('status','Mi')->pluck('total','karyawan_id') ;
    }

    public function nominalA($mulai,$akhir)
    {
        return $jumlah_A  = Absen::seluruhStatus($mulai,$akhir)->where('status','A')->pluck('total','karyawan_id') ;
    }

    public function nominalS1($mulai,$akhir)
    {
        return $jumlah_S1  = Absen::seluruhStatus($mulai,$akhir)->where('status','S1')->pluck('total','karyawan_id') ;
    }

    public function nominalS($mulai,$akhir)
    {
        return $jumlah_S  = Absen::seluruhStatus($mulai,$akhir)->where('status','S')->pluck('total','karyawan_id') ;
    }

    public function nominalIr($mulai,$akhir)
    {
        return $jumlah_IR  = Absen::seluruhStatus($mulai,$akhir)->where('status','IR')->pluck('total','karyawan_id') ;
    }

    public function nominalI($mulai,$akhir)
    {
        return $jumlah_I   = Absen::seluruhStatus($mulai,$akhir)->where('status','I')->pluck('total','karyawan_id') ;
    }

    public function nominalOff($mulai,$akhir)
    {
        return $jumlah_OFF = Absen::seluruhStatus($mulai,$akhir)->where('status','OFF')->pluck('total','karyawan_id') ;
    }

    public function jmlAbsenM($mulai,$akhir)
    {
        return Absen::seluruhStatus($mulai,$akhir)->where('status','M')->pluck('total','karyawan_id') ;
    }

    public function jmlAbsenL($mulai,$akhir)
    {
        return Absen::seluruhStatus($mulai,$akhir)->where('status','L')->pluck('total','karyawan_id') ;
    }

    public function jmlAbsenX($mulai,$akhir)
    {
        return $jumlah_H   = Absen::seluruhStatus($mulai,$akhir)->where('status','X')->pluck('total','karyawan_id') ;
    }

    public function jmlAbsenHadir($mulai,$akhir)
    {
        return $jumlah_H   = Absen::seluruhStatus($mulai,$akhir)->where('status','H')->pluck('total','karyawan_id') ;
    }

    public function potonganAbsen($mulai,$akhir)
    {
        return $jumlah_H   = Absen::seluruhStatus($mulai,$akhir)->where('status','H')->pluck('total','karyawan_id') ;
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
        $jumlah_L   = Absen::seluruhStatus($mulai,$akhir)->where('status','L')->pluck('totall','karyawan_id') ;
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
