<?php

namespace App\Services;

use App\Repositories\Interfaces\PasswordRepositoryInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetMail;
use App\Models\User;
use Illuminate\Support\Facades\Password;

class PasswordService
{
    protected $passwordRepository;

    public function __construct(PasswordRepositoryInterface $passwordRepository)
    {
        $this->passwordRepository = $passwordRepository;
    }

    public function sendResetLink(array $data)
    {
        // Validação dos dados
        $validator = Validator::make($data, [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Envio do link de recuperação
        $response = $this->passwordRepository->sendResetLink($data['email']);

        if ($response === Password::RESET_LINK_SENT) {
            $user = User::where('email', $data['email'])->first();
            $token = app('auth.password.broker')->createToken($user); // Gerando o token

            // Enviar e-mail com o token
            Mail::to($user->email)->send(new PasswordResetMail($token));

            return response()->json(['message' => 'Link de recuperação enviado para o seu e-mail.']);
        }

        return response()->json(['error' => 'Falha ao enviar link de recuperação.'], 400);
    }

    public function resetPassword(array $data)
    {
        // Validação dos dados
        $validator = Validator::make($data, [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|confirmed',
            'token' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Tentar redefinir a senha
        $response = $this->passwordRepository->resetPassword(
            $data,
            function ($user, $password) {
                $user->password = bcrypt($password);
                $user->save();
            }
        );

        return $response === Password::PASSWORD_RESET
            ? response()->json(['message' => 'Senha resetada com sucesso.'])
            : response()->json(['error' => 'Falha ao resetar a senha.'], 400);
    }
}
