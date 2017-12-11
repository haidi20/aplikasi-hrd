<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;

use Carbon\Carbon ;

use App\Models\Biodata;

class BiodataController extends Controller
{
    public function biodata()
    {
        session()->put('warna','master');
        session()->put('pilihan','biodata');

        return Biodata::findNama()->orderBy('created_at','asc')->orderBy('created_at','desc') ;
    }

    public function index()
    {
        $biodata    = $this->biodata()->paginate(10);
        $biodataAll = Biodata::all();

        $mulai      = Carbon::now()->year(1990);
        $akhir      = Carbon::now();

        $warna      = 'master';
        $pilihan    = 'biodata';

        return view('master.biodata.index', compact('biodata','biodataAll','mulai','akhir','warna','pilihan'));
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
        $biodata      = $this->biodata()->paginate(10);
        $biodataFind  = Biodata::find($id);

        $mulai        = Carbon::now()->year(1990);
        $akhir        = Carbon::now()->addYear();

        if ($biodataFind) {
            // session()->flashInput($biodataFind->toArray());
            session()->flash('_old_input', array_merge($biodataFind->toArray(), old()));
            $action = route('master::biodata.update',$id);
            $method = 'PUT';
        }else{
            $action = route('master::biodata.store');
            $method = 'POST';
        }

        $warna = 'master';
        $pilihan = 'biodata';
        $listAgama = config('hrd.agama');
        $listPendidikan = config('hrd.pendidikan');

        return view('master.biodata.form', compact(
            'action','method','listAgama','listPendidikan','biodata',
            'mulai','akhir','warna','pilihan'
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
        $this->validate(request(), [
            'nama_panggilan'        => 'required',
            'nama_lengkap'          => 'required',
            'tempat_lahir'          => 'required',
            'tanggal_lahir'         => 'required',
            'status'                => 'required',
            'pendidikan'            => 'required',
            'alamat'                => 'required',
            'agama'                 => 'required',
            'ktp'                   => 'required',
            'akhir_ktp'             => 'required',
            'kewarganegaraan'       => 'required',
            'warganegara'           => 'required',
            'nama_depan'            => 'required',
            'nama_belakang'         => 'required',
            'rt'                    => 'required',
            'rw'                    => 'required',
            'kecamatan'             => 'required',
            'kelurahan'             => 'required',
            'kota'                  => 'required',
            'status_rumah'          => 'required',
            // 'pendidikan_terakhir'   => 'required',
            'instansi_pendidikan'   => 'required',
            'jurusan'               => 'required',
            'tahun_masuk'           => 'required',
            'tahun_kelulusan'       => 'required',
            'nilai_akhir'           => 'required',
        ]);

        if ($id) {
            $biodata = Biodata::find($id);
        }else{
            $biodata = new Biodata;
        }

        $tahunMasuk     = Carbon::now()->year(request('tahun_masuk'));
        $tahunKelulusan = Carbon::now()->year(request('tahun_kelulusan'));
        // return $tahunMasuk->format('Y-m-d');

        $biodata->nama_panggilan        = request('nama_panggilan');
        $biodata->nama_lengkap          = request('nama_lengkap');
        $biodata->tempat_lahir          = request('tempat_lahir');
        $biodata->tanggal_lahir         = plain_date(request('tanggal_lahir'));
        $biodata->status                = request('status');
        $biodata->pendidikan            = request('pendidikan');
        $biodata->alamat                = request('alamat');
        $biodata->agama                 = request('agama');
        $biodata->ktp                   = request('ktp');
        $biodata->akhir_ktp             = plain_date(request('akhir_ktp'));
        $biodata->kewarganegaraan       = request('kewarganegaraan');
        $biodata->warganegara           = request('warganegara');
        $biodata->nama_depan            = request('nama_depan');
        $biodata->nama_belakang         = request('nama_belakang');
        $biodata->rt                    = request('rt');
        $biodata->rw                    = request('rw');
        $biodata->kecamatan             = request('kecamatan');
        $biodata->kelurahan             = request('kelurahan');
        $biodata->kota                  = request('kota');
        $biodata->status_rumah          = request('status_rumah');
        // $biodata->pendidikan_terakhir   = request('pendidikan_terakhir');
        $biodata->instansi_pendidikan   = request('instansi_pendidikan');
        $biodata->jurusan               = request('jurusan');
        $biodata->tahun_masuk           = $tahunMasuk ;
        $biodata->tahun_kelulusan       = $tahunKelulusan ;
        $biodata->nilai_akhir           = request('nilai_akhir');
        $biodata->save();

        return redirect()->route('master::biodata.index');
    }

    public function destroy($id)
    {
        $biodata = Biodata::find($id);
        $biodata->delete();

        return redirect()->back();
    }
}
