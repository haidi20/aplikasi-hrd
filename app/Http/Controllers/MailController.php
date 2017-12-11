<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Mail;
use Snowfire\Beautymail\Beautymail;

use App\User;
use App\Models\Maill;
use App\rumus\Payrol;

class MailController extends Controller
{
    public function kirim()
    {
        $payrol                     = new Payrol;
        $jmlTotalThp                = $payrol->index();

        $data = [
            'pesan'     =>'Mohon di Upload Data Finger. Terima Kasih',
            'nominal'   =>'Sumary Gaji = Rp. '.number_format($jmlTotalThp,0,",",".").',00'
        ];
        // $userMail= User::where('username','admin')->value('email');
        $userMail = Maill::all();
        // $userMail = Maill::value('email');
        // return $userMail;

        $email = app()->make(Beautymail::class);
        $email->send('email.index',$data,function($kirim) use($userMail){
            foreach ($userMail as $index => $item) {
                $kirim->to($item->email, '');
            }
            // $kirim->to($userMail,'');
            $kirim->subject('test email');
        });

        // Mail::send('email.index', $data, function ($mail) use($userMail)
        // {
        //     $mail->to($userMail, 'haidi'); // alamat email tujuan
        //     $mail->subject('test email');
        // });
    }
}
