<?php

namespace App\Http\Controllers\Operador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SolicitudController extends Controller
{
    private function solicitudesDemo()
    {
        return [
            ['id' => 1, 'chofer' => 'Juan Pérez',    'vehiculo' => 'Toyota Hilux (ABC-123)',   'fecha_inicio' => '2026-04-25 08:00', 'fecha_fin' => '2026-04-25 17:00', 'motivo' => 'Entrega de materiales',    'estado' => 'Pendiente',  'aprobado_por' => null],
            ['id' => 2, 'chofer' => 'María López',   'vehiculo' => 'Hyundai Tucson (DEF-456)', 'fecha_inicio' => '2026-04-26 07:00', 'fecha_fin' => '2026-04-26 15:00', 'motivo' => 'Visita a cliente',         'estado' => 'Aprobada',   'aprobado_por' => 'Operador'],
            ['id' => 3, 'chofer' => 'Carlos Mora',   'vehiculo' => 'Nissan Frontier (JKL-012)','fecha_inicio' => '2026-04-27 09:00', 'fecha_fin' => '2026-04-27 18:00', 'motivo' => 'Transporte de equipos',   'estado' => 'Pendiente',  'aprobado_por' => null],
            ['id' => 4, 'chofer' => 'Ana Jiménez',   'vehiculo' => 'Kia Sportage (GHI-789)',   'fecha_inicio' => '2026-04-24 08:00', 'fecha_fin' => '2026-04-24 12:00', 'motivo' => 'Reunión en sede central',  'estado' => 'Rechazada',  'aprobado_por' => 'Operador'],
        ];
    }

    public function index()
    {
        $solicitudes = $this->solicitudesDemo();
        return view('operador.solicitudes.index', compact('solicitudes'));
    }

    public function show($id)
    {
        $solicitud = $this->solicitudesDemo()[0];
        return view('operador.solicitudes.show', compact('solicitud'));
    }

    public function aprobar($id)
    {
        // TODO: enviar al API
        return redirect()->route('operador.solicitudes.index')
            ->with('success', 'Solicitud aprobada correctamente. El vehículo ha sido reservado.');
    }

    public function rechazar(Request $request, $id)
    {
        // TODO: enviar al API
        return redirect()->route('operador.solicitudes.index')
            ->with('success', 'Solicitud rechazada correctamente.');
    }
}
