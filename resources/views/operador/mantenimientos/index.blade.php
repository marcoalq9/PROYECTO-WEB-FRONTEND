@extends('layouts.dashboard')

@section('title', 'Mantenimientos')
@section('page_title', 'Gestión de Mantenimientos')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-tools me-1"></i> Lista de Mantenimientos</h3>
        <div class="card-tools">
          <a href="{{ route('operador.mantenimientos.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Nuevo Mantenimiento
          </a>
        </div>
      </div>
      <div class="card-body table-responsive p-0">
        <table class="table table-hover table-striped text-nowrap">
          <thead>
            <tr>
              <th>#</th>
              <th>Vehículo</th>
              <th>Tipo</th>
              <th>Fecha Inicio</th>
              <th>Fecha Cierre</th>
              <th>Descripción</th>
              <th>Costo</th>
              <th>Estado</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @forelse($mantenimientos as $mantenimiento)
            <tr>
              <td>{{ $mantenimiento['id'] }}</td>
              <td>{{ $mantenimiento['vehiculo'] }}</td>
              <td>
                <span class="badge bg-{{ $mantenimiento['tipo'] === 'Preventivo' ? 'info' : 'warning' }}">
                  {{ $mantenimiento['tipo'] }}
                </span>
              </td>
              <td>{{ $mantenimiento['fecha_inicio'] }}</td>
              <td>{{ $mantenimiento['fecha_cierre'] ?? 'En curso' }}</td>
              <td>{{ Str::limit($mantenimiento['descripcion'], 40) }}</td>
              <td>{{ $mantenimiento['costo'] ? '₡' . number_format($mantenimiento['costo'], 0) : 'N/A' }}</td>
              <td>
                <span class="badge bg-{{ $mantenimiento['estado'] === 'Abierto' ? 'danger' : 'success' }}">
                  {{ $mantenimiento['estado'] }}
                </span>
              </td>
              <td>
                @if($mantenimiento['estado'] === 'Abierto')
                  <form action="{{ route('operador.mantenimientos.cerrar', $mantenimiento['id']) }}"
                        method="POST" class="d-inline-block me-1 mb-1"
                        onsubmit="return confirm('¿Cerrar este mantenimiento? El vehículo quedará disponible.')">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-success btn-action">
                      <i class="fas fa-check me-1"></i> Cerrar
                    </button>
                  </form>
                @endif
                <a href="{{ route('operador.mantenimientos.edit', $mantenimiento['id']) }}"
                   class="btn btn-warning btn-action me-1 mb-1">
                  <i class="fas fa-edit me-1"></i> Editar
                </a>
                <form action="{{ route('operador.mantenimientos.destroy', $mantenimiento['id']) }}"
                      method="POST" class="d-inline-block mb-1"
                      onsubmit="return confirm('¿Eliminar este mantenimiento?')">
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
              <td colspan="9" class="text-center">No hay mantenimientos registrados.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
