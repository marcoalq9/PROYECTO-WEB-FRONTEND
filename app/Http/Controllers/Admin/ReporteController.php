<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\VehiculosApi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReporteController extends Controller
{
    public function __construct(private VehiculosApi $api)
    {
    }

    public function disponibilidad(Request $request)
    {
        $fecha_inicio = $this->api->dateTimeForInput($request->fecha_inicio);
        $fecha_fin = $this->api->dateTimeForInput($request->fecha_fin);
        $vehiculos = [];

        if ($fecha_inicio && $fecha_fin) {
            $vehiculos = collect($this->api->list('vehicles/availability-report', [
                'start_date' => $this->toApiDateTime($fecha_inicio),
                'end_date' => $this->toApiDateTime($fecha_fin),
            ]))->map(fn ($vehicle) => [
                'id' => $vehicle['id'] ?? null,
                'placa' => $vehicle['plate'] ?? '',
                'marca' => $vehicle['brand'] ?? '',
                'modelo' => $vehicle['model'] ?? '',
                'anio' => $vehicle['year'] ?? '',
                'tipo' => $vehicle['type'] ?? '',
                'capacidad' => $vehicle['capacity'] ?? '',
                'combustible' => $vehicle['fuel'] ?? '',
                'estado' => $this->api->vehicleStatusToView($vehicle['status'] ?? 1),
                'imagen' => $this->api->vehicleImageUrl($vehicle),
                'solicitudes' => count($vehicle['requests_v'] ?? $vehicle['requests_vehicle'] ?? []),
            ])->all();
        }

        return view('admin.reportes.disponibilidad', compact('vehiculos', 'fecha_inicio', 'fecha_fin'));
    }

    private function toApiDateTime(?string $value): ?string
    {
        if (! $value) {
            return null;
        }

        return Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    public function uso(Request $request)
    {
        $fecha_inicio = $this->api->dateForInput($request->fecha_inicio);
        $fecha_fin = $this->api->dateForInput($request->fecha_fin);
        $datos = [];

        if ($fecha_inicio && $fecha_fin) {
            $datos = collect($this->api->list('trips/fleet-usage', [
                'start_date' => $fecha_inicio,
                'end_date' => $fecha_fin,
            ]))->map(fn ($item) => [
                'vehiculo' => isset($item['vehicle']) ? $this->api->vehicleName($item['vehicle']) : '',
                'total_viajes' => $item['total_trips'] ?? 0,
                'km_recorridos' => $item['total_km'] ?? 0,
                'ultima_salida' => '',
            ])->all();
        }

        $total_viajes = array_sum(array_column($datos, 'total_viajes'));
        $total_km = array_sum(array_column($datos, 'km_recorridos'));

        return view('admin.reportes.uso', compact('datos', 'fecha_inicio', 'fecha_fin', 'total_viajes', 'total_km'));
    }

    public function historialChofer(Request $request)
    {
        $chofer_id = $request->chofer_id;
        $fecha_inicio = $this->api->dateForInput($request->fecha_inicio);
        $fecha_fin = $this->api->dateForInput($request->fecha_fin);

        $choferes = collect($this->api->list('users/drivers'))
            ->map(fn ($user) => ['id' => $user['id'], 'nombre' => $user['name']])
            ->all();

        $solicitudes = [];
        $viajes = [];

        if ($chofer_id) {
            $selectedDriver = collect($choferes)->firstWhere('id', (int) $chofer_id);
            $selectedDriverName = $selectedDriver['nombre'] ?? null;

            $solicitudes = collect($this->api->list('requestVehicle'))
                ->filter(fn ($item) => ! $selectedDriverName || empty($item['driver_name']) || (string) $item['driver_name'] === $selectedDriverName)
                ->map(fn ($item) => [
                    'id' => $item['id'] ?? $item['request_number'] ?? null,
                    'vehiculo' => trim(($item['brand'] ?? '') . ' ' . ($item['model'] ?? '') . ' (' . ($item['plate'] ?? '') . ')'),
                    'fecha_inicio' => $this->api->displayDateTime($item['start_date'] ?? null),
                    'fecha_fin' => $this->api->displayDateTime($item['end_date'] ?? null),
                    'estado' => $this->api->requestStatusToView($item['status'] ?? 0),
                ])
                ->all();

            $viajes = collect($this->api->list('trips'))
                ->filter(fn ($trip) => (int) ($trip['user_id'] ?? 0) === (int) $chofer_id)
                ->map(fn ($trip) => [
                    'id' => $trip['id'] ?? null,
                    'vehiculo' => isset($trip['vehicle']) ? $this->api->vehicleName($trip['vehicle']) : '',
                    'ruta' => $trip['route']['name'] ?? 'Sin ruta',
                    'fecha_salida' => $this->api->displayDateTime($trip['start_date'] ?? null),
                    'fecha_regreso' => $this->api->displayDateTime($trip['end_date'] ?? null),
                    'km_recorridos' => max(0, (int) ($trip['end_km'] ?? 0) - (int) ($trip['start_km'] ?? 0)),
                ])
                ->all();
        }

        return view('admin.reportes.historial-chofer', compact('choferes', 'chofer_id', 'solicitudes', 'viajes', 'fecha_inicio', 'fecha_fin'));
    }
}
