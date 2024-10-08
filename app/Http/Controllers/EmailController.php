<?php

namespace App\Http\Controllers;

use App\Mail\ConfirmacionNewsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function sendMail()
    {
        //Mail::to('sebass7@live.com')->send(new ConfirmacionNewsletter($data));

        return 'Correo enviado exitosamente!';
    }
}
