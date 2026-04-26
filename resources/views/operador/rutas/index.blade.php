@extends('layouts.dashboard')

@section('title', 'Rutas')
@section('page_title', 'Gestión de Rutas')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-map-marked-alt me-1"></i> Lista de Rutas</h3>
        <div class="card-tools">
          <a href="{{ route('operador.rutas.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Nueva Ruta
          </a>
        </div>
      </div>
      <div class="card-body table-responsive p-0">
        <table class="table table-hover table-striped text-nowrap">
          <thead>
            <tr>
              <th>#</th>
              <th>Nombre</th>
              <th>Punto de Inicio</th>
              <th>Punto Final</th>
              <th>Distancia</th>
              <th>Descripción</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @forelse($rutas as $ruta)
            <tr>
              <td>{{ $ruta['id'] }}</td>
              <td><strong>{{ $ruta['nombre'] }}</strong></td>
              <td><i class="fas fa-map-pin text-success me-1"></i>{{ $ruta['inicio'] }}</td>
              <td><i class="fas fa-map-pin text-danger me-1"></i>{{ $ruta['fin'] }}</td>
              <td>{{ $ruta['distancia'] ? $ruta['distancia'] . ' km' : 'N/A' }}</td>
              <td>{{ Str::limit($ruta['descripcion'] ?? '', 40) }}</td>
              <td>
                <a href="{{ route('operador.rutas.edit', $ruta['id']) }}"
                   class="btn btn-warning btn-action me-1 mb-1">
                  <i class="fas fa-edit me-1"></i> Editar
                </a>
                <form action="{{ route('operador.rutas.destroy', $ruta['id']) }}"
                      method="POST" class="d-inline-block mb-1"
                      onsubmit="return confirm('¿Eliminar esta ruta?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-action">
                    <i class="fas fa-trash me-1"></i> Eliminar
                  </button>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="7" class="text-center">No hay rutas registradas.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
