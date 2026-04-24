@extends('layouts.dashboard')

@section('title', 'Vehículos')
@section('page_title', 'Gestión de Vehículos')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-car me-1"></i> Lista de Vehículos</h3>
        <div class="card-tools">
          <a href="{{ route('admin.vehiculos.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Nuevo Vehículo
          </a>
        </div>
      </div>

      {{-- Filtro por estado --}}
      <div class="card-body border-bottom">
        <form method="GET" action="{{ route('admin.vehiculos.index') }}" class="row g-2 align-items-end">
          <div class="col-md-4">
            <label class="form-label">Filtrar por Estado</label>
            <select name="estado" class="form-select form-select-sm">
              <option value="">-- Todos --</option>
              @foreach($estados as $estado)
                <option value="{{ $estado }}" {{ request('estado') == $estado ? 'selected' : '' }}>
                  {{ $estado }}
                </option>
              @endforeach
            </select>
          </div>
          <div class="col-md-2">
            <button type="submit" class="btn btn-secondary btn-sm w-100">
              <i class="fas fa-filter me-1"></i> Filtrar
            </button>
          </div>
          @if(request('estado'))
          <div class="col-md-2">
            <a href="{{ route('admin.vehiculos.index') }}" class="btn btn-outline-secondary btn-sm w-100">
              <i class="fas fa-times me-1"></i> Limpiar
            </a>
          </div>
          @endif
        </form>
      </div>

      <div class="card-body table-responsive p-0">
        <table class="table table-hover table-striped text-nowrap">
          <thead>
            <tr>
              <th>Imagen</th>
              <th>Placa</th>
              <th>Marca / Modelo</th>
              <th>Año</th>
              <th>Tipo</th>
              <th>Capacidad</th>
              <th>Combustible</th>
              <th>Estado</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @forelse($vehiculos as $vehiculo)
            <tr>
              <td>
                @if($vehiculo['imagen'])
                  <img src="{{ asset('storage/' . $vehiculo['imagen']) }}"
                       alt="Vehículo" width="60" height="40"
                       style="object-fit:cover; border-radius:4px;">
                @else
                  <div class="bg-secondary d-flex align-items-center justify-content-center"
                       style="width:60px;height:40px;border-radius:4px;">
                    <i class="fas fa-car text-white"></i>
                  </div>
                @endif
              </td>
              <td><strong>{{ $vehiculo['placa'] }}</strong></td>
              <td>{{ $vehiculo['marca'] }} {{ $vehiculo['modelo'] }}</td>
              <td>{{ $vehiculo['anio'] }}</td>
              <td>{{ $vehiculo['tipo'] }}</td>
              <td>{{ $vehiculo['capacidad'] }} personas</td>
              <td>{{ $vehiculo['combustible'] }}</td>
              <td>
                @php
                  $badgeColor = match($vehiculo['estado']) {
                    'Disponible'       => 'success',
                    'Asignado'         => 'info',
                    'Mantenimiento'    => 'warning',
                    'Fuera de servicio'=> 'danger',
                    default            => 'secondary',
                  };
                @endphp
                <span class="badge bg-{{ $badgeColor }}">{{ $vehiculo['estado'] }}</span>
              </td>
              <td>
                <a href="{{ route('admin.vehiculos.edit', $vehiculo['id']) }}"
                   class="btn btn-warning btn-sm">
                  <i class="fas fa-edit"></i>
                </a>
                <form action="{{ route('admin.vehiculos.destroy', $vehiculo['id']) }}"
                      method="POST" class="d-inline"
                      onsubmit="return confirm('¿Deseas eliminar este vehículo?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm">
                    <i class="fas fa-trash"></i>
                  </button>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="9" class="text-center">No hay vehículos registrados.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection