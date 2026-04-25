@extends('layouts.dashboard')

@section('title', 'Editar Mantenimiento')
@section('page_title', 'Editar Mantenimiento')

@section('content')
<div class="row">
  <div class="col-md-8 offset-md-2">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-tools me-1"></i> Editar Mantenimiento</h3>
      </div>
      <form action="{{ route('admin.mantenimientos.update', $mantenimiento['id']) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">

          <div class="mb-3">
            <label class="form-label">Vehículo <span class="text-danger">*</span></label>
            <select name="vehiculo_id" class="form-select @error('vehiculo_id') is-invalid @enderror">
              <option value="">-- Seleccione un vehículo --</option>
              @foreach($vehiculos as $vehiculo)
                <option value="{{ $vehiculo['id'] }}"
                  {{ old('vehiculo_id', $mantenimiento['vehiculo']) == $vehiculo['nombre'] ? 'selected' : '' }}>
                  {{ $vehiculo['nombre'] }}
                </option>
              @endforeach
            </select>
            @error('vehiculo_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Tipo de Mantenimiento <span class="text-danger">*</span></label>
            <select name="tipo" class="form-select @error('tipo') is-invalid @enderror">
              <option value="">-- Seleccione --</option>
              @foreach($tipos as $tipo)
                <option value="{{ $tipo }}"
                  {{ old('tipo', $mantenimiento['tipo']) == $tipo ? 'selected' : '' }}>
                  {{ $tipo }}
                </option>
              @endforeach
            </select>
            @error('tipo')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Fecha de Inicio <span class="text-danger">*</span></label>
            <input type="date" name="fecha_inicio"
                   class="form-control @error('fecha_inicio') is-invalid @enderror"
                   value="{{ old('fecha_inicio', $mantenimiento['fecha_inicio']) }}">
            @error('fecha_inicio')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          @if($mantenimiento['estado'] === 'Cerrado')
          <div class="mb-3">
            <label class="form-label">Fecha de Cierre</label>
            <input type="date" name="fecha_cierre"
                   class="form-control"
                   value="{{ old('fecha_cierre', $mantenimiento['fecha_cierre']) }}">
          </div>
          @endif

          <div class="mb-3">
            <label class="form-label">Descripción <span class="text-danger">*</span></label>
            <textarea name="descripcion" rows="3"
                      class="form-control @error('descripcion') is-invalid @enderror">{{ old('descripcion', $mantenimiento['descripcion']) }}</textarea>
            @error('descripcion')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Costo <small class="text-muted">(opcional)</small></label>
            <div class="input-group">
              <span class="input-group-text">₡</span>
              <input type="number" name="costo" min="0" step="100"
                     class="form-control @error('costo') is-invalid @enderror"
                     value="{{ old('costo', $mantenimiento['costo']) }}">
              @error('costo')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Estado</label>
            <input type="text" class="form-control"
                   value="{{ $mantenimiento['estado'] }}" readonly>
            <small class="text-muted">Para cerrar el mantenimiento use el botón "Cerrar" en el listado.</small>
          </div>

        </div>
        <div class="card-footer">
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save me-1"></i> Actualizar
          </button>
          <a href="{{ route('admin.mantenimientos.index') }}" class="btn btn-secondary ms-2">
            <i class="fas fa-times me-1"></i> Cancelar
          </a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection