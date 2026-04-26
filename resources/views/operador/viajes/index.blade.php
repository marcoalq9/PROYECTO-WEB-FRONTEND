@extends('layouts.dashboard')

@section('title', 'Viajes')
@section('page_title', 'Gestión de Viajes')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-route me-1"></i> Registro de Viajes</h3>
        <div class="card-tools">
          <a href="{{ route('operador.viajes.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Registrar Salida
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
              <th>Ruta</th>
              <th>Fecha Salida</th>
              <th>Fecha Regreso</th>
              <th>KM Salida</th>
              <th>KM Regreso</th>
              <th>Estado</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @forelse($viajes as $viaje)
            <tr>
              <td>{{ $viaje['id'] }}</td>
              <td>{{ $viaje['chofer'] }}</td>
              <td>{{ $viaje['vehiculo'] }}</td>
              <td>{{ $viaje['ruta'] ?? 'N/A' }}</td>
              <td>{{ $viaje['fecha_salida'] }}</td>
              <td>{{ $viaje['fecha_regreso'] ?? 'En curso' }}</td>
              <td>{{ number_format($viaje['km_salida']) }} km</td>
              <td>{{ $viaje['km_regreso'] ? number_format($viaje['km_regreso']) . ' km' : 'N/A' }}</td>
              <td>
                <span class="badge bg-{{ $viaje['estado'] === 'Finalizado' ? 'success' : 'warning' }}">
                  {{ $viaje['estado'] }}
                </span>
              </td>
              <td>
                @if($viaje['estado'] === 'En curso')
                  <button type="button" class="btn btn-success btn-action"
                          data-bs-toggle="modal"
                          data-bs-target="#modalRetorno"
                          data-id="{{ $viaje['id'] }}"
                          data-salida="{{ $viaje['fecha_salida_input'] }}"
                          data-km="{{ $viaje['km_salida'] }}">
                    <i class="fas fa-undo me-1"></i> Retorno
                  </button>
                @else
                  <span class="text-muted small">Finalizado</span>
                @endif
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="10" class="text-center">No hay viajes registrados.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

{{-- Modal Registrar Retorno --}}
<div class="modal fade" id="modalRetorno" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fas fa-undo me-1 text-success"></i> Registrar Retorno</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form id="formRetorno" method="POST">
        @csrf
        @method('PATCH')
        <div class="modal-body">

          <div class="mb-3">
            <label class="form-label">Fecha y Hora de Regreso <span class="text-danger">*</span></label>
            <input type="text" name="fecha_regreso"
                   id="fechaRegreso"
                   class="form-control js-datetime" required
                   value="{{ date('Y-m-d\TH:i') }}">
            <small class="text-muted">Fecha salida: <strong id="fechaSalidaRef">--</strong></small>
          </div>

          <div class="mb-3">
            <label class="form-label">Kilometraje de Regreso <span class="text-danger">*</span></label>
            <input type="number" name="km_regreso" id="kmRegreso"
                   class="form-control" required min="0"
                   placeholder="Ej: 15025">
            <small class="text-muted">KM de salida: <strong id="kmSalidaRef">--</strong></small>
            <input type="hidden" name="km_salida_original" id="kmSalidaOriginal">
          </div>

          <div class="mb-3">
            <label class="form-label">Observaciones <small class="text-muted">(opcional)</small></label>
            <textarea name="observaciones" rows="2" class="form-control"
                      placeholder="Observaciones del viaje..."></textarea>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success">
            <i class="fas fa-check me-1"></i> Confirmar Retorno
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  const modalRetorno = document.getElementById('modalRetorno');
  modalRetorno.addEventListener('show.bs.modal', function(event) {
    const btn = event.relatedTarget;
    const id  = btn.getAttribute('data-id');
    const km  = btn.getAttribute('data-km');
    const salida = btn.getAttribute('data-salida');
    document.getElementById('formRetorno').action = `/operador/viajes/${id}/retorno`;
    document.getElementById('kmSalidaRef').textContent = Number(km).toLocaleString() + ' km';
    document.getElementById('kmSalidaOriginal').value  = km;
    document.getElementById('kmRegreso').min = km;
    document.getElementById('fechaSalidaRef').textContent = salida ? salida.replace('T', ' ') : '--';
    document.getElementById('fechaRegreso').min = salida || '';
  });
</script>
@endpush
