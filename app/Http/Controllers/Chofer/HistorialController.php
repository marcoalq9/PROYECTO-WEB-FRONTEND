<?php

namespace App\Http\Controllers\Chofer;

use App\Http\Controllers\Controller;
use App\Services\VehiculosApi;

class HistorialController extends Controller
{
    public function __construct(private VehiculosApi $api)
    {
    }

    public function index()
    {
        $solicitudes = collect($this->api->list('requestVehicle'))
            ->map(fn ($requestVehicle) => [
                'id' => $requestVehicle['id'] ?? $requestVehicle['request_number'] ?? null,
                'vehiculo' => trim(($requestVehicle['brand'] ?? '') . ' ' . ($requestVehicle['model'] ?? '') . ' (' . ($requestVehicle['plate'] ?? '') . ')'),
                'fecha_inicio' => $this->api->displayDateTime($requestVehicle['start_date'] ?? null),
                'fecha_fin' => $this->api->displayDateTime($requestVehicle['end_date'] ?? null),
                'estado' => $this->api->requestStatusToView($requestVehicle['status'] ?? 0),
            ])
            ->all();

        $viajes = collect($this->api->list('trips'))
            ->map(fn ($trip) => [
                'id' => $trip['id'] ?? null,
                'vehiculo' => isset($trip['vehicle']) ? $this->api->vehicleName($trip['vehicle']) : '',
                'ruta' => $trip['route']['name'] ?? 'Sin ruta',
                'fecha_salida' => $this->api->displayDateTime($trip['start_date'] ?? null),
                'fecha_regreso' => $this->api->displayDateTime($trip['end_date'] ?? null),
                'km_salida' => $trip['start_km'] ?? 0,
                'km_regreso' => $trip['end_km'] ?? null,
            ])
            ->all();

        return view('chofer.historial', compact('solicitudes', 'viajes'));
    }
}
