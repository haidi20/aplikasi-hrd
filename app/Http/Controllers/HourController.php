<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Carbon\Carbon;

use App\Models\Pengaturan;
use App\Models\Departemen;
use App\Models\Karyawan;
use App\Models\Biodata;
use App\Models\Hour;
use App\Models\Alat;

class HourController extends Controller
{
    public function hour()
    {
        return Hour::departemen()->orderBy('tanggal','desc');
    }

    public function index()
    {
        $hour         = $this->hour()->paginate(10);
        $departemen   = Departemen::all();
        session()->put('warna','hour');
        session()->put('pilihan','');

        return view('hour.index',compact('hour','warna','pilihan','departemen'));
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
        $hourFind     = Hour::find($id);

        if ($hourFind){
            session()->flashInput($hourFind->toArray());
            $action   = route('hour.update',$id);
            $method   = 'PUT';
        }else{
            $action   = route('hour.store');
            $method   = 'POST';
        }

        $karyawan     = Karyawan::orderBy('updated_at','desc')->orderBy('created_at','desc')->get();
        $alat         = Alat::where('kategori','rental')->get();
        $hour         = $this->hour()->paginate(10);
        $departemen   = Departemen::all();
        session()->put('warna','hour');

        return view('hour.form',compact(
            'karyawan', 'alat', 'action', 'hour' ,'method','total','warna','pilihan','departemen'
        ));
    }

    public function store()
    {
        return $this->save() ;
    }

    public function update($id)
    {
        return $this->save($id) ;
    }

    public function save($id = null)
    {
        if ($id) {
            $hour = Hour::find($id);
        }else{
            $hour = new Hour ;
        }

        $this->validate(request(),[
            'tanggal'       => 'required',
            'shift'         => 'required',
            'unit'          => 'required',
            'karyawan'      => 'required',
            'mulai'         => 'required',
            'selesai'       => 'required',
            'mulai_des'     => 'required',
            'selesai_des'   => 'required',
            'total_des'     => 'required',
            // 'nik'         => 'required',
        ]);

        $unit               = request('unit');

        $tanggal            = plain_date(request('tanggal'));
        $mulai              = Carbon::now()->parse(request('mulai'));
        $selesai            = Carbon::now()->parse(request('selesai'));

        $karyawan           = Karyawan::find(request('karyawan'))->first();
        $pengaturan         = Pengaturan::where('id',$karyawan->pengaturan_id)->first();
        $total[$tanggal]    = $mulai->diffInHours($selesai);
        $tableAlat          = Alat::all() ;

        foreach ($tableAlat as $index => $item) {
            if ($unit == $item->id && $item->status == 'Ya' ) {
                $totalHarga = $total[$tanggal] * $pengaturan->alat_spesial ;
            }
            if ($unit == $item->id && $item->status == 'Tidak' ) {
                $totalHarga = $total[$tanggal] * $pengaturan->alat_biasa ;
            }
        }

        $hour->tanggal      = $tanggal;
        $hour->shift        = request('shift');
        $hour->alat_id      = $unit;
        $hour->mulai        = $mulai;
        $hour->selesai      = $selesai;
        $hour->total        = $total[$tanggal];
        $hour->mulai_des    = request('mulai_des');
        $hour->selesai_des  = request('selesai_des');
        $hour->total_des    = request('total_des');
        $hour->total_harga  = $totalHarga ;
        $hour->karyawan_id  = request('karyawan');
        $hour->save() ;

        return redirect()->route('hour.index');
    }

    public function destroy($id)
    {
        $hour = Hour::find($id);
        $hour->delete();
        return redirect()->back();
    }
}
