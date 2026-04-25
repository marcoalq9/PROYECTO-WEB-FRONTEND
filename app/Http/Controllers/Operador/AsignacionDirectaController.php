<?php

namespace App\Http\Controllers\Operador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AsignacionDirectaController extends Controller
{
    public function create()
    {
        // TODO: reemplazar con llamada al API
        $choferes = [
            ['id' => 1, 'nombre' => 'Juan Pérez'],
            ['id' => 2, 'nombre' => 'María López'],
            ['id' => 3, 'nombre' => 'Carlos Mora'],
        ];
        $vehiculos = [
            ['id' => 1, 'nombre' => 'Toyota Hilux (ABC-123)'],
            ['id' => 4, 'nombre' => 'Nissan Frontier (JKL-012)'],
        ];
        return view('operador.asignacion-directa.create', compact('choferes', 'vehiculos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'chofer_id'    => 'required',
            'vehiculo_id'  => 'required',
            'fecha_inicio' => 'required|date',
            'fecha_fin'    => 'required|date|after:fecha_inicio',
            'motivo'       => 'nullable|string|max:255',
        ]);

        // TODO: enviar al API
        return redirect()->route('operador.solicitudes.index')
            ->with('success', 'Asignación directa creada correctamente.');
    }
}