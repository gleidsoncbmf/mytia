<?php

namespace App\Repositories\Interfaces;

use App\Models\Invitation;

interface InvitationRepositoryInterface
{
    public function create(array $data): Invitation;
    public function deleteInvitation(Invitation $invitation): void;
    public function findValidInvitation(string $email, string $token): ?Invitation;
    
}
