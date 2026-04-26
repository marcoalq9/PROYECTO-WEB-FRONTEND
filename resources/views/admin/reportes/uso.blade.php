@extends('layouts.dashboard')

@section('title', 'Reporte de Uso de Flotilla')
@section('page_title', 'Reporte: Uso de Flotilla por Periodo')

@section('content')

{{-- Filtros --}}
<div class="row mb-3">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-filter me-1"></i> Filtrar por periodo</h3>
      </div>
      <div class="card-body">
        <form method="GET" action="{{ route('admin.reportes.uso') }}" class="row g-2 align-items-end">
          <div class="col-md-4">
            <label class="form-label">Fecha de Inicio <span class="text-danger">*</span></label>
            <input type="text" name="fecha_inicio" class="form-control js-date"
                   value="{{ $fecha_inicio }}" required>
          </div>
          <div class="col-md-4">
            <label class="form-label">Fecha de Fin <span class="text-danger">*</span></label>
            <input type="text" name="fecha_fin" class="form-control js-date"
                   value="{{ $fecha_fin }}" required>
          </div>
          <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">
              <i class="fas fa-search me-1"></i> Consultar
            </button>
          </div>
          @if($fecha_inicio || $fecha_fin)
          <div class="col-md-2">
            <a href="{{ route('admin.reportes.uso') }}" class="btn btn-outline-secondary w-100">
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

  {{-- Tarjetas resumen --}}
  <div class="col-md-6 mb-3">
    <div class="small-box bg-info">
      <div class="inner">
        <h3>{{ $total_viajes }}</h3>
        <p>Total de Viajes en el Periodo</p>
      </div>
      <div class="icon"><i class="fas fa-route"></i></div>
    </div>
  </div>
  <div class="col-md-6 mb-3">
    <div class="small-box bg-success">
      <div class="inner">
        <h3>{{ number_format($total_km) }} km</h3>
        <p>Total de Kilómetros Recorridos</p>
      </div>
      <div class="icon"><i class="fas fa-tachometer-alt"></i></div>
    </div>
  </div>

  {{-- Tabla de uso --}}
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-table me-1"></i> Uso por vehículo del {{ $fecha_inicio }} al {{ $fecha_fin }}
        </h3>
      </div>
      <div class="card-body table-responsive p-0">
        <table class="table table-hover table-striped text-nowrap">
          <thead>
            <tr>
              <th>Vehículo</th>
              <th>Total Viajes</th>
              <th>KM Recorridos</th>
              <th>Última Salida</th>
            </tr>
          </thead>
          <tbody>
            @forelse($datos as $dato)
            <tr>
              <td><i class="fas fa-car me-1 text-muted"></i>{{ $dato['vehiculo'] }}</td>
              <td>
                <span class="badge bg-info">{{ $dato['total_viajes'] }} viajes</span>
              </td>
              <td>
                <span class="badge bg-success">{{ number_format($dato['km_recorridos']) }} km</span>
              </td>
              <td>{{ $dato['ultima_salida'] }}</td>
            </tr>
            @empty
            <tr>
              <td colspan="4" class="text-center">No hay datos para el periodo seleccionado.</td>
            </tr>
            @endforelse
          </tbody>
          @if(count($datos) > 0)
          <tfoot class="table-dark">
            <tr>
              <th>TOTALES</th>
              <th>{{ $total_viajes }} viajes</th>
              <th>{{ number_format($total_km) }} km</th>
              <th>--</th>
            </tr>
          </tfoot>
          @endif
        </table>
      </div>
    </div>
  </div>
</div>
@else
<div class="alert alert-info">
  <i class="fas fa-info-circle me-1"></i>
  Selecciona un periodo para ver el uso de la flotilla.
</div>
@endif
@endsection
