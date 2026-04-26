<?php

namespace App\Http\Controllers\Chofer;

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

        return view('chofer.solicitudes.index', compact('solicitudes'));
    }

    public function create(Request $request)
    {
        $vehiculos = collect($this->api->list('vehicles'))
            ->filter(fn ($vehicle) => in_array((int) ($vehicle['status'] ?? 0), [1, 2], true))
            ->map(fn ($vehicle) => ['id' => $vehicle['id'], 'nombre' => $this->api->vehicleName($vehicle)])
            ->all();
        $vehiculo_id = $request->vehiculo_id;
        $fecha_inicio = $this->api->dateTimeForInput($request->fecha_inicio);
        $fecha_fin = $this->api->dateTimeForInput($request->fecha_fin);

        return view('chofer.solicitudes.create', compact('vehiculos', 'vehiculo_id', 'fecha_inicio', 'fecha_fin'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'vehiculo_id' => 'required',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'motivo' => 'nullable|string|max:255',
        ]);

        $response = $this->api->post('requestVehicle', [
            'user_id' => session('user_id'),
            'vehicle_id' => $request->vehiculo_id,
            'start_date' => $request->fecha_inicio,
            'end_date' => $request->fecha_fin,
            'observation' => $request->motivo,
            'assigned_by' => session('user_id'),
        ]);

        if ($response->failed()) {
            return back()->withInput()->with('error', $this->api->error($response));
        }

        return redirect()->route('chofer.solicitudes.index')
            ->with('success', 'Solicitud enviada correctamente. Queda pendiente de aprobacion.');
    }

    public function cancelar($id)
    {
        $response = $this->api->patch("requestVehicle/{$id}", ['status' => 4]);

        if ($response->failed()) {
            return back()->with('error', $this->api->error($response));
        }

        return redirect()->route('chofer.solicitudes.index')->with('success', 'Solicitud cancelada correctamente.');
    }

    private function toView(array $requestVehicle): array
    {
        $vehicle = $requestVehicle['vehicle'] ?? $requestVehicle;

        return [
            'id' => $requestVehicle['id'] ?? $requestVehicle['request_number'] ?? null,
            'vehiculo' => isset($requestVehicle['vehicle'])
                ? $this->api->vehicleName($requestVehicle['vehicle'])
                : trim(($vehicle['brand'] ?? '') . ' ' . ($vehicle['model'] ?? '') . ' (' . ($vehicle['plate'] ?? '') . ')'),
            'fecha_inicio' => $this->api->displayDateTime($requestVehicle['start_date'] ?? null),
            'fecha_fin' => $this->api->displayDateTime($requestVehicle['end_date'] ?? null),
            'motivo' => $requestVehicle['observation'] ?? '',
            'estado' => $this->api->requestStatusToView($requestVehicle['status'] ?? 0),
        ];
    }
}
