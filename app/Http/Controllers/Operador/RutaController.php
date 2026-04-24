<?php

namespace App\Http\Controllers\Operador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RutaController extends Controller
{
    private function rutasDemo()
    {
        return [
            ['id' => 1, 'nombre' => 'San José - Heredia',    'inicio' => 'San José Centro',   'fin' => 'Heredia Centro',    'distancia' => 12.5, 'descripcion' => 'Ruta principal por circunvalación'],
            ['id' => 2, 'nombre' => 'San José - Alajuela',   'inicio' => 'San José Centro',   'fin' => 'Alajuela Centro',   'distancia' => 20.0, 'descripcion' => 'Ruta por autopista General Cañas'],
            ['id' => 3, 'nombre' => 'Heredia - Cartago',     'inicio' => 'Heredia Centro',    'fin' => 'Cartago Centro',    'distancia' => 35.0, 'descripcion' => 'Ruta por San José'],
            ['id' => 4, 'nombre' => 'San José - Limón',      'inicio' => 'San José Centro',   'fin' => 'Limón Centro',      'distancia' => 160.0,'descripcion' => 'Ruta por autopista Braulio Carrillo'],
        ];
    }

    public function index()
    {
        $rutas = $this->rutasDemo();
        return view('operador.rutas.index', compact('rutas'));
    }

    public function create()
    {
        return view('operador.rutas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'     => 'required|string|max:100',
            'inicio'     => 'required|string|max:100',
            'fin'        => 'required|string|max:100',
            'distancia'  => 'nullable|numeric|min:0',
            'descripcion'=> 'nullable|string|max:500',
        ]);

        // TODO: enviar al API
        return redirect()->route('operador.rutas.index')
            ->with('success', 'Ruta creada correctamente.');
    }

    public function edit($id)
    {
        $ruta = $this->rutasDemo()[0];
        return view('operador.rutas.edit', compact('ruta'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre'     => 'required|string|max:100',
            'inicio'     => 'required|string|max:100',
            'fin'        => 'required|string|max:100',
            'distancia'  => 'nullable|numeric|min:0',
            'descripcion'=> 'nullable|string|max:500',
        ]);

        // TODO: enviar al API
        return redirect()->route('operador.rutas.index')
            ->with('success', 'Ruta actualizada correctamente.');
    }

    public function destroy($id)
    {
        // TODO: enviar al API
        return redirect()->route('operador.rutas.index')
            ->with('success', 'Ruta eliminada correctamente.');
    }
}
