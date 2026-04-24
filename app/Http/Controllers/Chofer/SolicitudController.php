<?php

namespace App\Http\Controllers\Chofer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SolicitudController extends Controller
{
    private function solicitudesDemo()
    {
        return [
            ['id' => 1, 'vehiculo' => 'Toyota Hilux (ABC-123)',   'fecha_inicio' => '2026-04-25 08:00', 'fecha_fin' => '2026-04-25 17:00', 'motivo' => 'Entrega de materiales',  'estado' => 'Pendiente'],
            ['id' => 2, 'vehiculo' => 'Nissan Frontier (JKL-012)','fecha_inicio' => '2026-04-20 07:00', 'fecha_fin' => '2026-04-20 15:00', 'motivo' => 'Visita a proveedor',     'estado' => 'Aprobada'],
            ['id' => 3, 'vehiculo' => 'Toyota Hilux (ABC-123)',   'fecha_inicio' => '2026-04-15 09:00', 'fecha_fin' => '2026-04-15 18:00', 'motivo' => 'Transporte de equipos',  'estado' => 'Rechazada'],
            ['id' => 4, 'vehiculo' => 'Nissan Frontier (JKL-012)','fecha_inicio' => '2026-04-10 08:00', 'fecha_fin' => '2026-04-10 12:00', 'motivo' => 'Reunión en sede',        'estado' => 'Cancelada'],
        ];
    }

    public function index()
    {
        $solicitudes = $this->solicitudesDemo();
        return view('chofer.solicitudes.index', compact('solicitudes'));
    }

    public function create(Request $request)
    {
        $vehiculos = [
            ['id' => 1, 'nombre' => 'Toyota Hilux (ABC-123)'],
            ['id' => 4, 'nombre' => 'Nissan Frontier (JKL-012)'],
        ];
        $vehiculo_id = $request->vehiculo_id;
        return view('chofer.solicitudes.create', compact('vehiculos', 'vehiculo_id'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'vehiculo_id'  => 'required',
            'fecha_inicio' => 'required|date',
            'fecha_fin'    => 'required|date|after:fecha_inicio',
            'motivo'       => 'nullable|string|max:255',
        ]);

        // TODO: enviar al API
        return redirect()->route('chofer.solicitudes.index')
            ->with('success', 'Solicitud enviada correctamente. Queda pendiente de aprobación.');
    }

    public function cancelar($id)
    {
        // TODO: enviar al API
        return redirect()->route('chofer.solicitudes.index')
            ->with('success', 'Solicitud cancelada correctamente.');
    }
}