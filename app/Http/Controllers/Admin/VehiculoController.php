<?php

namespace App\Http\Controllers\Admin;

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
        $estado = $request->input('estado');
        $endpoint = $estado === 'Inactivo' ? 'vehicles/inactive' : 'vehicles';

        $vehiculos = collect($this->api->list($endpoint))
            ->map(fn ($vehicle) => $this->toView($vehicle))
            ->when($estado && $estado !== 'Inactivo', fn ($items) => $items->where('estado', $estado))
            ->values()
            ->all();
        $estados = ['Disponible', 'Asignado', 'Mantenimiento', 'Fuera de servicio', 'Inactivo'];

        return view('admin.vehiculos.index', compact('vehiculos', 'estados'));
    }

    public function create()
    {
        return view('admin.vehiculos.create', $this->formOptions());
    }

    public function store(Request $request)
    {
        $request->validate([
            'placa' => 'required|string|max:20',
            'marca' => 'required|string|max:50',
            'modelo' => 'required|string|max:50',
            'anio' => 'required|integer|min:1900|max:' . date('Y'),
            'tipo' => 'required|string',
            'capacidad' => 'required|integer|min:1',
            'combustible' => 'required|string',
            'estado' => 'required|string',
            'kilometraje' => 'required|integer|min:0',
            'imagen' => 'nullable|image|max:2048',
        ]);

        $response = $this->api->postWithFile('vehicles', $this->toApi($request), 'image', $request->file('imagen'));

        if ($response->failed()) {
            return back()->withInput()->with('error', $this->api->error($response));
        }

        return redirect()->route('admin.vehiculos.index')->with('success', 'Vehiculo registrado correctamente.');
    }

    public function edit($id)
    {
        $vehicle = $this->api->item("vehicles/{$id}");

        if (! $vehicle) {
            return redirect()->route('admin.vehiculos.index')->with('error', 'Vehiculo no encontrado.');
        }

        return view('admin.vehiculos.edit', array_merge(
            ['vehiculo' => $this->toView($vehicle)],
            $this->formOptions(true)
        ));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'placa' => 'required|string|max:20',
            'marca' => 'required|string|max:50',
            'modelo' => 'required|string|max:50',
            'anio' => 'required|integer|min:1900|max:' . date('Y'),
            'tipo' => 'required|string',
            'capacidad' => 'required|integer|min:1',
            'combustible' => 'required|string',
            'estado' => 'required|string',
            'imagen' => 'nullable|image|max:2048',
        ]);

        $response = $this->api->putWithFile("vehicles/{$id}", $this->toApi($request), 'image', $request->file('imagen'));

        if ($response->failed()) {
            return back()->withInput()->with('error', $this->api->error($response));
        }

        return redirect()->route('admin.vehiculos.index')->with('success', 'Vehiculo actualizado correctamente.');
    }

    public function destroy($id)
    {
        $response = $this->api->delete("vehicles/{$id}");

        if ($response->failed()) {
            return back()->with('error', $this->api->error($response));
        }

        return redirect()->route('admin.vehiculos.index')->with('success', 'Vehiculo eliminado correctamente.');
    }

    public function restore($id)
    {
        $response = $this->api->patch("vehicles/{$id}/restore");

        if ($response->failed()) {
            return back()->with('error', $this->api->error($response));
        }

        return redirect()
            ->route('admin.vehiculos.index', ['estado' => 'Inactivo'])
            ->with('success', 'Vehiculo activado correctamente.');
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
            'estado' => empty($vehicle['deleted_at'])
                ? $this->api->vehicleStatusToView($vehicle['status'] ?? 1)
                : 'Inactivo',
            'imagen' => $this->api->vehicleImageUrl($vehicle),
            'kilometraje' => $vehicle['mileage'] ?? 0,
        ];
    }

    private function toApi(Request $request): array
    {
        return [
            'plate' => $request->placa,
            'brand' => $request->marca,
            'model' => $request->modelo,
            'year' => $request->anio,
            'type' => $request->tipo,
            'capacity' => $request->capacidad,
            'fuel' => $request->combustible,
            'status' => $this->api->vehicleStatusToApi($request->estado),
            'mileage' => $request->input('kilometraje', 0),
        ];
    }

    private function formOptions(bool $includeAllStatuses = false): array
    {
        return [
            'tipos' => ['Sedan', 'SUV', 'Pick-up', 'Van', 'Microbus', 'Camion'],
            'combustibles' => ['Gasolina', 'Diesel', 'Hibrido', 'Electrico'],
            'estados' => $includeAllStatuses
                ? ['Disponible', 'Asignado', 'Mantenimiento', 'Fuera de servicio']
                : ['Disponible', 'Fuera de servicio'],
        ];
    }
}
