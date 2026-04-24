@extends('layouts.dashboard')

@section('title', 'Registrar Salida')
@section('page_title', 'Registrar Salida de Vehículo')

@section('content')
<div class="row">
  <div class="col-md-8 offset-md-2">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-route me-1"></i> Registrar Salida</h3>
      </div>
      <form action="{{ route('operador.viajes.store') }}" method="POST">
        @csrf
        <div class="card-body">

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
            <label class="form-label">Vehículo <span class="text-danger">*</span></label>
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

          <div class="mb-3">
            <label class="form-label">Ruta <small class="text-muted">(opcional)</small></label>
            <select name="ruta_id" class="form-select">
              <option value="">-- Sin ruta asignada --</option>
              @foreach($rutas as $ruta)
                <option value="{{ $ruta['id'] }}"
                  {{ old('ruta_id') == $ruta['id'] ? 'selected' : '' }}>
                  {{ $ruta['nombre'] }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Fecha y Hora de Salida <span class="text-danger">*</span></label>
            <input type="datetime-local" name="fecha_salida"
                   class="form-control @error('fecha_salida') is-invalid @enderror"
                   value="{{ old('fecha_salida', date('Y-m-d\TH:i')) }}">
            @error('fecha_salida')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Kilometraje de Salida <span class="text-danger">*</span></label>
            <input type="number" name="km_salida" min="0"
                   class="form-control @error('km_salida') is-invalid @enderror"
                   value="{{ old('km_salida') }}"
                   placeholder="Ej: 15000">
            @error('km_salida')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Observaciones <small class="text-muted">(opcional)</small></label>
            <textarea name="observaciones" rows="2" class="form-control"
                      placeholder="Observaciones adicionales...">{{ old('observaciones') }}</textarea>
          </div>

        </div>
        <div class="card-footer">
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-car me-1"></i> Registrar Salida
          </button>
          <a href="{{ route('operador.viajes.index') }}" class="btn btn-secondary ms-2">
            <i class="fas fa-times me-1"></i> Cancelar
          </a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection