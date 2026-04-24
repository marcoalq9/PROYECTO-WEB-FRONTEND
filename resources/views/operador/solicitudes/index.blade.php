@extends('layouts.dashboard')

@section('title', 'Solicitudes')
@section('page_title', 'Gestión de Solicitudes')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-clipboard-list me-1"></i> Solicitudes</h3>
        <div class="card-tools">
          <a href="{{ route('operador.asignacion-directa.create') }}" class="btn btn-success btn-sm">
            <i class="fas fa-hand-pointer me-1"></i> Asignación Directa
          </a>
        </div>
      </div>
      <div class="card-body table-responsive p-0">
        <table class="table table-hover table-striped text-nowrap">
          <thead>
            <tr>
              <th>#</th>
              <th>Chofer</th>
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
              <td>{{ $solicitud['chofer'] }}</td>
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
                <a href="{{ route('operador.solicitudes.show', $solicitud['id']) }}"
                   class="btn btn-info btn-sm">
                  <i class="fas fa-eye"></i>
                </a>
                @if($solicitud['estado'] === 'Pendiente')
                  <form action="{{ route('operador.solicitudes.aprobar', $solicitud['id']) }}"
                        method="POST" class="d-inline"
                        onsubmit="return confirm('¿Aprobar esta solicitud?')">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-success btn-sm">
                      <i class="fas fa-check"></i>
                    </button>
                  </form>
                  <button type="button" class="btn btn-danger btn-sm"
                          data-bs-toggle="modal"
                          data-bs-target="#modalRechazar"
                          data-id="{{ $solicitud['id'] }}">
                    <i class="fas fa-times"></i>
                  </button>
                @endif
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="8" class="text-center">No hay solicitudes registradas.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

{{-- Modal Rechazar --}}
<div class="modal fade" id="modalRechazar" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fas fa-times-circle me-1 text-danger"></i> Rechazar Solicitud</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form id="formRechazar" method="POST">
        @csrf
        @method('PATCH')
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Motivo de rechazo <small class="text-muted">(opcional)</small></label>
            <textarea name="motivo_rechazo" rows="3" class="form-control"
                      placeholder="Explica el motivo del rechazo..."></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-danger">
            <i class="fas fa-times me-1"></i> Rechazar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  const modalRechazar = document.getElementById('modalRechazar');
  modalRechazar.addEventListener('show.bs.modal', function(event) {
    const btn = event.relatedTarget;
    const id  = btn.getAttribute('data-id');
    document.getElementById('formRechazar').action = `/operador/solicitudes/${id}/rechazar`;
  });
</script>
@endpush