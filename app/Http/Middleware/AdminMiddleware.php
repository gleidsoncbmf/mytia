<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verifica se o usuário está autenticado e se ele tem a role de 'admin'
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Acesso negado'], 403);
        }

        return $next($request);
    }
}
