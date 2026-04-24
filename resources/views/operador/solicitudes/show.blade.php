@extends('layouts.dashboard')

@section('title', 'Detalle Solicitud')
@section('page_title', 'Detalle de Solicitud')

@section('content')
<div class="row">
  <div class="col-md-8 offset-md-2">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-clipboard me-1"></i> Detalle de Solicitud</h3>
      </div>
      <div class="card-body">
        <table class="table table-bordered">
          <tr><th width="35%">Chofer</th><td>{{ $solicitud['chofer'] }}</td></tr>
          <tr><th>Vehículo</th><td>{{ $solicitud['vehiculo'] }}</td></tr>
          <tr><th>Fecha Inicio</th><td>{{ $solicitud['fecha_inicio'] }}</td></tr>
          <tr><th>Fecha Fin</th><td>{{ $solicitud['fecha_fin'] }}</td></tr>
          <tr><th>Motivo</th><td>{{ $solicitud['motivo'] ?? 'N/A' }}</td></tr>
          <tr>
            <th>Estado</th>
            <td>
              @php
                $color = match($solicitud['estado']) {
                  'Pendiente' => 'warning',
                  'Aprobada'  => 'success',
                  'Rechazada' => 'danger',
                  default     => 'secondary',
                };
              @endphp
              <span class="badge bg-{{ $color }}">{{ $solicitud['estado'] }}</span>
            </td>
          </tr>
          <tr><th>Aprobado/Rechazado por</th><td>{{ $solicitud['aprobado_por'] ?? 'N/A' }}</td></tr>
        </table>
      </div>
      <div class="card-footer">
        @if($solicitud['estado'] === 'Pendiente')
          <form action="{{ route('operador.solicitudes.aprobar', $solicitud['id']) }}"
                method="POST" class="d-inline"
                onsubmit="return confirm('¿Aprobar esta solicitud?')">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn btn-success">
              <i class="fas fa-check me-1"></i> Aprobar
            </button>
          </form>
        @endif
        <a href="{{ route('operador.solicitudes.index') }}" class="btn btn-secondary ms-2">
          <i class="fas fa-arrow-left me-1"></i> Volver
        </a>
      </div>
    </div>
  </div>
</div>
@endsection