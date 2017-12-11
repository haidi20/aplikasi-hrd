<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Jabatan ;

class JabatanController extends Controller
{
    public function index()
    {
        $jabatan = Jabatan::orderBy('updated_at','desc')->orderBy('created_at','desc')->paginate(10);
        session()->put('pilihan','jabatan');
        session()->put('warna','master');

        return view('master.jabatan.index', compact('jabatan','warna','pilihan'));
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
        $jabatanFind = Jabatan::find($id);

        if ($jabatanFind) {
            session()->flashInput($jabatanFind->toArray());
            $action = route('master::jabatan.update',$id);
            $method = 'PUT';
        }else{
            $action = route('master::jabatan.store');
            $method = 'POST' ;
        }

        $warna = 'master' ;
        $pilihan = 'jabatan';
        $jabatan = Jabatan::orderBy('updated_at','desc')->orderBy('created_at','desc')->paginate(10);

        return view('master.jabatan.form',compact('jabatan','action','method','warna','pilihan'));
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
        $this->validate(request(),[
            'kode' => 'required',
            'nama' => 'required',
        ]);

        if($id) {
            $jabatan = Jabatan::find($id);
        }else{
            $jabatan = new Jabatan;
        }

        $jabatan->kode = request('kode');
        $jabatan->nama = request('nama');
        $jabatan->save();

        return redirect()->route('master::jabatan.index');
    }

    public function destroy($id)
    {
      $jabatan = Jabatan::find($id);
      $jabatan->delete();

      return redirect()->back();
    }
}
