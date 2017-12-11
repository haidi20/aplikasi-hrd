<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Maill ;

class SetMailController extends Controller
{
    public function index(){
        $mail = Maill::paginate(10);

        session()->put('pilihan','setemail');
        session()->put('warna','');

        return view('mail.index',compact('mail'));
    }

    public function create(){
        return $this->form();
    }

    public function edit($id){
        return $this->form($id);
    }

    public function form($id = null){
        $emailFind = Maill::find($id);

        if ($emailFind) {
            session()->flashInput($emailFind->toArray());
            $action = route('setemail.update',$id);
            $method = 'PUT';
        }else{
            $action = route('setemail.store');
            $method = 'POST';
        }

        $mail       = Maill::paginate(10);
        return view('mail.form' , compact('action','method','mail'));
    }

    public function store(){
        return $this->save();
    }

    public function update($id){
        return $this->save($id);
    }

    public function save($id = null){
        if ($id) {
            $mail = Maill::find($id);
        }else{
            $mail = new Maill;
        }

        $this->validate(request(),[
            'email' => 'required'
        ]);

        $mail->email = request('email');
        $mail->save();

        return redirect()->route('setemail.index');
    }

    public function destroy($id){
        $mail = Maill::find($id);
        $mail->delete();

        return redirect()->back();
    }
}
