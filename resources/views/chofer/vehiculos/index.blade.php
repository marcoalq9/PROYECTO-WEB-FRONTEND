@extends('layouts.dashboard')

@section('title', 'Vehículos Disponibles')
@section('page_title', 'Vehículos Disponibles')

@section('content')

{{-- Filtro por fecha --}}
<div class="row mb-3">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-search me-1"></i> Buscar disponibilidad por fecha</h3>
      </div>
      <div class="card-body">
        <form method="GET" action="{{ route('chofer.vehiculos.index') }}" class="row g-2 align-items-end">
          <div class="col-md-4">
            <label class="form-label">Fecha y Hora de Inicio</label>
            <input type="text" name="fecha_inicio" class="form-control js-datetime"
                   value="{{ $fecha_inicio }}">
          </div>
          <div class="col-md-4">
            <label class="form-label">Fecha y Hora de Fin</label>
            <input type="text" name="fecha_fin" class="form-control js-datetime"
                   value="{{ $fecha_fin }}">
          </div>
          <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">
              <i class="fas fa-search me-1"></i> Buscar
            </button>
          </div>
          @if($fecha_inicio || $fecha_fin)
          <div class="col-md-2">
            <a href="{{ route('chofer.vehiculos.index') }}" class="btn btn-outline-secondary w-100">
              <i class="fas fa-times me-1"></i> Limpiar
            </a>
          </div>
          @endif
        </form>
      </div>
    </div>
  </div>
</div>

{{-- Catálogo de vehículos --}}
<div class="row">
  @forelse($vehiculos as $vehiculo)
  <div class="col-md-6 col-lg-4 mb-4">
    <div class="card h-100 shadow-sm">
      {{-- Imagen del vehículo --}}
      @if($vehiculo['imagen'])
        <img src="{{ $vehiculo['imagen'] }}"
             class="card-img-top" alt="{{ $vehiculo['marca'] }} {{ $vehiculo['modelo'] }}"
             style="height:200px; object-fit:cover;">
      @else
        <div class="bg-secondary d-flex align-items-center justify-content-center"
             style="height:200px;">
          <i class="fas fa-car text-white" style="font-size:4rem;"></i>
        </div>
      @endif

      <div class="card-body">
        <h5 class="card-title">{{ $vehiculo['marca'] }} {{ $vehiculo['modelo'] }}</h5>
        <p class="card-text">
          <span class="badge bg-success mb-2">{{ $vehiculo['estado'] }}</span><br>
          <i class="fas fa-id-card text-muted me-1"></i> <strong>Placa:</strong> {{ $vehiculo['placa'] }}<br>
          <i class="fas fa-calendar text-muted me-1"></i> <strong>Año:</strong> {{ $vehiculo['anio'] }}<br>
          <i class="fas fa-car text-muted me-1"></i> <strong>Tipo:</strong> {{ $vehiculo['tipo'] }}<br>
          <i class="fas fa-users text-muted me-1"></i> <strong>Capacidad:</strong> {{ $vehiculo['capacidad'] }} personas<br>
          <i class="fas fa-gas-pump text-muted me-1"></i> <strong>Combustible:</strong> {{ $vehiculo['combustible'] }}
        </p>
      </div>
      <div class="card-footer bg-white">
        <a href="{{ route('chofer.solicitudes.create', ['vehiculo_id' => $vehiculo['id']]) }}"
           class="btn btn-primary w-100">
          <i class="fas fa-plus me-1"></i> Solicitar este vehículo
        </a>
      </div>
    </div>
  </div>
  @empty
  <div class="col-12">
    <div class="alert alert-warning text-center">
      <i class="fas fa-exclamation-triangle me-1"></i>
      No hay vehículos disponibles en este momento.
    </div>
  </div>
  @endforelse
</div>
@endsection
