<?php

namespace App\Repositories;

use App\Models\Invitation;
use App\Repositories\Interfaces\InvitationRepositoryInterface;

class InvitationRepository implements InvitationRepositoryInterface
{
    public function create(array $data): Invitation
    {
        return Invitation::create($data);
    }

    public function findValidInvitation(string $email, string $token): ?Invitation
    {
        return Invitation::where('token', $token)
            ->where('email', $email)
            ->where('expires_at', '>', now())
            ->first();
    }

    public function deleteInvitation(Invitation $invitation): void
    {
        $invitation->delete();
    }
}
