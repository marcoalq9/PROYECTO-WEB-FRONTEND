<?php

namespace App\Http\Controllers\Chofer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VehiculoController extends Controller
{
    private function vehiculosDisponibles()
    {
        return [
            ['id' => 1, 'placa' => 'ABC-123', 'marca' => 'Toyota',  'modelo' => 'Hilux',    'anio' => 2022, 'tipo' => 'Pick-up', 'capacidad' => 5, 'combustible' => 'Diesel',  'estado' => 'Disponible', 'imagen' => null],
            ['id' => 4, 'placa' => 'JKL-012', 'marca' => 'Nissan',  'modelo' => 'Frontier', 'anio' => 2020, 'tipo' => 'Pick-up', 'capacidad' => 5, 'combustible' => 'Diesel',  'estado' => 'Disponible', 'imagen' => null],
        ];
    }

    public function index(Request $request)
    {
        $vehiculos     = $this->vehiculosDisponibles();
        $fecha_inicio  = $request->fecha_inicio;
        $fecha_fin     = $request->fecha_fin;
        return view('chofer.vehiculos.index', compact('vehiculos', 'fecha_inicio', 'fecha_fin'));
    }

    public function show($id)
    {
        $vehiculo = $this->vehiculosDisponibles()[0];
        return view('chofer.vehiculos.show', compact('vehiculo'));
    }
}