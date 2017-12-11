<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Setabsen ;

class SetabsenController extends Controller
{
    public function index()
    {
        $setAbsen = Setabsen::orderBy('updated_at','desc')->orderBy('created_at','desc')->paginate(10);
        session()->put('pilihan','setabsen');
        session()->put('warna','');

        return view('setabsen.index',compact('setAbsen','pilihan','warna')) ;
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
        $setAbsenFind   = Setabsen::find($id);

        if ($setAbsenFind) {
            session()->flashInput($setAbsenFind->toArray());
            $action = route('setabsen.update',$id);
            $method = 'PUT';
        }else{
            $action = route('setabsen.store');
            $method = 'POST';
        }

        $setAbsen   = Setabsen::orderBy('updated_at','desc')->orderBy('created_at','desc')->paginate(10);
        session()->put('pilihan','setabsen');

        return view('setabsen.form',compact('setAbsen','action','method','warna','pilihan'));
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
        if ($id) {
            $setAbsen = Setabsen::find($id);
        }else{
            $setAbsen = new Setabsen ;
        }

        $this->validate(request(),[
            'tanggal'             => 'required',
            'ijin_resmi'          => 'required',
            'ijin_tidak_resmi'    => 'required',
            'sakit_surat_dokter'  => 'required',
            'sakit_tanpa_surat'   => 'required',
            'alpha'               => 'required',
            'baru/keluar'         => 'required',
            'setengah_hari'       => 'required',
            'cuti'                => 'required',
            'libur_nasional'      => 'required',
            'minggu'              => 'required',
            'off'                 => 'required',
            'lembur'              => 'required',
        ]);

        $setAbsen->tanggal    = plain_date(request('tanggal'));
        $setAbsen->ir         = request('ijin_resmi');
        $setAbsen->i          = request('ijin_tidak_resmi');
        $setAbsen->s          = request('sakit_surat_dokter');
        $setAbsen->s1         = request('sakit_tanpa_surat');
        $setAbsen->a          = request('alpha');
        $setAbsen->x          = request('baru/keluar');
        $setAbsen->mi         = request('setengah_hari');
        $setAbsen->ct         = request('cuti');
        $setAbsen->l          = request('libur_nasional');
        $setAbsen->m          = request('minggu');
        $setAbsen->off        = request('off');
        $setAbsen->lembur     = request('lembur');
        $setAbsen->save();

        return redirect()->route('setabsen.index');
    }

    public function destroy($id)
    {
        $setAbsen = Setabsen::find($id);
        $setAbsen->delete();

        return redirect()->back();
    }
}
