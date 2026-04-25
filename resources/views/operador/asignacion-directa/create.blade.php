@extends('layouts.dashboard')

@section('title', 'Asignación Directa')
@section('page_title', 'Asignación Directa de Vehículo')

@section('content')
<div class="row">
  <div class="col-md-8 offset-md-2">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-hand-pointer me-1"></i> Asignación Directa</h3>
      </div>
      <form action="{{ route('operador.asignacion-directa.store') }}" method="POST">
        @csrf
        <div class="card-body">

          <div class="alert alert-info">
            <i class="fas fa-info-circle me-1"></i>
            La asignación directa crea una solicitud <strong>ya aprobada</strong> sin necesidad de que el chofer la solicite primero.
          </div>

          <div class="mb-3">
            <label class="form-label">Chofer <span class="text-danger">*</span></label>
            <select name="chofer_id" class="form-select @error('chofer_id') is-invalid @enderror">
              <option value="">-- Seleccione un chofer --</option>
              @foreach($choferes as $chofer)
                <option value="{{ $chofer['id'] }}"
                  {{ old('chofer_id') == $chofer['id'] ? 'selected' : '' }}>
                  {{ $chofer['nombre'] }}
                </option>
              @endforeach
            </select>
            @error('chofer_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Vehículo Disponible <span class="text-danger">*</span></label>
            <select name="vehiculo_id" class="form-select @error('vehiculo_id') is-invalid @enderror">
              <option value="">-- Seleccione un vehículo --</option>
              @foreach($vehiculos as $vehiculo)
                <option value="{{ $vehiculo['id'] }}"
                  {{ old('vehiculo_id') == $vehiculo['id'] ? 'selected' : '' }}>
                  {{ $vehiculo['nombre'] }}
                </option>
              @endforeach
            </select>
            @error('vehiculo_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Fecha y Hora de Inicio <span class="text-danger">*</span></label>
              <input type="datetime-local" name="fecha_inicio"
                     class="form-control @error('fecha_inicio') is-invalid @enderror"
                     value="{{ old('fecha_inicio') }}">
              @error('fecha_inicio')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Fecha y Hora de Fin <span class="text-danger">*</span></label>
              <input type="datetime-local" name="fecha_fin"
                     class="form-control @error('fecha_fin') is-invalid @enderror"
                     value="{{ old('fecha_fin') }}">
              @error('fecha_fin')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Motivo <small class="text-muted">(opcional)</small></label>
            <textarea name="motivo" rows="2" class="form-control"
                      placeholder="Motivo de la asignación...">{{ old('motivo') }}</textarea>
          </div>

        </div>
        <div class="card-footer">
          <button type="submit" class="btn btn-success">
            <i class="fas fa-check me-1"></i> Crear Asignación
          </button>
          <a href="{{ route('operador.solicitudes.index') }}" class="btn btn-secondary ms-2">
            <i class="fas fa-times me-1"></i> Cancelar
          </a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection