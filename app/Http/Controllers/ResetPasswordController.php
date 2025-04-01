<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class ResetPasswordController extends Controller
{
    /**
     * Resetar a senha do usuário com o token fornecido.
     */
    public function reset(Request $request)
    {
        // Validar os dados da requisição
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|confirmed', // A senha precisa ser confirmada e ter pelo menos 8 caracteres
            'token' => 'required|string', // O token de reset também é obrigatório
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Tentar realizar o reset da senha
        $response = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = bcrypt($password);
                $user->save();
            }
        );

        // Verificar se o reset foi bem-sucedido
        if ($response == Password::PASSWORD_RESET) {
            return response()->json(['message' => 'Senha resetada com sucesso.']);
        } else {
            return response()->json(['error' => 'Falha ao resetar a senha.'], 400);
        }
    }
}
