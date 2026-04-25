@extends('layouts.dashboard')

@section('title', 'Historial del Chofer')
@section('page_title', 'Reporte: Historial del Chofer')

@section('content')

{{-- Filtros --}}
<div class="row mb-3">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-filter me-1"></i> Filtros</h3>
      </div>
      <div class="card-body">
        <form method="GET" action="{{ route('admin.reportes.historial-chofer') }}" class="row g-2 align-items-end">
          <div class="col-md-3">
            <label class="form-label">Chofer <span class="text-danger">*</span></label>
            <select name="chofer_id" class="form-select" required>
              <option value="">-- Seleccione --</option>
              @foreach($choferes as $chofer)
                <option value="{{ $chofer['id'] }}"
                  {{ $chofer_id == $chofer['id'] ? 'selected' : '' }}>
                  {{ $chofer['nombre'] }}
                </option>
              @endforeach
            </select>
          </div>
          <div class="col-md-3">
            <label class="form-label">Fecha Inicio</label>
            <input type="date" name="fecha_inicio" class="form-control"
                   value="{{ $fecha_inicio }}">
          </div>
          <div class="col-md-3">
            <label class="form-label">Fecha Fin</label>
            <input type="date" name="fecha_fin" class="form-control"
                   value="{{ $fecha_fin }}">
          </div>
          <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">
              <i class="fas fa-search me-1"></i> Consultar
            </button>
          </div>
          @if($chofer_id)
          <div class="col-md-1">
            <a href="{{ route('admin.reportes.historial-chofer') }}" class="btn btn-outline-secondary w-100">
              <i class="fas fa-times"></i>
            </a>
          </div>
          @endif
        </form>
      </div>
    </div>
  </div>
</div>

@if($chofer_id)

  {{-- Solicitudes del chofer --}}
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title"><i class="fas fa-file-alt me-1"></i> Solicitudes</h3>
          <div class="card-tools">
            <span class="badge bg-info">{{ count($solicitudes) }} registros</span>
          </div>
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
                <td colspan="5" class="text-center">No hay solicitudes para este chofer.</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  {{-- Viajes del chofer --}}
  <div class="row mt-3">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title"><i class="fas fa-route me-1"></i> Viajes Realizados</h3>
          <div class="card-tools">
            <span class="badge bg-success">{{ count($viajes) }} viajes</span>
          </div>
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
                <td>{{ $viaje['fecha_regreso'] }}</td>
                <td>
                  <span class="badge bg-success">{{ number_format($viaje['km_recorridos']) }} km</span>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="6" class="text-center">No hay viajes para este chofer.</td>
              </tr>
              @endforelse
            </tbody>
            @if(count($viajes) > 0)
            <tfoot class="table-dark">
              <tr>
                <th colspan="5">TOTAL KM RECORRIDOS</th>
                <th>{{ number_format(array_sum(array_column($viajes, 'km_recorridos'))) }} km</th>
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
    Selecciona un chofer para ver su historial.
  </div>
@endif
@endsection