<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function update(Request $request, $id)
    {
        $fields = $request->validate([
            'name' => 'max:255',
            'email' => 'email|unique:users,email,' . $id, // Permite manter o mesmo e-mail
            'role' => 'nullable|in:admin,moderador,user', // Apenas valores permitidos
            'password' => 'nullable|confirmed', // Senha opcional
        ]);

        $user = $this->userService->updateUser($id, $fields);

        if (!$user) {
            return response()->json(['message' => 'Usuário não encontrado.'], 404);
        }

        return response()->json([
            'message' => 'Usuário atualizado com sucesso!',
            'user' => $user
        ]);
    }
}
