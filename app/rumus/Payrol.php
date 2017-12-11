<?php

namespace App\rumus;

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

class Payrol
{
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
        $mulai                = Carbon::now()->month($bulan)->Year($tahun)->startOfMonth();
        $akhir                = Carbon::now()->month($bulan)->Year($tahun)->endOfMonth();
        $tahunSekarang        = Carbon::now();
        $tahunAwal            = Carbon::now()->subYear(18);
        // $akhir = $mulai->copy()->addMonth()->startOfMonth();

        if (request('rekap')) {
            $karyawan         = Karyawan::namaFind()->kodeFind()->jabatanFind()->departemenFind()->orderBy('created_at','desc')->get();
        }else{
            $karyawan         = Karyawan::namaFind()->kodeFind()->jabatanFind()->departemenFind()->orderBy('created_at','desc')->paginate(10);
        }

        $karyawanAll          = Karyawan::all();
        $kodeAll              = Karyawan::groupBy('kode')->get();
        $jabatanAll           = Jabatan::all();
        $departemenAll        = Departemen::all();
        $perKaryawan          = Karyawan::select('id','biodata_id')->nama()->get();
        $kodeAbsen            = config('hrd.kode_absen');

        //absen
        $jmlAbsen             = $this->jmlAbsen($mulai,$akhir);
        $jmlAbsenHadir        = $this->jmlAbsenHadir($mulai,$akhir);
        $jmlAbsenX            = $this->jmlAbsenX($mulai,$akhir);
        $totalAbsen           = Absen::seluruhStatus($mulai,$akhir)->pluck('total','karyawan_id');
        $totalPotonganAbsen   = [];
        //trip
        $totalTrip            = Hauling::TotalTrip()->kondisi($mulai,$akhir);
        $nominalTrip          = Hauling::NominalTrip()->kondisi($mulai,$akhir);
        //meter
        $HM                   = Hour::HM()->kondisi($mulai,$akhir);
        $nominalHM            = Hour::nominalHM()->kondisi($mulai,$akhir);
        //rapel / lain-lain
        $rapel                = [];
        //pendapatan tidak tetap
        $totalUangMakan       = [];
        $totalSaHarian        = [];
        // potongan
        $totalKasbon          = [];
        $totalLain_lain       = [];

        $totalPendapatan      = [];
        $totalPotongan        = [];

        $pph21                = [];
        $proposional          = [];
        foreach ($karyawanAll as $index => $item) {
            //bonus trip
            $bonusTrip                      = Pengaturan::orderBy('id','desc')->where('id',$item->pengaturan_id)->value('bonus');
            $peng_pph21                     = Pengaturan::orderBy('id','desc')->where('id',$item->pengaturan_id)->value('pph21');

            //pendapatan tidak tetap
            $totalUangMakan[$item->id]      = $item->uang_makan * array_get($jmlAbsenHadir,$item->id);
            $totalSaHarian[$item->id]       = $item->sa_harian * array_get($jmlAbsenHadir,$item->id);

            //potongan
            $tigaPersen[$item->id]          = $item->gapok * (3/100) ;
            $satuPersen[$item->id]          = $item->gapok * (1/100) ;
            $totalKasbon[$item->id]         = Potongan::kasbon()->kondisi()->where('karyawan_id',$item->id)->value('total');
            $totalLain_lain[$item->id]      = Potongan::lain()->kondisi()->where('karyawan_id',$item->id)->value('total');

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
            $rapel[$item->id]               = Tambahan::kondisi()->where('karyawan_id',$item->id)->value('total');

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
            if ($item->gapok >= $peng_pph21) {
                $pph21[$item->id]           = $totalPendapatan[$item->id] * 0.05;
            }else{
                $pph21[$item->id]           = 0;
            }

            //total potongan
            $totalPotongan[$item->id]       = $tigaPersen[$item->id]+$satuPersen[$item->id]+$totalPotonganAbsen[$item->id]+
                                              $totalKasbon[$item->id]+$totalPotonganIjin[$item->id]+$totalLain_lain[$item->id]+
                                              $pph21[$item->id];

            $thp[$item->id]                 = $totalPendapatan[$item->id]-$totalPotongan[$item->id];
            $gapok[$item->id]               = $item->gapok;
        }
        // total jml keseluruhan
        return $jmlTotalThp                 = array_sum($thp);
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
