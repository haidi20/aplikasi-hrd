<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Carbon\Carbon;
use DB;

use App\Models\Pengaturan;
use App\Models\Departemen;
use App\Models\Karyawan;
use App\Models\Hauling;
use App\Models\Waktu;
use App\Models\Trip;
use App\Models\Alat;

class HaulingController extends Controller
{
    public function hauling()
    {
        return Hauling::departemenFind()->orderBy('tanggal','desc');
    }

    public function index()
    {
        $hauling      = $this->hauling()->paginate(10);
        $departemen   = Departemen::all();

        session()->put('warna','hauling');
        session()->put('pilihan','');

        $totalJam     = [];
        $totalTonase  = [];
        $total        = [];

        foreach ($hauling as $index => $item) {
            $totalJam[$item->id]    = Waktu::select(DB::raw("count('jam') as total"))
                                           ->where('hauling_id',$item->id)
                                           ->value('total');
            $totalTonase[$item->id] = Waktu::where('hauling_id',$item->id)
                                           ->sum('tonase');
            $total[$item->id]       = $totalTonase[$item->id] == ''?0:$totalTonase[$item->id] * $item->jarak ;
        }

        return view('hauling.index', compact(
            'hauling','total','warna','pilihan','departemen','totalJam','totalTonase'
        ));
    }

    public function create()
    {
        return $this->form() ;
    }

    public function edit($id)
    {
        return $this->form($id);
    }

    public function form($id = null)
    {
        $hauling = Hauling::find($id);

        if ($hauling) {
            session()->flashInput($hauling->toArray()) ;
            $action = route('hauling.update',$id);
            $method = 'PUT';
        }else{
            $action = route('hauling.store');
            $method = 'POST';
        }

        $alat       = Alat::where('kategori','hauling')->get() ;
        $hauling    = $this->hauling()->paginate(10);
        $karyawan   = Karyawan::all();
        session()->put('warna','hauling');
        session()->put('pilihan','');

        $totalJam     = [];
        $totalTonase  = [];
        $total        = [];

        foreach ($hauling as $index => $item) {
            $totalJam[$item->id]    = Waktu::select(DB::raw("count('jam') as total"))
                                           ->where('hauling_id',$item->id)
                                           ->value('total');
            $totalTonase[$item->id] = Waktu::where('hauling_id',$item->id)
                                           ->sum('tonase');
            $total[$item->id]       = $totalTonase[$item->id] == ''?0:$totalTonase[$item->id] * $item->jarak ;
        }

        return view('hauling.form',compact(
            'action','method','karyawan','hauling','total','alat','warna','pilihan',
            'totalJam','totalTonase'
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
            $hauling = Hauling::find($id);
        }else{
            $hauling = new Hauling ;
        }

        $this->validate(request(),[
            'karyawan'        => 'required',
            'tanggal'         => 'required',
            'unit'            => 'required',
            'tipe'            => 'required',
            'seam'            => 'required',
            'trip'            => 'required',
            'pembayaran'      => 'required|numeric',
            'jarak'           => 'required',
            'shift'           => 'required',
        ]);

        $karyawan             = Karyawan::find(request('karyawan'))->first();
        $pengaturan           = Pengaturan::where('id',$karyawan->pengaturan_id)->first();
        $trip                 = request('trip');

        if (($trip >=1) && $trip <=4) {
            $total            = $trip * $pengaturan->biasa ;
        }elseif ($trip >=5) {
            $total            = $trip * $pengaturan->lumayan ;
        }elseif($trip == 120){
            $total            = $trip + $pengaturan->bonus ;
        }

        $hauling->karyawan_id = request('karyawan');
        $hauling->tanggal     = plain_date(request('tanggal'));
        $hauling->alat_id     = request('unit');
        $hauling->tipe        = request('tipe');
        $hauling->seam        = request('seam');
        $hauling->trip        = $trip ;
        $hauling->total       = $total ;
        $hauling->jarak       = request('jarak');
        $hauling->shift       = request('shift');
        $hauling->pembayaran  = request('pembayaran');
        $hauling->save() ;

        return redirect()->route('hauling.index');
    }

    public function destroy($id)
    {
        $hauling = Hauling::find($id);
        $hauling->delete();

        return redirect()->back() ;
    }
}
