<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;

use App\Models\Keluarga;
use App\Models\Biodata;

class KeluargaController extends Controller
{
    public function index()
    {
        $id       = request('biodata_id');

        $keluarga = Keluarga::orderBy('updated_at','desc')->orderBy('created_at','desc')->where('biodata_id',$id)->get();
        $biodata  = Biodata::find($id);

        session()->put('pilihan','biodata');
        session()->put('warna','master');

        return view('master.keluarga.index',compact('keluarga','biodata','warna','pilihan'));
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
        $keluargaFind = Keluarga::find($id);

        if ($keluargaFind) {
            session()->flashInput($keluargaFind->toArray());
            $action       = route('master::keluarga.update',$id);
            $method       = 'PUT';
        }else{
            $action       = route('master::keluarga.store');
            $method       = 'POST';
        }

        $biodata_id       = request('biodata_id');

        $warna            = 'master';
        $pilihan          = 'keluarga';
        $biodata          = Biodata::find($biodata_id);
        $listPendidikan   = config('hrd.pendidikan');
        $keluarga         = Keluarga::orderBy('updated_at','desc')->orderBy('created_at','desc')->where('biodata_id',$biodata_id)->get();

        return view('master.keluarga.form',compact('action','method','keluarga','biodata','listPendidikan','biodata_id','warna','pilihan'));
    }

    public function store()
    {
        return $this->save();
    }

    public function update($id)
    {
        return $this->save($id);
    }

    public function save($id=null)
    {
        $this->validate(request(),[
            'hubungan_keluarga'   => 'required',
            'nama'                => 'required',
            'tanggal_lahir'       => 'required',
            'jenis_kelamin'       => 'required',
            'pendidikan'          => 'required',
            'pekerjaan'           => 'required',
        ]);

        if ($id) {
            $keluarga = Keluarga::find($id);
        }else{
            $keluarga = new Keluarga ;
        }

        $keluarga->biodata_id           = request('biodata_id');
        $keluarga->tanggal_lahir        = plain_date(request('tanggal_lahir'));
        $keluarga->pendidikan_terakhir  = request('pendidikan');
        $keluarga->jenis_kelamin        = request('jenis_kelamin');
        $keluarga->pekerjaan            = request('pekerjaan');
        $keluarga->jenis                = request('hubungan_keluarga');
        $keluarga->nama                 = request('nama');
        $keluarga->save();

        return redirect()->route('master::keluarga.index',['biodata_id' => $keluarga->biodata_id]);
    }

    public function destroy($id)
    {
        $keluarga = Keluarga::find($id);
        $keluarga->delete();

        return redirect()->back();
    }
}
