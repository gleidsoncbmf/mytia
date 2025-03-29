<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class ResetPasswordController extends Controller
{
    /**
     * Resetar a senha do usuário
     */
    public function reset(Request $request)
    {
        // Validando os dados da requisição
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|confirmed|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Tenta resetar a senha
        $response = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password),
                ])->save();
            }
        );

        // Verificando a resposta do reset
        return $response == Password::PASSWORD_RESET
            ? response()->json(['message' => 'Senha redefinida com sucesso!'])
            : response()->json(['error' => 'Falha ao resetar a senha.'], 400);
    }
}