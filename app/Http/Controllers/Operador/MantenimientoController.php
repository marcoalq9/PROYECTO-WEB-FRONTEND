<?php

namespace App\Http\Controllers\Operador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MantenimientoController extends Controller
{
    private function mantenimientosDemo()
    {
        return [
            ['id' => 1, 'vehiculo' => 'Toyota Hilux (ABC-123)',   'tipo' => 'Preventivo', 'fecha_inicio' => '2026-04-01', 'fecha_cierre' => '2026-04-03', 'descripcion' => 'Cambio de aceite y filtros', 'costo' => 45000, 'estado' => 'Cerrado'],
            ['id' => 2, 'vehiculo' => 'Kia Sportage (GHI-789)',   'tipo' => 'Correctivo', 'fecha_inicio' => '2026-04-20', 'fecha_cierre' => null,         'descripcion' => 'Falla en sistema de frenos', 'costo' => null,  'estado' => 'Abierto'],
            ['id' => 3, 'vehiculo' => 'Hyundai Tucson (DEF-456)', 'tipo' => 'Preventivo', 'fecha_inicio' => '2026-03-15', 'fecha_cierre' => '2026-03-16', 'descripcion' => 'Revisión general',           'costo' => 25000, 'estado' => 'Cerrado'],
        ];
    }

    public function index()
    {
        $mantenimientos = $this->mantenimientosDemo();
        return view('operador.mantenimientos.index', compact('mantenimientos'));
    }

    public function create()
    {
        $vehiculos = [
            ['id' => 1, 'nombre' => 'Toyota Hilux (ABC-123)'],
            ['id' => 2, 'nombre' => 'Hyundai Tucson (DEF-456)'],
            ['id' => 3, 'nombre' => 'Kia Sportage (GHI-789)'],
            ['id' => 4, 'nombre' => 'Nissan Frontier (JKL-012)'],
        ];
        $tipos = ['Preventivo', 'Correctivo'];
        return view('operador.mantenimientos.create', compact('vehiculos', 'tipos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'vehiculo_id'  => 'required',
            'tipo'         => 'required|string',
            'fecha_inicio' => 'required|date',
            'descripcion'  => 'required|string|max:500',
            'costo'        => 'nullable|numeric|min:0',
        ]);

        // TODO: enviar al API
        return redirect()->route('operador.mantenimientos.index')
            ->with('success', 'Mantenimiento registrado. El vehículo ha sido marcado como no disponible.');
    }

    public function edit($id)
    {
        $mantenimiento = $this->mantenimientosDemo()[1];
        $vehiculos = [
            ['id' => 1, 'nombre' => 'Toyota Hilux (ABC-123)'],
            ['id' => 2, 'nombre' => 'Hyundai Tucson (DEF-456)'],
            ['id' => 3, 'nombre' => 'Kia Sportage (GHI-789)'],
        ];
        $tipos = ['Preventivo', 'Correctivo'];
        return view('operador.mantenimientos.edit', compact('mantenimiento', 'vehiculos', 'tipos'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'vehiculo_id'  => 'required',
            'tipo'         => 'required|string',
            'fecha_inicio' => 'required|date',
            'descripcion'  => 'required|string|max:500',
            'costo'        => 'nullable|numeric|min:0',
        ]);

        // TODO: enviar al API
        return redirect()->route('operador.mantenimientos.index')
            ->with('success', 'Mantenimiento actualizado correctamente.');
    }

    public function cerrar($id)
    {
        // TODO: enviar al API
        return redirect()->route('operador.mantenimientos.index')
            ->with('success', 'Mantenimiento cerrado. El vehículo vuelve a estar disponible.');
    }

    public function destroy($id)
    {
        // TODO: enviar al API
        return redirect()->route('operador.mantenimientos.index')
            ->with('success', 'Mantenimiento eliminado correctamente.');
    }
}