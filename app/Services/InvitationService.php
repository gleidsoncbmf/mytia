<?php

namespace App\Services;

use App\Mail\InviteMail;
use App\Repositories\Interfaces\InvitationRepositoryInterface;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class InvitationService
{
    protected $invitationRepository;

    public function __construct(InvitationRepositoryInterface $invitationRepository)
    {
        $this->invitationRepository = $invitationRepository;
    }

    public function generateInvite(string $email)
    {
        // Gerar token único
        $token = Str::random(60);
        
        // Definir expiração do convite (7 dias)
        $expiresAt = now()->addDays(7);

        // Criar o convite no banco de dados
        $invitation = $this->invitationRepository->create([
            'email' => $email,
            'token' => $token,
            'expires_at' => $expiresAt,
        ]);

        // Enviar o e-mail de convite
        Mail::to($email)->send(new InviteMail($token));

        return $invitation;
    }
}
