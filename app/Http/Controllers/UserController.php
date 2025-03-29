<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;


class UserController extends Controller
{

    public function update(Request $request, $id)
{
    // Buscar o usuário pelo ID
    $user = User::find($id);

    // Se não encontrar, retorna erro
    if (!$user) {
        return response()->json(['message' => 'Usuário não encontrado.'], 404);
    }

    // Validação dos campos
    $fields = $request->validate([
        'name' => 'required|max:255',
        'email' => 'required|email|unique:users,email,' . $id, // Permite manter o mesmo e-mail
        'role' => 'nullable|in:admin,moderador,user', // Apenas valores permitidos
        'password' => 'nullable|confirmed' // Senha opcional
    ]);

    // Atualizar os campos do usuário
    $user->update($fields);

    return response()->json([
        'message' => 'Usuário atualizado com sucesso!',
        'user' => $user
    ]);
}


}
