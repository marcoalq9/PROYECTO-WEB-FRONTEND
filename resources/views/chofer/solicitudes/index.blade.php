@extends('layouts.dashboard')

@section('title', 'Mis Solicitudes')
@section('page_title', 'Mis Solicitudes')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-file-alt me-1"></i> Mis Solicitudes</h3>
        <div class="card-tools">
          <a href="{{ route('chofer.solicitudes.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Nueva Solicitud
          </a>
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
              <th>Motivo</th>
              <th>Estado</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @forelse($solicitudes as $solicitud)
            <tr>
              <td>{{ $solicitud['id'] }}</td>
              <td>{{ $solicitud['vehiculo'] }}</td>
              <td>{{ $solicitud['fecha_inicio'] }}</td>
              <td>{{ $solicitud['fecha_fin'] }}</td>
              <td>{{ $solicitud['motivo'] ?? 'N/A' }}</td>
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
              <td>
                @if($solicitud['estado'] === 'Pendiente')
                  <form action="{{ route('chofer.solicitudes.cancelar', $solicitud['id']) }}"
                        method="POST" class="d-inline-block"
                        onsubmit="return confirm('¿Cancelar esta solicitud?')">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-danger btn-action">
                      <i class="fas fa-times me-1"></i> Cancelar
                    </button>
                  </form>
                @else
                  <span class="text-muted small">Sin acciones</span>
                @endif
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="7" class="text-center">No tienes solicitudes registradas.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
