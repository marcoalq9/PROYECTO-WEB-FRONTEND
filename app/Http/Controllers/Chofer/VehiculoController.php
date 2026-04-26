<?php

namespace App\Http\Controllers\Chofer;

use App\Http\Controllers\Controller;
use App\Services\VehiculosApi;
use Illuminate\Http\Request;

class VehiculoController extends Controller
{
    public function __construct(private VehiculosApi $api)
    {
    }

    public function index(Request $request)
    {
        $vehiculos = collect($this->api->list('vehicles'))
            ->map(fn ($vehicle) => $this->toView($vehicle))
            ->all();
        $fecha_inicio = $this->api->dateTimeForInput($request->fecha_inicio);
        $fecha_fin = $this->api->dateTimeForInput($request->fecha_fin);

        return view('chofer.vehiculos.index', compact('vehiculos', 'fecha_inicio', 'fecha_fin'));
    }

    public function show($id)
    {
        $vehicle = $this->api->item("vehicles/{$id}");

        if (! $vehicle) {
            return redirect()->route('chofer.vehiculos.index')->with('error', 'Vehiculo no encontrado.');
        }

        $vehiculo = $this->toView($vehicle);

        return view('chofer.vehiculos.show', compact('vehiculo'));
    }

    private function toView(array $vehicle): array
    {
        return [
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
        ];
    }
}
