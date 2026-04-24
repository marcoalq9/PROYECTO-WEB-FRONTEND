<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    // Muestra el formulario de login
    public function showLogin()
    {
        // Si ya hay sesión activa, redirige según el rol
        if (session('user_role')) {
            return $this->redirectByRole(session('user_role'));
        }
        return view('auth.login');
    }

    // Procesa el formulario de login
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Aquí consumiremos el API cuando el backend esté listo
        // Por ahora simulamos con usuarios de prueba
        $usuarios = [
            ['email' => 'admin@flotilla.com',    'password' => '123456', 'role' => 'admin',    'name' => 'Administrador'],
            ['email' => 'operador@flotilla.com', 'password' => '123456', 'role' => 'operador', 'name' => 'Operador'],
            ['email' => 'chofer@flotilla.com',   'password' => '123456', 'role' => 'chofer',   'name' => 'Chofer'],
        ];

        foreach ($usuarios as $usuario) {
            if ($usuario['email'] === $request->email && $usuario['password'] === $request->password) {
                session([
                    'user_id'   => 1,
                    'user_name' => $usuario['name'],
                    'user_email'=> $usuario['email'],
                    'user_role' => $usuario['role'],
                ]);
                return $this->redirectByRole($usuario['role']);
            }
        }

        return back()->with('error', 'Credenciales incorrectas. Intenta de nuevo.');
    }

    // Cierra la sesión
    public function logout()
    {
        session()->flush();
        return redirect()->route('login')->with('success', 'Sesión cerrada correctamente.');
    }

    // Redirige según el rol del usuario
    private function redirectByRole($role)
    {
        return match($role) {
            'admin'    => redirect()->route('admin.dashboard'),
            'operador' => redirect()->route('operador.dashboard'),
            'chofer'   => redirect()->route('chofer.dashboard'),
            default    => redirect()->route('login'),
        };
    }
}