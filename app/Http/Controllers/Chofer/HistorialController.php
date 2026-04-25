<?php

namespace App\Http\Controllers\Chofer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HistorialController extends Controller
{
    public function index()
    {
        $solicitudes = [
            ['id' => 1, 'vehiculo' => 'Toyota Hilux (ABC-123)',    'fecha_inicio' => '2026-04-25 08:00', 'fecha_fin' => '2026-04-25 17:00', 'estado' => 'Pendiente'],
            ['id' => 2, 'vehiculo' => 'Nissan Frontier (JKL-012)', 'fecha_inicio' => '2026-04-20 07:00', 'fecha_fin' => '2026-04-20 15:00', 'estado' => 'Aprobada'],
            ['id' => 3, 'vehiculo' => 'Toyota Hilux (ABC-123)',    'fecha_inicio' => '2026-04-15 09:00', 'fecha_fin' => '2026-04-15 18:00', 'estado' => 'Rechazada'],
        ];

        $viajes = [
            ['id' => 1, 'vehiculo' => 'Toyota Hilux (ABC-123)',    'ruta' => 'San José - Heredia',  'fecha_salida' => '2026-04-20 08:00', 'fecha_regreso' => '2026-04-20 17:00', 'km_salida' => 15000, 'km_regreso' => 15025],
            ['id' => 2, 'vehiculo' => 'Nissan Frontier (JKL-012)', 'ruta' => 'San José - Alajuela', 'fecha_salida' => '2026-04-15 07:00', 'fecha_regreso' => '2026-04-15 14:00', 'km_salida' => 8500,  'km_regreso' => 8520],
        ];

        return view('chofer.historial', compact('solicitudes', 'viajes'));
    }
}