<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Pengaturan ;

class PengaturanController extends Controller
{
    public function index()
    {
        session()->put('pilihan','pengaturan');
        session()->put('warna','');

        $pengaturan = Pengaturan::orderBy('updated_at','desc')->orderBy('created_at','desc')->paginate(10);

        return view('pengaturan.index',compact('pengaturan')) ;
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
        $settingFind = Pengaturan::find($id);

        if ($settingFind){
            session()->flashInput($settingFind->toArray());
            $action = route('pengaturan.update',$id);
            $method = 'PUT';
        }else{
            $action = route('pengaturan.store');
            $method = 'POST';
        }

        session()->put('pilihan','pengaturan');

        $pengaturan = Pengaturan::orderBy('updated_at','desc')->orderBy('created_at','desc')->paginate(10);

        return view('pengaturan.form',compact('pengaturan','action','method'));
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
            $pengaturan = Pengaturan::find($id);
        }else{
            $pengaturan = new Pengaturan ;
        }

        $this->validate(request(),[
            'anggaran_trip_1_-_4'             => 'required|numeric',
            'anggaran_trip_5_dan_seterusnya'  => 'required|numeric',
            'Bonus_Anggaran'                  => 'required|numeric',
            'pph21'                           => 'required|numeric',
            'alat_biasa'                      => 'required|numeric',
            'alat_spesial'                    => 'required|numeric',
            'jam_alat'                        => 'required:numberic',
            // 'sa_harian'                       => 'required|numeric',
        ]);

        $pengaturan->biasa        = request('anggaran_trip_1_-_4');
        $pengaturan->lumayan      = request('anggaran_trip_5_dan_seterusnya');
        $pengaturan->bonus        = request('Bonus_Anggaran');
        $pengaturan->pph21        = request('pph21');
        $pengaturan->alat_biasa   = request('alat_biasa');
        $pengaturan->alat_spesial = request('alat_spesial');
        $pengaturan->jam_alat     = request('jam_alat');
        // $pengaturan->sa_harian    = request('sa_harian');
        $pengaturan->save();

        return redirect()->route('pengaturan.index');
    }
}
