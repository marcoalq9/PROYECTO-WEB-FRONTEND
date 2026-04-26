<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ApiService;

class AuthController extends Controller
{
    private ApiService $api;

    public function __construct()
    {
        $this->api = new ApiService();
    }

    public function showLogin()
    {
        if (session('user_role')) {
            return $this->redirectByRole(session('user_role'));
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $response = $this->api->postPublic('login', [
            'email'    => $request->email,
            'password' => $request->password,
        ]);

        if (isset($response['access_token'])) {
            $user = $response['user'];
            $role = strtolower($user['role']['role_name']);

            session([
                'api_token'  => $response['access_token'],
                'user_id'    => $user['id'],
                'user_name'  => $user['name'],
                'user_email' => $user['email'],
                'user_role'  => $role,
            ]);

            return $this->redirectByRole($role);
        }

        return back()->with('error', $response['message'] ?? 'Credenciales incorrectas.');
    }

    public function logout()
    {
        $this->api->post('logout');
        session()->flush();
        return redirect()->route('login')
            ->with('success', 'Sesión cerrada correctamente.');
    }

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