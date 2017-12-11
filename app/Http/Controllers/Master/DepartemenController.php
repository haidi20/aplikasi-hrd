<?php
namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;

use App\Models\Departemen;

class DepartemenController extends Controller
{
    public function index()
    {
        $departemen = Departemen::orderBy('updated_at','desc')->orderBy('created_at','desc')->paginate(10);
        session()->put('pilihan','departemen');
        session()->put('warna','master');

        return view('master.departemen.index', compact('departemen'));
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
        $departemenFind = Departemen::find($id);

        if ($departemenFind) {
            session()->flashInput($departemenFind->toArray());
            $action  = route('master::departemen.update',$id);
            $method = 'PUT';
        }else{
            $action  = route('master::departemen.store');
            $method = 'POST';
        }

        $warna      = 'master';
        $pilihan    = 'departemen';
        $departemen = Departemen::orderBy('updated_at','desc')->orderBy('created_at','desc')->paginate(10);

        return view('master.departemen.form',compact('departemen','action','method','warna','pilihan'));
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
            'kode' => 'required',
            'nama' => 'required'
        ]);

        if($id){
            $departemen = Departemen::find($id);
        }else{
            $departemen = new Departemen;
        }

        $departemen->kode = request('kode');
        $departemen->nama = request('nama');
        $departemen->save();

        return redirect()->route('master::departemen.index');
    }

    public function destroy($id)
    {
        $departemen = Departemen::find($id);
        $departemen->delete();

        return redirect()->back();
    }
}
