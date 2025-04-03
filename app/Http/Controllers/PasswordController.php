<?php

namespace App\Http\Controllers;

use App\Services\PasswordService;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
    protected $passwordService;

    public function __construct(PasswordService $passwordService)
    {
        $this->passwordService = $passwordService;
    }

    public function sendResetLinkEmail(Request $request)
    {
        return $this->passwordService->sendResetLink($request->all());
    }

    public function resetPassword(Request $request)
    {
        return $this->passwordService->resetPassword($request->all());
    }
}
