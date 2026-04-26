<?php

namespace App\Http\Controllers\Operador;

use App\Http\Controllers\Controller;
use App\Services\VehiculosApi;
use Illuminate\Http\Request;

class AsignacionDirectaController extends Controller
{
    public function __construct(private VehiculosApi $api)
    {
    }

    public function create()
    {
        $choferes = collect($this->api->list('users/drivers'))
            ->map(fn ($user) => ['id' => $user['id'], 'nombre' => $user['name']])
            ->all();

        $vehiculos = collect($this->api->list('vehicles'))
            ->filter(fn ($vehicle) => in_array((int) ($vehicle['status'] ?? 0), [1, 2], true))
            ->map(fn ($vehicle) => ['id' => $vehicle['id'], 'nombre' => $this->api->vehicleName($vehicle)])
            ->all();

        return view('operador.asignacion-directa.create', compact('choferes', 'vehiculos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'chofer_id' => 'required',
            'vehiculo_id' => 'required',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'motivo' => 'nullable|string|max:255',
        ]);

        $response = $this->api->post('requestVehicle', [
            'user_id' => $request->chofer_id,
            'vehicle_id' => $request->vehiculo_id,
            'start_date' => $request->fecha_inicio,
            'end_date' => $request->fecha_fin,
            'observation' => $request->motivo,
            'assigned_by' => session('user_id'),
        ]);

        if ($response->failed()) {
            return back()->withInput()->with('error', $this->api->error($response));
        }

        return redirect()->route('operador.solicitudes.index')->with('success', 'Asignacion directa creada correctamente.');
    }
}
