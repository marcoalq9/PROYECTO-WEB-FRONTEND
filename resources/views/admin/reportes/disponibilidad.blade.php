@extends('layouts.dashboard')

@section('title', 'Reporte de Disponibilidad')
@section('page_title', 'Reporte: Disponibilidad de Vehículos')

@section('content')

{{-- Filtros --}}
<div class="row mb-3">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-filter me-1"></i> Filtrar por rango de fecha/hora</h3>
      </div>
      <div class="card-body">
        <form method="GET" action="{{ route('admin.reportes.disponibilidad') }}" class="row g-2 align-items-end">
          <div class="col-md-4">
            <label class="form-label">Fecha y Hora de Inicio <span class="text-danger">*</span></label>
            <input type="datetime-local" name="fecha_inicio" class="form-control"
                   value="{{ $fecha_inicio }}" required>
          </div>
          <div class="col-md-4">
            <label class="form-label">Fecha y Hora de Fin <span class="text-danger">*</span></label>
            <input type="datetime-local" name="fecha_fin" class="form-control"
                   value="{{ $fecha_fin }}" required>
          </div>
          <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">
              <i class="fas fa-search me-1"></i> Consultar
            </button>
          </div>
          @if($fecha_inicio || $fecha_fin)
          <div class="col-md-2">
            <a href="{{ route('admin.reportes.disponibilidad') }}" class="btn btn-outline-secondary w-100">
              <i class="fas fa-times me-1"></i> Limpiar
            </a>
          </div>
          @endif
        </form>
      </div>
    </div>
  </div>
</div>

{{-- Resultados --}}
@if($fecha_inicio && $fecha_fin)
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-car me-1"></i>
          Vehículos disponibles del {{ $fecha_inicio }} al {{ $fecha_fin }}
        </h3>
        <div class="card-tools">
          <span class="badge bg-success">{{ count($vehiculos) }} disponibles</span>
        </div>
      </div>
      <div class="card-body">
        @if(count($vehiculos) > 0)
          <div class="row">
            @foreach($vehiculos as $vehiculo)
            <div class="col-md-6 col-lg-4 mb-3">
              <div class="card border h-100">
                @if($vehiculo['imagen'])
                  <img src="{{ asset('storage/' . $vehiculo['imagen']) }}"
                       class="card-img-top" style="height:150px; object-fit:cover;">
                @else
                  <div class="bg-secondary d-flex align-items-center justify-content-center"
                       style="height:150px;">
                    <i class="fas fa-car text-white" style="font-size:3rem;"></i>
                  </div>
                @endif
                <div class="card-body">
                  <h6 class="card-title">{{ $vehiculo['marca'] }} {{ $vehiculo['modelo'] }}</h6>
                  <p class="card-text small">
                    <i class="fas fa-id-card me-1 text-muted"></i> {{ $vehiculo['placa'] }}<br>
                    <i class="fas fa-calendar me-1 text-muted"></i> {{ $vehiculo['anio'] }}<br>
                    <i class="fas fa-car me-1 text-muted"></i> {{ $vehiculo['tipo'] }}<br>
                    <i class="fas fa-users me-1 text-muted"></i> {{ $vehiculo['capacidad'] }} personas<br>
                    <i class="fas fa-gas-pump me-1 text-muted"></i> {{ $vehiculo['combustible'] }}
                  </p>
                  <span class="badge bg-success">Disponible</span>
                </div>
              </div>
            </div>
            @endforeach
          </div>
        @else
          <div class="alert alert-warning text-center">
            <i class="fas fa-exclamation-triangle me-1"></i>
            No hay vehículos disponibles para el rango seleccionado.
          </div>
        @endif
      </div>
    </div>
  </div>
</div>
@else
<div class="alert alert-info">
  <i class="fas fa-info-circle me-1"></i>
  Selecciona un rango de fecha y hora para ver los vehículos disponibles.
</div>
@endif
@endsection