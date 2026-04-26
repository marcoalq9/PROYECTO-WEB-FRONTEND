@extends('layouts.dashboard')

@section('title', 'Mantenimientos')
@section('page_title', 'Gestion de Mantenimientos')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-tools me-1"></i> Lista de Mantenimientos</h3>
        <div class="card-tools">
          <a href="{{ route('admin.mantenimientos.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Nuevo Mantenimiento
          </a>
        </div>
      </div>
      <div class="card-body border-bottom">
        <form method="GET" action="{{ route('admin.mantenimientos.index') }}" class="row g-2 align-items-end">
          <div class="col-md-4">
            <label for="estado" class="form-label">Filtrar por Estado</label>
            <select id="estado" name="estado" class="form-select">
              @foreach($estados as $opcion)
                <option value="{{ $opcion }}" {{ $estado === $opcion ? 'selected' : '' }}>
                  {{ $opcion }}
                </option>
              @endforeach
            </select>
          </div>
          <div class="col-md-2">
            <button type="submit" class="btn btn-secondary w-100">
              <i class="fas fa-filter me-1"></i> Filtrar
            </button>
          </div>
        </form>
      </div>
      <div class="card-body table-responsive p-0">
        <table class="table table-hover table-striped text-nowrap">
          <thead>
            <tr>
              <th>#</th>
              <th>Vehiculo</th>
              <th>Kilometraje</th>
              <th>Tipo</th>
              <th>Fecha Inicio</th>
              <th>Fecha Cierre</th>
              <th>Descripcion</th>
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
              <td>{{ $mantenimiento['kilometraje'] !== null ? number_format($mantenimiento['kilometraje']) . ' km' : 'N/A' }}</td>
              <td>
                <span class="badge bg-{{ $mantenimiento['tipo'] === 'Preventivo' ? 'info' : 'warning' }}">
                  {{ $mantenimiento['tipo'] }}
                </span>
              </td>
              <td>{{ $mantenimiento['fecha_inicio'] }}</td>
              <td>{{ $mantenimiento['fecha_cierre'] ?? 'En curso' }}</td>
              <td>{{ Str::limit($mantenimiento['descripcion'], 40) }}</td>
              <td>{{ $mantenimiento['costo'] ? 'CRC ' . number_format($mantenimiento['costo'], 0) : 'N/A' }}</td>
              <td>
                @php
                  $estadoClase = match ($mantenimiento['estado']) {
                    'Abierto' => 'danger',
                    'Inactivo' => 'secondary',
                    default => 'success',
                  };
                @endphp
                <span class="badge bg-{{ $estadoClase }}">
                  {{ $mantenimiento['estado'] }}
                </span>
              </td>
              <td>
                @if($mantenimiento['estado'] === 'Inactivo')
                  <form action="{{ route('admin.mantenimientos.restore', $mantenimiento['id']) }}"
                        method="POST" class="d-inline-block mb-1"
                        onsubmit="return confirm('Deseas activar este mantenimiento?')">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-success btn-action">
                      <i class="fas fa-check me-1"></i> Activar
                    </button>
                  </form>
                @else
                  @if($mantenimiento['estado'] === 'Abierto')
                    <form action="{{ route('admin.mantenimientos.cerrar', $mantenimiento['id']) }}"
                          method="POST" class="d-inline-block me-1 mb-1"
                          onsubmit="return confirm('Cerrar este mantenimiento? El vehiculo quedara disponible.')">
                      @csrf
                      @method('PATCH')
                      <button type="submit" class="btn btn-success btn-action">
                        <i class="fas fa-check me-1"></i> Cerrar
                      </button>
                    </form>
                  @endif
                  <a href="{{ route('admin.mantenimientos.edit', $mantenimiento['id']) }}"
                     class="btn btn-warning btn-action me-1 mb-1">
                    <i class="fas fa-edit me-1"></i> Editar
                  </a>
                  <form action="{{ route('admin.mantenimientos.destroy', $mantenimiento['id']) }}"
                        method="POST" class="d-inline-block mb-1"
                        onsubmit="return confirm('Eliminar este mantenimiento?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-action">
                      <i class="fas fa-trash me-1"></i> Eliminar
                    </button>
                  </form>
                @endif
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="10" class="text-center">No hay mantenimientos registrados.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
