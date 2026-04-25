<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    // Reporte 1: Disponibilidad de vehículos por rango de fecha/hora
    public function disponibilidad(Request $request)
    {
        $fecha_inicio = $request->fecha_inicio;
        $fecha_fin    = $request->fecha_fin;

        // TODO: reemplazar con llamada al API
        $vehiculos = [];
        if ($fecha_inicio && $fecha_fin) {
            $vehiculos = [
                ['id' => 1, 'placa' => 'ABC-123', 'marca' => 'Toyota',  'modelo' => 'Hilux',    'anio' => 2022, 'tipo' => 'Pick-up', 'capacidad' => 5, 'combustible' => 'Diesel',  'estado' => 'Disponible', 'imagen' => null],
                ['id' => 4, 'placa' => 'JKL-012', 'marca' => 'Nissan',  'modelo' => 'Frontier', 'anio' => 2020, 'tipo' => 'Pick-up', 'capacidad' => 5, 'combustible' => 'Diesel',  'estado' => 'Disponible', 'imagen' => null],
            ];
        }

        return view('admin.reportes.disponibilidad', compact('vehiculos', 'fecha_inicio', 'fecha_fin'));
    }

    // Reporte 2: Uso de flotilla por periodo
    public function uso(Request $request)
    {
        $fecha_inicio = $request->fecha_inicio;
        $fecha_fin    = $request->fecha_fin;

        // TODO: reemplazar con llamada al API
        $datos = [];
        if ($fecha_inicio && $fecha_fin) {
            $datos = [
                ['vehiculo' => 'Toyota Hilux (ABC-123)',    'total_viajes' => 5, 'km_recorridos' => 320, 'ultima_salida' => '2026-04-20'],
                ['vehiculo' => 'Hyundai Tucson (DEF-456)',  'total_viajes' => 3, 'km_recorridos' => 180, 'ultima_salida' => '2026-04-18'],
                ['vehiculo' => 'Nissan Frontier (JKL-012)', 'total_viajes' => 7, 'km_recorridos' => 450, 'ultima_salida' => '2026-04-22'],
            ];
        }

        $total_viajes = array_sum(array_column($datos, 'total_viajes'));
        $total_km     = array_sum(array_column($datos, 'km_recorridos'));

        return view('admin.reportes.uso', compact('datos', 'fecha_inicio', 'fecha_fin', 'total_viajes', 'total_km'));
    }

    // Reporte 3: Historial del chofer
    public function historialChofer(Request $request)
    {
        $chofer_id    = $request->chofer_id;
        $fecha_inicio = $request->fecha_inicio;
        $fecha_fin    = $request->fecha_fin;

        // TODO: reemplazar con llamada al API
        $choferes = [
            ['id' => 1, 'nombre' => 'Juan Pérez'],
            ['id' => 2, 'nombre' => 'María López'],
            ['id' => 3, 'nombre' => 'Carlos Mora'],
        ];

        $solicitudes = [];
        $viajes      = [];

        if ($chofer_id) {
            $solicitudes = [
                ['id' => 1, 'vehiculo' => 'Toyota Hilux (ABC-123)',    'fecha_inicio' => '2026-04-25 08:00', 'fecha_fin' => '2026-04-25 17:00', 'estado' => 'Aprobada'],
                ['id' => 2, 'vehiculo' => 'Nissan Frontier (JKL-012)', 'fecha_inicio' => '2026-04-20 07:00', 'fecha_fin' => '2026-04-20 15:00', 'estado' => 'Cancelada'],
            ];
            $viajes = [
                ['id' => 1, 'vehiculo' => 'Toyota Hilux (ABC-123)',    'ruta' => 'San José - Heredia',  'fecha_salida' => '2026-04-20 08:00', 'fecha_regreso' => '2026-04-20 17:00', 'km_recorridos' => 25],
                ['id' => 2, 'vehiculo' => 'Nissan Frontier (JKL-012)', 'ruta' => 'San José - Alajuela', 'fecha_salida' => '2026-04-15 07:00', 'fecha_regreso' => '2026-04-15 14:00', 'km_recorridos' => 40],
            ];
        }

        return view('admin.reportes.historial-chofer', compact('choferes', 'chofer_id', 'solicitudes', 'viajes', 'fecha_inicio', 'fecha_fin'));
    }
}