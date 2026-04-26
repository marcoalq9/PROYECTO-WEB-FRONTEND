@extends('layouts.dashboard')

@section('title', 'Nueva Solicitud')
@section('page_title', 'Solicitar Vehículo')

@section('content')
<div class="row">
  <div class="col-md-8 offset-md-2">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-file-alt me-1"></i> Nueva Solicitud</h3>
      </div>
      <form action="{{ route('chofer.solicitudes.store') }}" method="POST">
        @csrf
        <div class="card-body">

          <div class="mb-3">
            <label class="form-label">Vehículo <span class="text-danger">*</span></label>
            <select name="vehiculo_id" class="form-select @error('vehiculo_id') is-invalid @enderror">
              <option value="">-- Seleccione un vehículo --</option>
              @foreach($vehiculos as $vehiculo)
                <option value="{{ $vehiculo['id'] }}"
                  {{ (old('vehiculo_id', $vehiculo_id) == $vehiculo['id']) ? 'selected' : '' }}>
                  {{ $vehiculo['nombre'] }}
                </option>
              @endforeach
            </select>
            @error('vehiculo_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Fecha y Hora de Inicio <span class="text-danger">*</span></label>
              <input type="text" name="fecha_inicio"
                     class="form-control js-datetime @error('fecha_inicio') is-invalid @enderror"
                     value="{{ old('fecha_inicio', $fecha_inicio ?? '') }}">
              @error('fecha_inicio')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Fecha y Hora de Fin <span class="text-danger">*</span></label>
              <input type="text" name="fecha_fin"
                     class="form-control js-datetime @error('fecha_fin') is-invalid @enderror"
                     value="{{ old('fecha_fin', $fecha_fin ?? '') }}">
              @error('fecha_fin')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>

          @error('fecha_fin')
            <div class="alert alert-danger">
              <i class="fas fa-exclamation-triangle me-1"></i> {{ $message }}
            </div>
          @enderror

          <div class="mb-3">
            <label class="form-label">Motivo <small class="text-muted">(opcional)</small></label>
            <textarea name="motivo" rows="3" class="form-control"
                      placeholder="Describe el motivo de la solicitud...">{{ old('motivo') }}</textarea>
          </div>

        </div>
        <div class="card-footer">
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-paper-plane me-1"></i> Enviar Solicitud
          </button>
          <a href="{{ route('chofer.vehiculos.index') }}" class="btn btn-secondary ms-2">
            <i class="fas fa-times me-1"></i> Cancelar
          </a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
