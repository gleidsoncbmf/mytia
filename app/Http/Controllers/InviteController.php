<?php

namespace App\Http\Controllers;

use App\Services\InvitationService;
use Illuminate\Http\Request;

class InviteController extends Controller
{
    protected $invitationService;

    public function __construct(InvitationService $invitationService)
    {
        $this->invitationService = $invitationService;
    }

    public function generateInvite(Request $request)
    {
        
        $request->validate(['email' => 'required|email']);

        $invitation = $this->invitationService->generateInvite($request->email);

        return response()->json([
            'message' => 'Convite gerado com sucesso!',
            'token' => $invitation->token,
        ]);
    }
    
}
