<?php

namespace App\Http\Controllers\Operador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ViajeController extends Controller
{
    private function viajesDemo()
    {
        return [
            ['id' => 1, 'chofer' => 'Juan Pérez',  'vehiculo' => 'Toyota Hilux (ABC-123)',   'ruta' => 'San José - Heredia',  'fecha_salida' => '2026-04-20 08:00', 'fecha_regreso' => '2026-04-20 17:00', 'km_salida' => 15000, 'km_regreso' => 15025, 'observaciones' => null,                'estado' => 'Finalizado'],
            ['id' => 2, 'chofer' => 'María López', 'vehiculo' => 'Hyundai Tucson (DEF-456)', 'ruta' => 'San José - Alajuela', 'fecha_salida' => '2026-04-22 07:00', 'fecha_regreso' => null,               'km_salida' => 32000, 'km_regreso' => null,  'observaciones' => 'Lleva materiales', 'estado' => 'En curso'],
            ['id' => 3, 'chofer' => 'Carlos Mora', 'vehiculo' => 'Nissan Frontier (JKL-012)','ruta' => 'Heredia - Cartago',   'fecha_salida' => '2026-04-23 09:00', 'fecha_regreso' => '2026-04-23 16:00', 'km_salida' => 8500,  'km_regreso' => 8535,  'observaciones' => null,                'estado' => 'Finalizado'],
        ];
    }

    public function index()
    {
        $viajes = $this->viajesDemo();
        return view('operador.viajes.index', compact('viajes'));
    }

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
            ['id' => 2, 'nombre' => 'Hyundai Tucson (DEF-456)'],
            ['id' => 4, 'nombre' => 'Nissan Frontier (JKL-012)'],
        ];
        $rutas = [
            ['id' => 1, 'nombre' => 'San José - Heredia'],
            ['id' => 2, 'nombre' => 'San José - Alajuela'],
            ['id' => 3, 'nombre' => 'Heredia - Cartago'],
            ['id' => 4, 'nombre' => 'San José - Limón'],
        ];
        return view('operador.viajes.create', compact('choferes', 'vehiculos', 'rutas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'chofer_id'    => 'required',
            'vehiculo_id'  => 'required',
            'ruta_id'      => 'nullable',
            'fecha_salida' => 'required|date',
            'km_salida'    => 'required|integer|min:0',
            'observaciones'=> 'nullable|string|max:500',
        ]);

        // TODO: enviar al API
        return redirect()->route('operador.viajes.index')
            ->with('success', 'Salida registrada correctamente.');
    }

    public function registrarRetorno(Request $request, $id)
    {
        $request->validate([
            'fecha_regreso' => 'required|date',
            'km_regreso'    => 'required|integer|min:0',
            'observaciones' => 'nullable|string|max:500',
        ]);

        // Validación km regreso >= km salida
        // TODO: validar contra el API
        if ($request->km_regreso < $request->km_salida_original) {
            return back()->withErrors(['km_regreso' => 'El kilometraje de regreso no puede ser menor al de salida.'])
                         ->withInput();
        }

        // TODO: enviar al API
        return redirect()->route('operador.viajes.index')
            ->with('success', 'Devolución registrada correctamente.');
    }
}
