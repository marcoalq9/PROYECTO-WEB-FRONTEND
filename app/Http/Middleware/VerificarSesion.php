<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificarSesion
{
    public function handle(Request $request, Closure $next, ?string $rol = null): Response
    {
        // Si no hay sesión activa, redirige al login
        if (!session('user_role')) {
            return redirect()->route('login')
                ->with('error', 'Debes iniciar sesión para continuar.');
        }

        // Si se especificó un rol y no coincide, redirige a su dashboard
        if ($rol && session('user_role') !== $rol) {
            return match(session('user_role')) {
                'admin'    => redirect()->route('admin.dashboard'),
                'operador' => redirect()->route('operador.dashboard'),
                'chofer'   => redirect()->route('chofer.dashboard'),
                default    => redirect()->route('login'),
            };
        }

        return $next($request);
    }
}
