<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'role' => 'in:admin,moderador,user',
        ]);

        return response()->json($this->authService->register($data), 201);
    }

    public function login(Request $request): JsonResponse
    {
        $data = $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
        ]);

        return response()->json($this->authService->login($data));
    }

    public function logout(Request $request): JsonResponse
    {
        return response()->json($this->authService->logout($request->user()));
    }

    public function registerWithInvite(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email',
            'password' => 'required|confirmed',
            'token' => 'required',
        ]);

        return response()->json($this->authService->registerWithInvite($data));
    }
}
