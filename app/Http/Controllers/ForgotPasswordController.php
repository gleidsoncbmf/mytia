<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;


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
        return $response == Password::RESET_LINK_SENT
            ? response()->json(['message' => 'Link de recuperação enviado para o seu e-mail.'])
            : response()->json(['error' => 'Falha ao enviar link de recuperação.'], 400);
    }
}