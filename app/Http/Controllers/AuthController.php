<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    // Muestra el formulario de login
    public function showLogin()
    {
        // Si ya hay sesion activa, redirige segun el rol
        if (session('user_role')) {
            return $this->redirectByRole(session('user_role'));
        }

        return view('auth.login');
    }

    // Procesa el formulario de login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $apiUrl = config('services.vehiculos.url');

        try {
            $response = Http::acceptJson()
                ->timeout(10)
                ->post("{$apiUrl}/api/login", [
                    'email' => $request->email,
                    'password' => $request->password,
                ]);
        } catch (\Throwable $e) {
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'No se pudo conectar con el backend. Verifica que Proyecto-Vehiculos este encendido.');
        }

        if ($response->failed()) {
            return back()
                ->withInput($request->only('email'))
                ->with('error', $response->json('message', 'Credenciales incorrectas. Intenta de nuevo.'));
        }

        $data = $response->json();
        $user = $data['user'] ?? [];
        $role = $this->normalizeRole($user);

        if (! $role) {
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'El usuario no tiene un rol valido para entrar al sistema.');
        }

        session([
            'api_token' => $data['access_token'] ?? null,
            'token_type' => $data['token_type'] ?? 'Bearer',
            'user_id' => $user['id'] ?? null,
            'user_name' => $user['name'] ?? '',
            'user_email' => $user['email'] ?? $request->email,
            'user_role' => $role,
        ]);

        return $this->redirectByRole($role);
    }

    // Cierra la sesion
    public function logout()
    {
        $apiUrl = config('services.vehiculos.url');
        $token = session('api_token');

        if ($token) {
            try {
                Http::acceptJson()
                    ->withToken($token)
                    ->timeout(10)
                    ->post("{$apiUrl}/api/logout");
            } catch (\Throwable $e) {
                // La sesion local se cierra aunque el backend no responda.
            }
        }

        session()->flush();

        return redirect()->route('login')->with('success', 'Sesion cerrada correctamente.');
    }

    private function normalizeRole(array $user): ?string
    {
        $roleName = strtolower($user['role']['role_name'] ?? '');

        return match ($roleName) {
            'admin', 'administrador' => 'admin',
            'operador' => 'operador',
            'chofer' => 'chofer',
            default => match ((int) ($user['role_id'] ?? 0)) {
                1 => 'admin',
                2 => 'operador',
                3 => 'chofer',
                default => null,
            },
        };
    }

    // Redirige segun el rol del usuario
    private function redirectByRole($role)
    {
        return match ($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'operador' => redirect()->route('operador.dashboard'),
            'chofer' => redirect()->route('chofer.dashboard'),
            default => redirect()->route('login'),
        };
    }
}
