<?php

namespace App\Http\Controllers\Operador;

use App\Http\Controllers\Controller;
use App\Services\VehiculosApi;
use Illuminate\Http\Request;

class RutaController extends Controller
{
    public function __construct(private VehiculosApi $api)
    {
    }

    public function index()
    {
        $rutas = collect($this->api->list('routes'))->map(fn ($route) => $this->toView($route))->all();

        return view('operador.rutas.index', compact('rutas'));
    }

    public function create()
    {
        return view('operador.rutas.create');
    }

    public function store(Request $request)
    {
        $request->validate($this->rules());

        $response = $this->api->post('routes', $this->toApi($request));

        if ($response->failed()) {
            return back()->withInput()->with('error', $this->api->error($response));
        }

        return redirect()->route('operador.rutas.index')->with('success', 'Ruta creada correctamente.');
    }

    public function edit($id)
    {
        $route = $this->api->item("routes/{$id}");

        if (! $route) {
            return redirect()->route('operador.rutas.index')->with('error', 'Ruta no encontrada.');
        }

        $ruta = $this->toView($route);

        return view('operador.rutas.edit', compact('ruta'));
    }

    public function update(Request $request, $id)
    {
        $request->validate($this->rules());

        $response = $this->api->put("routes/{$id}", $this->toApi($request));

        if ($response->failed()) {
            return back()->withInput()->with('error', $this->api->error($response));
        }

        return redirect()->route('operador.rutas.index')->with('success', 'Ruta actualizada correctamente.');
    }

    public function destroy($id)
    {
        $response = $this->api->delete("routes/{$id}");

        if ($response->failed()) {
            return back()->with('error', $this->api->error($response));
        }

        return redirect()->route('operador.rutas.index')->with('success', 'Ruta eliminada correctamente.');
    }

    private function rules(): array
    {
        return [
            'nombre' => 'required|string|max:100',
            'inicio' => 'required|string|max:100',
            'fin' => 'required|string|max:100',
            'distancia' => 'nullable|numeric|min:0',
            'descripcion' => 'nullable|string|max:500',
        ];
    }

    private function toApi(Request $request): array
    {
        return [
            'name' => $request->nombre,
            'start_point' => $request->inicio,
            'end_point' => $request->fin,
            'estimated_distance' => $request->distancia,
            'description' => $request->descripcion,
        ];
    }

    private function toView(array $route): array
    {
        return [
            'id' => $route['id'] ?? null,
            'nombre' => $route['name'] ?? '',
            'inicio' => $route['start_point'] ?? '',
            'fin' => $route['end_point'] ?? '',
            'distancia' => $route['estimated_distance'] ?? null,
            'descripcion' => $route['description'] ?? '',
        ];
    }
}
