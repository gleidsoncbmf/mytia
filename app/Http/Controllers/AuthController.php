<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Invitation;

class AuthController extends Controller
{
    public function register (Request $request){

       $fields = $request->validate([
            'name' => 'required|max:255',
            'email' =>'required|unique:users',
            'password' => 'required|confirmed',
            'role' => 'in:admin,moderador,user',
        ]);

        $user = User::create($fields);
        $token = $user->createToken($request->name);

       return [
        'user' => $user,
        'token' => $token
       ];
    }

    public function login (Request $request){

        $fields = $request->validate([

            'email' =>'required|email|exists:users',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)){
            return [
                'message:' => "Credenciais Incorretas."
            ];
        }

        $token = $user->createToken($user->name);

        return [
            'user' => $user,
            'token' => $token->plainTextToken
        ];
    }

    public function logout (Request $request){

        $request->user()->tokens()->delete();

        return [
            'message' => 'Sessão Encerrada.' 
        ];
    }

    public function registerWithInvite(Request $request)
    {
        // Validar o token de convite
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email',
            'password' => 'required|confirmed',
            'token' => 'required',
        ]);

        // Verificar se o convite é válido
        $invitation = Invitation::where('token', $request->token)
                                ->where('email', $request->email)
                                ->where('expires_at', '>', now())
                                ->first();

        if (!$invitation) {
            return response()->json(['error' => 'Convite inválido ou expirado.'], 400);
        }

        // Registrar o usuário
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // Usuário com role comum
        ]);

        // Marcar o convite como usado
        $invitation->delete(); // O convite agora é consumido, ou você pode mudar o status

        // Retornar sucesso
        return response()->json(['message' => 'Usuário registrado com sucesso!'], 200);
    }

   
}
