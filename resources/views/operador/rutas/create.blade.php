@extends('layouts.dashboard')

@section('title', 'Nueva Ruta')
@section('page_title', 'Crear Ruta')

@section('content')
<div class="row">
  <div class="col-md-8 offset-md-2">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-map-marked-alt me-1"></i> Nueva Ruta</h3>
      </div>
      <form action="{{ route('operador.rutas.store') }}" method="POST">
        @csrf
        <div class="card-body">

          <div class="mb-3">
            <label class="form-label">Nombre de la Ruta <span class="text-danger">*</span></label>
            <input type="text" name="nombre"
                   class="form-control @error('nombre') is-invalid @enderror"
                   value="{{ old('nombre') }}"
                   placeholder="Ej: San José - Heredia">
            @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Punto de Inicio <span class="text-danger">*</span></label>
            <input type="text" name="inicio"
                   class="form-control @error('inicio') is-invalid @enderror"
                   value="{{ old('inicio') }}"
                   placeholder="Ej: San José Centro">
            @error('inicio')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Punto Final <span class="text-danger">*</span></label>
            <input type="text" name="fin"
                   class="form-control @error('fin') is-invalid @enderror"
                   value="{{ old('fin') }}"
                   placeholder="Ej: Heredia Centro">
            @error('fin')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Distancia Estimada (km) <small class="text-muted">(opcional)</small></label>
            <input type="number" name="distancia" step="0.1" min="0"
                   class="form-control @error('distancia') is-invalid @enderror"
                   value="{{ old('distancia') }}"
                   placeholder="Ej: 12.5">
            @error('distancia')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Descripción <small class="text-muted">(opcional)</small></label>
            <textarea name="descripcion" rows="3"
                      class="form-control @error('descripcion') is-invalid @enderror"
                      placeholder="Descripción adicional de la ruta...">{{ old('descripcion') }}</textarea>
            @error('descripcion')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

        </div>
        <div class="card-footer">
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save me-1"></i> Guardar
          </button>
          <a href="{{ route('operador.rutas.index') }}" class="btn btn-secondary ms-2">
            <i class="fas fa-times me-1"></i> Cancelar
          </a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection