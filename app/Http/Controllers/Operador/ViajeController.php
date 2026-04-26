<?php

namespace App\Http\Controllers\Operador;

use App\Http\Controllers\Controller;
use App\Services\VehiculosApi;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class ViajeController extends Controller
{
    public function __construct(private VehiculosApi $api)
    {
    }

    public function index()
    {
        $viajes = collect($this->api->list('trips'))->map(fn ($trip) => $this->toView($trip))->all();

        return view('operador.viajes.index', compact('viajes'));
    }

    public function create()
    {
        return view('operador.viajes.create', [
            'choferes' => $this->drivers(),
            'rutas' => $this->routes(),
        ]);
    }

    public function vehiculosAprobados($id)
    {
        return response()->json([
            'data' => $this->approvedRequests($id),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'chofer_id' => 'required',
            'vehiculo_id' => 'required',
            'ruta_id' => 'nullable',
            'fecha_salida' => 'required|date',
            'fecha_llegada' => 'nullable|date|after_or_equal:fecha_salida',
            'km_salida' => 'required|integer|min:0',
            'km_llegada' => 'nullable|integer|gte:km_salida',
            'observaciones' => 'nullable|string|max:500',
        ]);

        $isArrivalPast = $request->filled('fecha_llegada')
            && Carbon::parse($request->fecha_llegada)->lessThanOrEqualTo(now());

        $response = $this->api->post('trips', [
            'user_id' => $request->chofer_id,
            'vehicle_id' => $request->vehiculo_id,
            'route_id' => $request->ruta_id,
            'start_date' => $request->fecha_salida,
            'end_date' => $request->fecha_llegada,
            'start_km' => $request->km_salida,
            'end_km' => $request->km_llegada,
            'observation' => $request->observaciones,
            'status' => $isArrivalPast && $request->filled('km_llegada') ? 2 : 1,
        ]);

        if ($response->failed()) {
            return back()->withInput()->with('error', $this->api->error($response));
        }

        return redirect()->route('operador.viajes.index')->with('success', 'Salida registrada correctamente.');
    }

    public function registrarRetorno(Request $request, $id)
    {
        $trip = $this->api->item("trips/{$id}");

        if (! $trip) {
            return back()->with('error', 'Viaje no encontrado.');
        }

        $request->validate([
            'fecha_regreso' => 'required|date',
            'km_regreso' => 'required|integer|min:0',
            'observaciones' => 'nullable|string|max:500',
        ]);

        if (Carbon::parse($request->fecha_regreso)->lt(Carbon::parse($trip['start_date']))) {
            return back()->withErrors([
                'fecha_regreso' => 'La fecha de regreso no puede ser menor a la fecha de salida del viaje.',
            ])->withInput();
        }

        if ($request->km_regreso < $request->km_salida_original) {
            return back()->withErrors(['km_regreso' => 'El kilometraje de regreso no puede ser menor al de salida.'])
                ->withInput();
        }

        $response = $this->api->patch("trips/{$id}", [
            'end_date' => $request->fecha_regreso,
            'start_km' => $request->km_salida_original,
            'end_km' => $request->km_regreso,
            'observation' => $request->observaciones,
            'status' => 2,
        ]);

        if ($response->failed()) {
            return back()->withInput()->with('error', $this->api->error($response));
        }

        return redirect()->route('operador.viajes.index')->with('success', 'Devolucion registrada correctamente.');
    }

    private function toView(array $trip): array
    {
        return [
            'id' => $trip['id'] ?? null,
            'chofer' => $trip['user']['name'] ?? '',
            'vehiculo' => isset($trip['vehicle']) ? $this->api->vehicleName($trip['vehicle']) : '',
            'ruta' => $trip['route']['name'] ?? 'Sin ruta',
            'fecha_salida_input' => $this->api->dateTimeForInput($trip['start_date'] ?? null),
            'fecha_salida' => $this->api->displayDateTime($trip['start_date'] ?? null),
            'fecha_regreso' => $this->api->displayDateTime($trip['end_date'] ?? null),
            'km_salida' => $trip['start_km'] ?? 0,
            'km_regreso' => $trip['end_km'] ?? null,
            'observaciones' => $trip['observation'] ?? null,
            'estado' => $this->api->tripStatusToView($trip['status'] ?? 1),
        ];
    }

    private function drivers(): array
    {
        return collect($this->api->list('users/drivers'))
            ->map(fn ($user) => ['id' => $user['id'], 'nombre' => $user['name']])
            ->all();
    }

    private function approvedRequests($driverId): array
    {
        return collect($this->api->list('requestVehicle', [
                'per_page' => 1000,
                'user_id' => $driverId,
                'status' => 1,
            ]))
            ->filter(fn ($requestVehicle) => (int) ($requestVehicle['request_status'] ?? $requestVehicle['status'] ?? 0) === 1)
            ->map(function ($requestVehicle) {
                return [
                    'solicitud_id' => $requestVehicle['request_number'] ?? $requestVehicle['id'] ?? null,
                    'chofer_id' => $requestVehicle['user_id'] ?? null,
                    'vehiculo_id' => $requestVehicle['vehicle_id'] ?? null,
                    'vehiculo' => trim(($requestVehicle['brand'] ?? '') . ' ' . ($requestVehicle['model'] ?? '') . ' (' . ($requestVehicle['plate'] ?? '') . ')'),
                    'kilometraje' => $requestVehicle['mileage'] ?? 0,
                    'fecha_inicio' => $requestVehicle['start_date'] ?? null,
                    'fecha_fin' => $requestVehicle['end_date'] ?? null,
                    'estado' => 'Aprobada',
                ];
            })
            ->all();
    }

    private function routes(): array
    {
        return collect($this->api->list('routes'))
            ->map(fn ($route) => [
                'id' => $route['id'],
                'nombre' => $route['name'],
                'distancia' => $route['estimated_distance'] ?? 0,
            ])
            ->all();
    }
}
