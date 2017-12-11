<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Karyawan;
use App\Models\Hauling;
use App\Models\Waktu;

use Carbon\Carbon;

class WaktuController extends Controller
{
    public function kondisiHauling()
    {
        if (request('hauling_id')) {
            session()->put('hauling_id',request('hauling_id'));
        }
        return session()->get('hauling_id');
    }

    public function waktu()
    {
        $hauling_id = $this->kondisiHauling();

        return Waktu::where('hauling_id',session()
                    ->get('hauling_id'))
                    ->orderBy('jam')
                    ->paginate(10);
    }

    public function karyawan()
    {
        $hauling_id = $this->kondisiHauling();

        return Hauling::where('id',$hauling_id)->first();
    }

    public function index()
    {
        $waktu          = $this->waktu();
        $karyawan       = $this->karyawan();

        return view('waktu.index',compact('waktu','karyawan'));
    }

    public function create()
    {
        return $this->form();
    }

    public function edit($id)
    {
        return $this->form($id);
    }

    public function form($id=null)
    {
        $waktuFind = Waktu::find($id);

        if ($waktuFind) {
            session()->flashInput($waktuFind->toArray());
            $action = route('waktu-hauling.update',$id) ;
            $method = 'PUT';
        }else{
            $action = route('waktu-hauling.store');
            $method = 'POST';
        }

        $karyawan   = $this->karyawan();
        $waktu      = $this->waktu();

        return view('waktu.form',compact('waktu','action','method','karyawan'));
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
            'jam'         => 'required',
            'tonase'      => 'required|numeric',
        ]);

        if ($id) {
            $waktu  = Waktu::find($id);
        }else{
            $waktu  = new Waktu;
        }

        $waktu->hauling_id    = session()->get('hauling_id');
        $waktu->jam           = request('jam');
        $waktu->tonase        = request('tonase');
        $waktu->save();

        return redirect()->route('waktu-hauling.index',['hauling_id' => session()->get('hauling_id')]);
    }

    public function destroy($id)
    {
        $waktu = Waktu::find($id);
        $waktu->delete();

        return redirect()->back();
    }
}
