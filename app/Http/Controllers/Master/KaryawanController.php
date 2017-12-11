<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon ;
use Carbon\CarbonInterval ;

use App\Models\Departemen;
use App\Models\Pengaturan;
use App\Models\Setabsen;
use App\Models\Karyawan;
use App\Models\Jabatan;
use App\Models\Biodata;
use App\Models\Trip ;
use App\Models\Site ;

class KaryawanController extends Controller
{
    public function karyawan()
    {
        return Karyawan::siteFind()
                        ->departemenFind()
                        ->jabatanFind()
                        ->namaFind()
                        ->nikFind()
                        // ->orderBy('updated_at','asc')
                        ->orderBy('created_at','asc');
    }

    public function index()
    {
        $karyawan     = $this->karyawan()->paginate(10);

        $departemen   = Departemen::all();
        $pengaturan   = Pengaturan::all();
        $karyawanAll  = Karyawan::all();
        $jabatan      = Jabatan::all();
        $site         = Site::all();

        session()->put('pilihan','karyawan');
        session()->put('warna','master');

        return view('master.karyawan.index',compact(
            'karyawan','karyawanAll','site','warna','pilihan',
            'departemen','jabatan'
        ));
    }

    public function create()
    {
        return $this->form();
    }

    public function edit($id)
    {
        return $this->form($id);
    }

    public function form($id = null)
    {
        $karyawanFind = Karyawan::find($id);

        if ($karyawanFind) {
            // session()->flashInput($karyawanFind->toArray());
            session()->flash('_old_input', array_merge($karyawanFind->toArray(), old()));
            $action   = route('master::karyawan.update',$id);
            $method   = 'PUT';
        }else{
            $action   = route('master::karyawan.store');
            $method   = 'POST';
        }

        $karyawan     = Karyawan::siteFind()->orderBy('updated_at','desc')->orderBy('created_at','desc')->paginate(10);
        $pengaturan   = Pengaturan::all();
        $departemen   = Departemen::all();
        $setAbsen     = setAbsen::all();
        $biodata      = Biodata::all();
        $jabatan      = Jabatan::all();
        $site         = Site::all();
        $warna        = 'master';
        $pilihan      = 'karyawan';

        return view('master.karyawan.form',compact(
            'action','method','biodata','departemen','jabatan','karyawan','site',
            'pengaturan','setAbsen','listKaryawan','warna','pilihan'
        ));
    }

    public function store()
    {
        return $this->save();
    }

    public function update($id)
    {
        return $this->save($id);
    }

    public function save($id = null)
    {
        if ($id) {
            $karyawan = Karyawan::find($id);
        }else{
            $karyawan = new Karyawan ;
        }
        if(request('status_kerja') != 'Tetap'){
            $required = 'required';
        }else{
            $required = '';
        }

        $this->validate(request(),[
            'biodata_id'        => 'required',
            'departemen_id'     => 'required',
            'jabatan_id'        => 'required',
            'golongan'          => 'required',
            'status'            => 'required',
            'gapok'             => 'required|numeric',
            'uang_makan'        => 'required|numeric',
            'tunjangan'         => 'required|numeric',
            'tanggal_masuk'     => 'required',
            'tanggal_keluar'    =>  $required,
            'kode'              => 'required',
            'nrp'               => 'required',
            'nik'               => 'required',
            'site_id'           => 'required',
            'npwp'              => 'required|numeric',
            'jamsostek'         => 'required|numeric',
            'rekening'          => 'required|numeric',
            'bpjs'              => 'required|numeric',
            'jenis_bank'        => 'required',
            'status_pernikahan' => 'required',
            // 'sim_a'             => 'required',
            // 'sim_b'             => 'required',
            // 'sim_b2'            => 'required',
            // 'sim_c'             => 'required',
            'fiskal'            => 'required',
            'nama_atasan'       => 'required',
            'divisi'            => 'required',
            'cara_bayar'        => 'required',
            'cabang_bank'       => 'required',
            'status_kerja'      => 'required',
            'sa_harian'         => 'required',
            'jenis_kerja'       => 'required',
            'pengaturan_id'  => 'required',
            'bpjs_tk' => 'required',
            'bpjs_kes'    => 'required',
            'setabsen_id' => 'required',
            'foto'              => $karyawan->foto ? '' : 'required|mimes:jpeg,jpg,png',
        ]);

        $tanggal_masuk  = Carbon::parse(plain_date(request('tanggal_masuk')));
        $tanggal_keluar = Carbon::parse(plain_date(request('tanggal_keluar')));
        if (request('status_kerja') != 'Tetap') {
            $masa_kerja     = $this->masaKerja($tanggal_masuk, $tanggal_keluar);
        }else{
            $masa_kerja     = '';
        }

        $karyawan->biodata_id         = request('biodata_id');
        $karyawan->departemen_id      = request('departemen_id');
        $karyawan->jabatan_id         = request('jabatan_id');
        // $karyawan->pengaturan_id      = Pengaturan::orderBy('id','desc')->pluck('id')->first() ;
        $karyawan->pengaturan_id      = request('pengaturan_id');
        $karyawan->site_id            = request('site_id') ;
        $karyawan->setabsen_id        = request('setabsen_id');
        $karyawan->status_kerja       = request('status_kerja');
        $karyawan->jenis_kerja        = request('jenis_kerja');
        $karyawan->golongan           = request('golongan');
        $karyawan->status             = request('status');
        $karyawan->gapok              = request('gapok');
        $karyawan->uang_makan         = request('uang_makan');
        $karyawan->tunjangan          = request('tunjangan');
        $karyawan->tanggal_masuk      = $tanggal_masuk ;
        if (request('status_kerja')  != 'Tetap'){
            $karyawan->tanggal_keluar = $tanggal_keluar;
        }else{
            $karyawan->tanggal_keluar = '';
        }
        $karyawan->kode               = request('kode');
        $karyawan->nrp                = request('nrp');
        $karyawan->nik                = request('nik');
        $karyawan->npwp               = request('npwp');
        $karyawan->jamsostek          = request('jamsostek');
        $karyawan->rekening           = request('rekening');
        $karyawan->bpjs               = request('bpjs');
        $karyawan->jenis_bank         = request('jenis_bank');
        $karyawan->status_pernikahan  = request('status_pernikahan');
        $karyawan->sim_a              = request('sim_a');
        $karyawan->sim_b              = request('sim_b');
        $karyawan->sim_b2             = request('sim_b2');
        $karyawan->sim_c              = request('sim_c');
        $karyawan->simper             = request('simper');
        $karyawan->fiskal             = request('fiskal');
        $karyawan->masa_kerja         = $masa_kerja ;
        $karyawan->nama_atasan        = request('nama_atasan');
        $karyawan->divisi             = request('divisi');
        $karyawan->cara_bayar         = request('cara_bayar');
        $karyawan->cabang_bank        = request('cabang_bank');
        $karyawan->sa_harian          = request('sa_harian');
        $karyawan->bpjs_tk            = request('bpjs_tk');
        $karyawan->bpjs_kes           = request('bpjs_kes');

        if(request()->hasFile('foto')){
            @unlink(public_path('storages/' . $karyawan->foto));

            $file           = request()->file('foto');
            $extension      = $file->getClientOriginalExtension();
            $fileName       = str_random(8) . '.' . $extension;
            request()->file('foto')->move("storages/", $fileName);
            $karyawan->foto = $fileName;
        }

        $karyawan->save();

        return redirect()->route('master::karyawan.index');
    }

    public function destroy($id)
    {
        $karyawan = Karyawan::find($id);
        $karyawan->delete();

        return redirect()->back();
    }

    public function masaKerja($tanggal_masuk, $tanggal_keluar)
    {
        $tanggal_masukY   = Carbon::parse($tanggal_masuk)->format('Y');
        $tanggal_masukm   = Carbon::parse($tanggal_masuk)->format('m');
        $tanggal_masukd   = Carbon::parse($tanggal_masuk)->format('d');
        $tanggal_keluar   = Carbon::parse($tanggal_keluar) ;

        return Carbon::createFromDate($tanggal_masukY, $tanggal_masukm, $tanggal_masukd)
              ->diff($tanggal_keluar)
              ->format('%y Tahun, %m Bulan and %d Hari');
    }
}
