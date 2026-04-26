<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    private ApiService $api;

    public function __construct()
    {
        $this->api = new ApiService();
    }

    public function index()
    {
        $response = $this->api->get('users');
        $usuarios = $response['data']['data'] ?? [];
        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        $roles = ['Admin', 'Operador', 'Chofer'];
        return view('admin.usuarios.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'   => 'required|string|max:100',
            'correo'   => 'required|email',
            'telefono' => 'nullable|string|max:20',
            'rol'      => 'required|string',
            'password' => 'required|min:6|confirmed',
        ]);

        $response = $this->api->post('users', [
            'name'      => $request->nombre,
            'email'     => $request->correo,
            'telephone' => $request->telefono,
            'role_id'   => $this->rolToId($request->rol),
            'password'  => $request->password,
        ]);

        if (isset($response['error']) || isset($response['message']) && str_contains(strtolower($response['message']), 'error')) {
            return back()->with('error', 'Error al crear el usuario.')->withInput();
        }

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    public function edit($id)
    {
        $response = $this->api->get("users/{$id}");
        $usuario  = $response['data'] ?? $response ?? [];
        $roles    = ['Admin', 'Operador', 'Chofer'];
        return view('admin.usuarios.edit', compact('usuario', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre'   => 'required|string|max:100',
            'correo'   => 'required|email',
            'telefono' => 'nullable|string|max:20',
            'rol'      => 'required|string',
        ]);

        $data = [
            'name'      => $request->nombre,
            'email'     => $request->correo,
            'telephone' => $request->telefono,
            'role_id'   => $this->rolToId($request->rol),
        ];

        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        $response = $this->api->put("users/{$id}", $data);

        if (isset($response['error'])) {
            return back()->with('error', 'Error al actualizar el usuario.')->withInput();
        }

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy($id)
    {
        $this->api->delete("users/{$id}");
        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }

    // Convierte nombre de rol a ID
    private function rolToId($rol): int
    {
        return match(strtolower($rol)) {
            'admin'    => 1,
            'operador' => 2,
            'chofer'   => 3,
            default    => 3,
        };
    }
}