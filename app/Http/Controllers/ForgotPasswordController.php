<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetMail; // Novo Mailable para enviar o token

class ForgotPasswordController extends Controller
{
    /**
     * Enviar link para reset de senha via e-mail
     */
    public function sendResetLinkEmail(Request $request)
    {
        // Validando o email
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Tentando enviar o link de reset
        $response = Password::sendResetLink(
            $request->only('email')
        );

        // Verificando a resposta do envio
        if ($response == Password::RESET_LINK_SENT) {
            // Se o link for enviado, enviamos um e-mail com o token
            $user = User::where('email', $request->email)->first();
            $token = app('auth.password.broker')->createToken($user); // Gerando o token

            // Enviar e-mail com o token
            Mail::to($user->email)->send(new PasswordResetMail($token));

            return response()->json(['message' => 'Link de recuperação enviado para o seu e-mail.']);
        }

        return response()->json(['error' => 'Falha ao enviar link de recuperação.'], 400);
    }
}
