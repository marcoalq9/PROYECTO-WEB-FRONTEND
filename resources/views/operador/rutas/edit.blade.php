@extends('layouts.dashboard')

@section('title', 'Editar Ruta')
@section('page_title', 'Editar Ruta')

@section('content')
<div class="row">
  <div class="col-md-8 offset-md-2">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-map-marked-alt me-1"></i> Editar Ruta</h3>
      </div>
      <form action="{{ route('operador.rutas.update', $ruta['id']) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">

          <div class="mb-3">
            <label class="form-label">Nombre de la Ruta <span class="text-danger">*</span></label>
            <input type="text" name="nombre"
                   class="form-control @error('nombre') is-invalid @enderror"
                   value="{{ old('nombre', $ruta['nombre']) }}">
            @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Punto de Inicio <span class="text-danger">*</span></label>
            <input type="text" name="inicio"
                   class="form-control @error('inicio') is-invalid @enderror"
                   value="{{ old('inicio', $ruta['inicio']) }}">
            @error('inicio')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Punto Final <span class="text-danger">*</span></label>
            <input type="text" name="fin"
                   class="form-control @error('fin') is-invalid @enderror"
                   value="{{ old('fin', $ruta['fin']) }}">
            @error('fin')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Distancia Estimada (km) <small class="text-muted">(opcional)</small></label>
            <input type="number" name="distancia" step="0.1" min="0"
                   class="form-control @error('distancia') is-invalid @enderror"
                   value="{{ old('distancia', $ruta['distancia']) }}">
            @error('distancia')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Descripción <small class="text-muted">(opcional)</small></label>
            <textarea name="descripcion" rows="3"
                      class="form-control @error('descripcion') is-invalid @enderror">{{ old('descripcion', $ruta['descripcion'] ?? '') }}</textarea>
            @error('descripcion')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

        </div>
        <div class="card-footer">
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save me-1"></i> Actualizar
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