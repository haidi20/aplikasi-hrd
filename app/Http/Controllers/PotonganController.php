<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Potongan ;
use App\Models\Karyawan ;

class PotonganController extends Controller
{
    public function index()
    {
        $potongan   = Potongan::orderBy('updated_at','desc')->orderBy('created_at','desc')->paginate(10);
        session()->put('warna','payroll');
        session()->put('pilihan','');

        return view('potongan.index',compact('potongan','warna','pilihan'));
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
        $potonganFind = Potongan::find($id);

        if ($potonganFind) {
            session()->flashInput($potonganFind->toArray());
            $action = route('potongan.update',$id);
            $method = 'PUT';
        }else{
            $action = route('potongan.store');
            $method = 'POST';
        }

        $potongan   = Potongan::orderBy('updated_at','desc')->orderBy('created_at','desc')->paginate(10);
        $karyawan   = Karyawan::all();

        session()->put('warna','payroll');

        return view('potongan.form',compact('action','method','potongan','karyawan','warna','pilihan'));
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
            $potongan = Potongan::find($id);
        }else{
            $potongan = new Potongan ;
        }

        $this->validate(request(),[
            'karyawan'    => 'required',
            'kategori'    => 'required',
            'tanggal'     => 'required',
            'keterangan'  => 'required',
            'nominal'     => 'required|numeric',
        ]);

        $potongan->tanggal     = plain_date(request('tanggal'));
        $potongan->keterangan  = request('keterangan');
        $potongan->karyawan_id = request('karyawan');
        $potongan->kategori    = request('kategori');
        $potongan->nominal     = request('nominal');
        $potongan->save();

        return redirect()->route('potongan.index');
    }

    public function destroy($id)
    {
        $potongan = Potongan::find($id);
        $potongan->delete();

        return redirect()->back();
    }
}
