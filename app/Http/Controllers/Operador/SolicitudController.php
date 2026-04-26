<?php

namespace App\Http\Controllers\Operador;

use App\Http\Controllers\Controller;
use App\Services\VehiculosApi;
use Illuminate\Http\Request;

class SolicitudController extends Controller
{
    public function __construct(private VehiculosApi $api)
    {
    }

    public function index()
    {
        $solicitudes = collect($this->api->list('requestVehicle'))
            ->map(fn ($requestVehicle) => $this->toView($requestVehicle))
            ->all();

        return view('operador.solicitudes.index', compact('solicitudes'));
    }

    public function show($id)
    {
        $requestVehicle = $this->api->item("requestVehicle/{$id}");

        if (! $requestVehicle) {
            return redirect()->route('operador.solicitudes.index')->with('error', 'Solicitud no encontrada.');
        }

        $solicitud = $this->toView($requestVehicle);

        return view('operador.solicitudes.show', compact('solicitud'));
    }

    public function aprobar($id)
    {
        return $this->changeStatus($id, 1, 'Solicitud aprobada correctamente.');
    }

    public function rechazar(Request $request, $id)
    {
        return $this->changeStatus($id, 2, 'Solicitud rechazada correctamente.');
    }

    private function changeStatus($id, int $status, string $message)
    {
        $response = $this->api->patch("requestVehicle/{$id}", ['status' => $status]);

        if ($response->failed()) {
            return back()->with('error', $this->api->error($response));
        }

        return redirect()->route('operador.solicitudes.index')->with('success', $message);
    }

    private function toView(array $requestVehicle): array
    {
        $vehicle = $requestVehicle['vehicle'] ?? $requestVehicle;

        return [
            'id' => $requestVehicle['id'] ?? $requestVehicle['request_number'] ?? null,
            'chofer' => $requestVehicle['driver_name'] ?? $requestVehicle['user']['name'] ?? '',
            'vehiculo' => isset($requestVehicle['vehicle'])
                ? $this->api->vehicleName($requestVehicle['vehicle'])
                : trim(($vehicle['brand'] ?? '') . ' ' . ($vehicle['model'] ?? '') . ' (' . ($vehicle['plate'] ?? '') . ')'),
            'fecha_inicio' => $this->api->displayDateTime($requestVehicle['start_date'] ?? null),
            'fecha_fin' => $this->api->displayDateTime($requestVehicle['end_date'] ?? null),
            'motivo' => $requestVehicle['observation'] ?? '',
            'estado' => $this->api->requestStatusToView($requestVehicle['status'] ?? 0),
            'aprobado_por' => $requestVehicle['approved_by'] ?? $requestVehicle['approver']['name'] ?? null,
        ];
    }
}
