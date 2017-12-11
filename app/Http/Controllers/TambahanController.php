<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Tambahan;
use App\Models\Karyawan;

class TambahanController extends Controller
{
    public function index()
    {
        $tambahan = Tambahan::orderBy('updated_at','desc')->orderBy('created_at','desc')->paginate(10);
        session()->put('warna','payroll');
        session()->put('pilihan','');

        return view('tambahan.index',compact('tambahan','warna','pilihan')) ;
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
        $tambahanFind = Tambahan::find($id);

        if ($tambahanFind) {
            session()->flashInput($tambahanFind->toArray());
            $action = route('tambahan.update',$id);
            $method = 'PUT';
        }else{
            $action = route('tambahan.store');
            $method = 'POST';
        }

        $tambahan   = Tambahan::orderBy('updated_at','desc')->orderBy('created_at','desc')->paginate(10);
        $karyawan   = Karyawan::all();
        session()->put('warna','payroll');

      return view('tambahan.form',compact('tambahan','action','method','karyawan','warna','pilihan'));
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
            $tambahan = Tambahan::find($id);
        }else{
            $tambahan = new Tambahan ;
        }

        $this->validate(request(),[
            'karyawan'  => 'required',
            'tanggal'   => 'required',
            'kategori'  => 'required',
            'keterangan'=> 'required',
            'nominal'   => 'required',
        ]);

        $tambahan->tanggal      = plain_date(request('tanggal'));
        $tambahan->keterangan   = request('keterangan');
        $tambahan->karyawan_id  = request('karyawan');
        $tambahan->kategori     = request('kategori');
        $tambahan->nominal      = request('nominal');
        $tambahan->save();

        return redirect()->route('tambahan.index');
    }

    public function destroy($id)
    {
        $tambahan = Tambahan::find($id);
        $tambahan->delete();

        return redirect()->back() ;
    }
}
