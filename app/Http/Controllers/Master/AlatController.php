<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller ;

use App\Models\Alat ;

class AlatController extends Controller
{
    public function index()
    {
        $alat       = Alat::orderBy('updated_at','desc')->orderBy('created_at','desc')->paginate(10);
        session()->put('warna','master');
        session()->put('pilihan','alat');

        return view('master.alat.index',compact('alat','warna','pilihan'));
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
        $alatFind = Alat::find($id);

        if ($alatFind) {
            session()->flashInput($alatFind->toArray());
            $action = route('master::alat.update',$id);
            $method = 'PUT';
        }else{
            $action = route('master::alat.store');
            $method = 'POST';
        }

        $warna      = 'master' ;
        $pilihan    = 'alat' ;
        $alat       = Alat::orderBy('updated_at','desc')->orderBy('created_at','desc')->paginate(10);

        return view('master.alat.form',compact('alat','warna','pilihan','action','method'));
    }

    public function store()
    {
        return $this->save() ;
    }

    public function update($id)
    {
       return $this->save($id);
    }

    public function save($id = null)
    {
        $this->validate(request(),[
            'nama'      => 'required',
            'kategori'  => 'required',
            'status'    => 'required',
        ]);

        if ($id) {
            $alat = Alat::find($id);
        }else{
            $alat = new Alat ;
        }

        $alat->nama     = request('nama');
        $alat->kategori = request('kategori');
        $alat->status   = request('status');
        $alat->save();

        return redirect()->route('master::alat.index');
    }

    public function destroy($id)
    {
        $alat = Alat::find($id);
        $alat->delete();

        return redirect()->back() ;
    }
}
