<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller ;

use App\Models\Site ;

class SiteController extends Controller
{
    public function index()
    {
        $site     = Site::orderBy('updated_at','desc')->orderBy('created_at','desc')->paginate(10) ;
        session()->put('warna','master');
        session()->put('pilihan','site');

        return view('master.site.index',compact('site','warna','pilihan'));
    }

    public function create()
    {
        return $this->form() ;
    }

    public function edit($id)
    {
        return $this->form($id) ;
    }

    public function form($id = null)
    {
        $siteFind   = Site::find($id);
        $site       = Site::orderBy('updated_at','desc')->orderBy('created_at','desc')->paginate(10) ;

        if ($siteFind) {
            session()->flashInput($siteFind->toArray()) ;
            $action = route('master::site.update', $id);
            $method= 'PUT' ;
        }else{
            $action = route('master::site.store');
            $method= 'POST' ;
        }

        $warna      = 'master' ;
        $pilihan    = 'site';

        return view('master.site.form',compact('action','method','site','warna','site'));
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
        $this->validate(request(),[
            'lokasi' => 'required',
            'kode'   => 'required'
        ]);

        if ($id) {
            $site = Site::find($id) ;
        }else{
            $site = new Site ;
        }

        $site->lokasi = request('lokasi');
        $site->kode   = request('kode');
        $site->save() ;

        return redirect()->route('master::site.index');
    }

    public function destroy($id)
    {
        $site = Site::find($id);
        $site->delete();

        return redirect()->back();
    }
}
