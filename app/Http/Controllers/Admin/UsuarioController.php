<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    // Lista todos los usuarios
    public function index()
    {
        // TODO: reemplazar con llamada al API
        $usuarios = [
            ['id' => 1, 'nombre' => 'Administrador', 'correo' => 'admin@flotilla.com',    'telefono' => '8888-0001', 'rol' => 'Administrador', 'estado' => 'Activo'],
            ['id' => 2, 'nombre' => 'Operador',       'correo' => 'operador@flotilla.com', 'telefono' => '8888-0002', 'rol' => 'Operador',       'estado' => 'Activo'],
            ['id' => 3, 'nombre' => 'Chofer',         'correo' => 'chofer@flotilla.com',   'telefono' => '8888-0003', 'rol' => 'Chofer',         'estado' => 'Activo'],
        ];

        return view('admin.usuarios.index', compact('usuarios'));
    }

    // Muestra formulario de creación
    public function create()
    {
        $roles = ['Administrador', 'Operador', 'Chofer'];
        return view('admin.usuarios.create', compact('roles'));
    }

    // Muestra formulario de edición
    public function edit($id)
    {
        // TODO: reemplazar con llamada al API
        $usuario = ['id' => $id, 'nombre' => 'Usuario Ejemplo', 'correo' => 'usuario@flotilla.com', 'telefono' => '8888-0000', 'rol' => 'Chofer'];
        $roles   = ['Administrador', 'Operador', 'Chofer'];
        return view('admin.usuarios.edit', compact('usuario', 'roles'));
    }

    // Procesa creación
    public function store(Request $request)
    {
        $request->validate([
            'nombre'   => 'required|string|max:100',
            'correo'   => 'required|email',
            'telefono' => 'nullable|string|max:20',
            'rol'      => 'required|string',
            'password' => 'required|min:6|confirmed',
        ]);

        // TODO: enviar al API
        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    // Procesa edición
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre'   => 'required|string|max:100',
            'correo'   => 'required|email',
            'telefono' => 'nullable|string|max:20',
            'rol'      => 'required|string',
        ]);

        // TODO: enviar al API
        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    // Borrado lógico
    public function destroy($id)
    {
        // TODO: enviar al API
        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }
}