<?php

namespace App\Http\Controllers\Operador;

use App\Http\Controllers\Controller;
use App\Services\VehiculosApi;
use Illuminate\Http\Request;

class MantenimientoController extends Controller
{
    public function __construct(private VehiculosApi $api)
    {
    }

    public function index()
    {
        $mantenimientos = collect($this->api->list('maintenance'))
            ->map(fn ($maintenance) => $this->toView($maintenance))
            ->all();

        return view('operador.mantenimientos.index', compact('mantenimientos'));
    }

    public function create()
    {
        return view('operador.mantenimientos.create', [
            'vehiculos' => $this->vehicleOptions(),
            'tipos' => ['Preventivo', 'Correctivo'],
        ]);
    }

    public function store(Request $request)
    {
        $request->validate($this->rules());

        $response = $this->api->post('maintenance', $this->toApi($request));

        if ($response->failed()) {
            return back()->withInput()->with('error', $this->api->error($response));
        }

        return redirect()->route('operador.mantenimientos.index')->with('success', 'Mantenimiento registrado.');
    }

    public function edit($id)
    {
        $maintenance = $this->api->item("maintenance/{$id}");

        if (! $maintenance) {
            return redirect()->route('operador.mantenimientos.index')->with('error', 'Mantenimiento no encontrado.');
        }

        return view('operador.mantenimientos.edit', [
            'mantenimiento' => $this->toView($maintenance),
            'vehiculos' => $this->vehicleOptions(),
            'tipos' => ['Preventivo', 'Correctivo'],
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate($this->rules());

        $response = $this->api->put("maintenance/{$id}", $this->toApi($request));

        if ($response->failed()) {
            return back()->withInput()->with('error', $this->api->error($response));
        }

        return redirect()->route('operador.mantenimientos.index')->with('success', 'Mantenimiento actualizado correctamente.');
    }

    public function cerrar($id)
    {
        $response = $this->api->patch("maintenance/{$id}", [
            'status' => 0,
            'end_date' => now()->toDateString(),
        ]);

        if ($response->failed()) {
            return back()->with('error', $this->api->error($response));
        }

        return redirect()->route('operador.mantenimientos.index')->with('success', 'Mantenimiento cerrado.');
    }

    public function destroy($id)
    {
        $response = $this->api->delete("maintenance/{$id}");

        if ($response->failed()) {
            return back()->with('error', $this->api->error($response));
        }

        return redirect()->route('operador.mantenimientos.index')->with('success', 'Mantenimiento eliminado correctamente.');
    }

    private function rules(): array
    {
        return [
            'vehiculo_id' => 'required',
            'tipo' => 'required|string',
            'fecha_inicio' => 'required|date',
            'fecha_cierre' => 'nullable|date|after_or_equal:fecha_inicio',
            'descripcion' => 'required|string|max:500',
            'costo' => 'nullable|numeric|min:0',
        ];
    }

    private function toApi(Request $request): array
    {
        return [
            'vehicle_id' => $request->vehiculo_id,
            'tipo' => strtolower($request->tipo),
            'start_date' => $request->fecha_inicio,
            'end_date' => $request->fecha_cierre,
            'description' => $request->descripcion,
            'cost' => $request->costo,
            'status' => 1,
        ];
    }

    private function toView(array $maintenance): array
    {
        return [
            'id' => $maintenance['id'] ?? null,
            'vehiculo_id' => $maintenance['vehicle_id'] ?? null,
            'vehiculo' => isset($maintenance['vehicle']) ? $this->api->vehicleName($maintenance['vehicle']) : '',
            'tipo' => ucfirst($maintenance['tipo'] ?? ''),
            'fecha_inicio' => $this->api->dateForInput($maintenance['start_date'] ?? null),
            'fecha_cierre' => $this->api->dateForInput($maintenance['end_date'] ?? null),
            'descripcion' => $maintenance['description'] ?? '',
            'costo' => $maintenance['cost'] ?? null,
            'estado' => $this->api->maintenanceStatusToView($maintenance['status'] ?? 1),
        ];
    }

    private function vehicleOptions(): array
    {
        return collect($this->api->list('vehicles'))
            ->map(fn ($vehicle) => ['id' => $vehicle['id'], 'nombre' => $this->api->vehicleName($vehicle)])
            ->all();
    }
}
