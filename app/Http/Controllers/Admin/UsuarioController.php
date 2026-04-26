<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\VehiculosApi;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function __construct(private VehiculosApi $api)
    {
    }

    public function index(Request $request)
    {
        $estado = $request->input('estado', 'Activo');
        $endpoint = $estado === 'Inactivo' ? 'users/inactive' : 'users';
        $usuarios = collect($this->api->list($endpoint))->map(fn ($user) => $this->toView($user))->all();
        $estados = ['Activo', 'Inactivo'];

        return view('admin.usuarios.index', compact('usuarios', 'estados', 'estado'));
    }

    public function create()
    {
        $roles = ['Administrador', 'Operador', 'Chofer'];

        return view('admin.usuarios.create', compact('roles'));
    }

    public function edit($id)
    {
        $user = $this->api->item("users/{$id}");

        if (! $user) {
            return redirect()->route('admin.usuarios.index')->with('error', 'Usuario no encontrado.');
        }

        $usuario = $this->toView($user);
        $roles = ['Administrador', 'Operador', 'Chofer'];

        return view('admin.usuarios.edit', compact('usuario', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'correo' => 'required|email',
            'telefono' => 'nullable|string|max:20',
            'rol' => 'required|string',
            'password' => 'required|min:6|confirmed',
        ]);

        $response = $this->api->post('users', [
            'name' => $request->nombre,
            'email' => $request->correo,
            'telephone' => $request->telefono,
            'role_id' => $this->api->roleId($request->rol),
            'password' => $request->password,
        ]);

        if ($response->failed()) {
            return back()->withInput()->with('error', $this->api->error($response));
        }

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario creado correctamente.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'correo' => 'required|email',
            'telefono' => 'nullable|string|max:20',
            'rol' => 'required|string',
        ]);

        $response = $this->api->put("users/{$id}", [
            'name' => $request->nombre,
            'email' => $request->correo,
            'telephone' => $request->telefono,
            'role_id' => $this->api->roleId($request->rol),
        ]);

        if ($response->failed()) {
            return back()->withInput()->with('error', $this->api->error($response));
        }

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy($id)
    {
        $response = $this->api->delete("users/{$id}");

        if ($response->failed()) {
            return back()->with('error', $this->api->error($response));
        }

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario eliminado correctamente.');
    }

    public function restore($id)
    {
        $response = $this->api->patch("users/{$id}/restore");

        if ($response->failed()) {
            return back()->with('error', $this->api->error($response));
        }

        return redirect()
            ->route('admin.usuarios.index', ['estado' => 'Inactivo'])
            ->with('success', 'Usuario activado correctamente.');
    }

    private function toView(array $user): array
    {
        return [
            'id' => $user['id'] ?? null,
            'nombre' => $user['name'] ?? '',
            'correo' => $user['email'] ?? '',
            'telefono' => $user['telephone'] ?? '',
            'rol' => $this->api->roleName($user['role_id'] ?? null, $user['role'] ?? null),
            'estado' => empty($user['deleted_at']) ? 'Activo' : 'Inactivo',
        ];
    }
}
