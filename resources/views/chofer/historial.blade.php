@extends('layouts.dashboard')

@section('title', 'Mi Historial')
@section('page_title', 'Mi Historial')

@section('content')

{{-- Historial de Solicitudes --}}
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-file-alt me-1"></i> Historial de Solicitudes</h3>
      </div>
      <div class="card-body table-responsive p-0">
        <table class="table table-hover table-striped text-nowrap">
          <thead>
            <tr>
              <th>#</th>
              <th>Vehículo</th>
              <th>Fecha Inicio</th>
              <th>Fecha Fin</th>
              <th>Estado</th>
            </tr>
          </thead>
          <tbody>
            @forelse($solicitudes as $solicitud)
            <tr>
              <td>{{ $solicitud['id'] }}</td>
              <td>{{ $solicitud['vehiculo'] }}</td>
              <td>{{ $solicitud['fecha_inicio'] }}</td>
              <td>{{ $solicitud['fecha_fin'] }}</td>
              <td>
                @php
                  $color = match($solicitud['estado']) {
                    'Pendiente' => 'warning',
                    'Aprobada'  => 'success',
                    'Rechazada' => 'danger',
                    'Cancelada' => 'secondary',
                    default     => 'secondary',
                  };
                @endphp
                <span class="badge bg-{{ $color }}">{{ $solicitud['estado'] }}</span>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="5" class="text-center">No hay solicitudes en tu historial.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

{{-- Historial de Viajes --}}
<div class="row mt-3">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-route me-1"></i> Historial de Viajes</h3>
      </div>
      <div class="card-body table-responsive p-0">
        <table class="table table-hover table-striped text-nowrap">
          <thead>
            <tr>
              <th>#</th>
              <th>Vehículo</th>
              <th>Ruta</th>
              <th>Fecha Salida</th>
              <th>Fecha Regreso</th>
              <th>KM Recorridos</th>
            </tr>
          </thead>
          <tbody>
            @forelse($viajes as $viaje)
            <tr>
              <td>{{ $viaje['id'] }}</td>
              <td>{{ $viaje['vehiculo'] }}</td>
              <td>{{ $viaje['ruta'] ?? 'N/A' }}</td>
              <td>{{ $viaje['fecha_salida'] }}</td>
              <td>{{ $viaje['fecha_regreso'] ?? 'En curso' }}</td>
              <td>
                @if($viaje['km_regreso'])
                  {{ number_format($viaje['km_regreso'] - $viaje['km_salida']) }} km
                @else
                  En curso
                @endif
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="6" class="text-center">No hay viajes en tu historial.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection