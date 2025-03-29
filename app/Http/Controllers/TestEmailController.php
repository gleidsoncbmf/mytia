<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;

class TestEmailController extends Controller
{
    public function sendTestEmail()
    {
        $email = 'gleidsoncbmf@gmail.com'; // Substitua pelo e-mail de teste
        
        // Enviar o e-mail de teste diretamente com um texto
        Mail::raw('Este é um e-mail de teste simples enviado sem o uso de Blade.', function ($message) use ($email) {
            $message->to($email)
                    ->subject('E-mail de Teste');
        });

        return response()->json(['message' => 'E-mail enviado com sucesso!']);
    }
}
