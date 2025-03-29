<?php

namespace App\Http\Controllers;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class InviteController extends Controller
{
    public function generateInvite(Request $request)
    {
        // Validar o e-mail do convidado
        $request->validate([
            'email' => 'required|email|unique:invitations,email',
        ]);

        // Gerar token único para o convite
        $token = Str::random(60); // Token com 60 caracteres aleatórios

        // Definir data de expiração do convite (7 dias)
        $expiresAt = now()->addDays(7);

        // Criar o convite
        $invitation = Invitation::create([
            'email' => $request->email,
            'token' => $token,
            'expires_at' => $expiresAt,
        ]);

        // Retornar o token gerado
        return response()->json([
            'message' => 'Convite gerado com sucesso!',
            'token' => $invitation->token,
        ]);
    }


}