<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminOrModeratorMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Verifica se o usuário está autenticado e se sua role é 'admin' ou 'moderador'
        if (!$request->user() || !in_array($request->user()->role, ['admin', 'moderador'])) {
            return response()->json(['error' => 'Acesso negado'], 403);
        }

        return $next($request);
    }
}
