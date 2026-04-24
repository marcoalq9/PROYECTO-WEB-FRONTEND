<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VehiculoController extends Controller
{
    private function vehiculosDemo()
    {
        return [
            ['id' => 1, 'placa' => 'ABC-123', 'marca' => 'Toyota',  'modelo' => 'Hilux',   'anio' => 2022, 'tipo' => 'Pick-up',  'capacidad' => 5, 'combustible' => 'Diesel',  'estado' => 'Disponible',    'imagen' => null],
            ['id' => 2, 'placa' => 'DEF-456', 'marca' => 'Hyundai', 'modelo' => 'Tucson',  'anio' => 2021, 'tipo' => 'SUV',      'capacidad' => 5, 'combustible' => 'Gasolina', 'estado' => 'Asignado',      'imagen' => null],
            ['id' => 3, 'placa' => 'GHI-789', 'marca' => 'Kia',     'modelo' => 'Sportage','anio' => 2023, 'tipo' => 'SUV',      'capacidad' => 5, 'combustible' => 'Gasolina', 'estado' => 'Mantenimiento', 'imagen' => null],
            ['id' => 4, 'placa' => 'JKL-012', 'marca' => 'Nissan',  'modelo' => 'Frontier','anio' => 2020, 'tipo' => 'Pick-up',  'capacidad' => 5, 'combustible' => 'Diesel',  'estado' => 'Disponible',    'imagen' => null],
        ];
    }

    public function index(Request $request)
    {
        $vehiculos = $this->vehiculosDemo();
        $estados   = ['Disponible', 'Asignado', 'Mantenimiento', 'Fuera de servicio'];

        // Filtro por estado
        if ($request->filled('estado')) {
            $vehiculos = array_filter($vehiculos, fn($v) => $v['estado'] === $request->estado);
        }

        return view('admin.vehiculos.index', compact('vehiculos', 'estados'));
    }

    public function create()
    {
        $tipos        = ['Sedán', 'SUV', 'Pick-up', 'Van', 'Microbús', 'Camión'];
        $combustibles = ['Gasolina', 'Diesel', 'Híbrido', 'Eléctrico'];
        $estados      = ['Disponible', 'Fuera de servicio'];
        return view('admin.vehiculos.create', compact('tipos', 'combustibles', 'estados'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'placa'       => 'required|string|max:20',
            'marca'       => 'required|string|max:50',
            'modelo'      => 'required|string|max:50',
            'anio'        => 'required|integer|min:2000|max:2099',
            'tipo'        => 'required|string',
            'capacidad'   => 'required|integer|min:1',
            'combustible' => 'required|string',
            'estado'      => 'required|string',
            'imagen'      => 'nullable|image|max:2048',
        ]);

        // TODO: enviar al API
        return redirect()->route('admin.vehiculos.index')
            ->with('success', 'Vehículo registrado correctamente.');
    }

    public function edit($id)
    {
        // TODO: reemplazar con llamada al API
        $vehiculo     = $this->vehiculosDemo()[0];
        $tipos        = ['Sedán', 'SUV', 'Pick-up', 'Van', 'Microbús', 'Camión'];
        $combustibles = ['Gasolina', 'Diesel', 'Híbrido', 'Eléctrico'];
        $estados      = ['Disponible', 'Asignado', 'Mantenimiento', 'Fuera de servicio'];
        return view('admin.vehiculos.edit', compact('vehiculo', 'tipos', 'combustibles', 'estados'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'placa'       => 'required|string|max:20',
            'marca'       => 'required|string|max:50',
            'modelo'      => 'required|string|max:50',
            'anio'        => 'required|integer|min:2000|max:2099',
            'tipo'        => 'required|string',
            'capacidad'   => 'required|integer|min:1',
            'combustible' => 'required|string',
            'estado'      => 'required|string',
        ]);

        // TODO: enviar al API
        return redirect()->route('admin.vehiculos.index')
            ->with('success', 'Vehículo actualizado correctamente.');
    }

    public function destroy($id)
    {
        // TODO: enviar al API
        return redirect()->route('admin.vehiculos.index')
            ->with('success', 'Vehículo eliminado correctamente.');
    }
}