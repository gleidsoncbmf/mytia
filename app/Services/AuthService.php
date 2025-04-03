<?php

namespace App\Services;

use App\Repositories\Interfaces\AuthRepositoryInterface;
use App\Repositories\Interfaces\InvitationRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class AuthService
{
    protected $authRepository;
    protected $invitationRepository;

    public function __construct(
        AuthRepositoryInterface $authRepository,
        InvitationRepositoryInterface $invitationRepository
    ) {
        $this->authRepository = $authRepository;
        $this->invitationRepository = $invitationRepository;
    }

    public function register(array $data)
    {
        $user = $this->authRepository->createUser($data);
        $token = $user->createToken($user->name);

        return [
            'user' => $user,
            'token' => $token->plainTextToken
        ];
    }

    public function login(array $data)
    {
        $user = $this->authRepository->findUserByEmail($data['email']);

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json(['message' => 'Credenciais Incorretas.'], 401);
        }

        $token = $user->createToken($user->name);

        return [
            'user' => $user,
            'token' => $token->plainTextToken
        ];
    }

    public function logout(User $user)
    {
        $this->authRepository->deleteUserTokens($user);

        return ['message' => 'Sessão Encerrada.'];
    }

    public function registerWithInvite(array $data)
    {
        $invitation = $this->invitationRepository->findValidInvitation($data['email'], $data['token']);

        if (!$invitation) {
            return response()->json(['error' => 'Convite inválido ou expirado.'], 400);
        }

        $user = $this->authRepository->createUser([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'user',
        ]);

        $this->invitationRepository->deleteInvitation($invitation);

        return response()->json(['message' => 'Usuário registrado com sucesso!'], 200);
    }
}
