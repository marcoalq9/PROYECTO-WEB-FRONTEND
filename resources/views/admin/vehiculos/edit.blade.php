@extends('layouts.dashboard')

@section('title', 'Editar Vehículo')
@section('page_title', 'Editar Vehículo')

@section('content')
<div class="row">
  <div class="col-md-10 offset-md-1">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-car me-1"></i> Editar Vehículo</h3>
      </div>
      <form action="{{ route('admin.vehiculos.update', $vehiculo['id']) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
          <div class="row">

            <div class="col-md-6 mb-3">
              <label class="form-label">Placa <span class="text-danger">*</span></label>
              <input type="text" name="placa"
                     class="form-control @error('placa') is-invalid @enderror"
                     value="{{ old('placa', $vehiculo['placa']) }}">
              @error('placa')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Marca <span class="text-danger">*</span></label>
              <input type="text" name="marca"
                     class="form-control @error('marca') is-invalid @enderror"
                     value="{{ old('marca', $vehiculo['marca']) }}">
              @error('marca')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Modelo <span class="text-danger">*</span></label>
              <input type="text" name="modelo"
                     class="form-control @error('modelo') is-invalid @enderror"
                     value="{{ old('modelo', $vehiculo['modelo']) }}">
              @error('modelo')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Año <span class="text-danger">*</span></label>
              <input type="number" name="anio"
                     class="form-control @error('anio') is-invalid @enderror"
                     value="{{ old('anio', $vehiculo['anio']) }}">
              @error('anio')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Tipo de Vehículo <span class="text-danger">*</span></label>
              <select name="tipo" class="form-select @error('tipo') is-invalid @enderror">
                <option value="">-- Seleccione --</option>
                @foreach($tipos as $tipo)
                  <option value="{{ $tipo }}"
                    {{ old('tipo', $vehiculo['tipo']) == $tipo ? 'selected' : '' }}>
                    {{ $tipo }}
                  </option>
                @endforeach
              </select>
              @error('tipo')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Capacidad (personas) <span class="text-danger">*</span></label>
              <input type="number" name="capacidad"
                     class="form-control @error('capacidad') is-invalid @enderror"
                     value="{{ old('capacidad', $vehiculo['capacidad']) }}">
              @error('capacidad')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Tipo de Combustible <span class="text-danger">*</span></label>
              <select name="combustible" class="form-select @error('combustible') is-invalid @enderror">
                <option value="">-- Seleccione --</option>
                @foreach($combustibles as $combustible)
                  <option value="{{ $combustible }}"
                    {{ old('combustible', $vehiculo['combustible']) == $combustible ? 'selected' : '' }}>
                    {{ $combustible }}
                  </option>
                @endforeach
              </select>
              @error('combustible')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Estado <span class="text-danger">*</span></label>
              <select name="estado" class="form-select @error('estado') is-invalid @enderror">
                <option value="">-- Seleccione --</option>
                @foreach($estados as $estado)
                  <option value="{{ $estado }}"
                    {{ old('estado', $vehiculo['estado']) == $estado ? 'selected' : '' }}>
                    {{ $estado }}
                  </option>
                @endforeach
              </select>
              @error('estado')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-12 mb-3">
              <label class="form-label">Imagen del Vehículo</label>
              @if($vehiculo['imagen'])
                <div class="mb-2">
                  <img src="{{ asset('storage/' . $vehiculo['imagen']) }}"
                       alt="Imagen actual" style="max-height:150px; border-radius:8px;">
                  <p class="text-muted small mt-1">Imagen actual</p>
                </div>
              @endif
              <input type="file" name="imagen" accept="image/*"
                     class="form-control @error('imagen') is-invalid @enderror"
                     onchange="previewImagen(this)">
              @error('imagen')<div class="invalid-feedback">{{ $message }}</div>@enderror
              <div class="mt-2">
                <img id="preview" src="#" alt="Preview"
                     style="display:none; max-height:150px; border-radius:8px;">
              </div>
            </div>

          </div>
        </div>
        <div class="card-footer">
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save me-1"></i> Actualizar
          </button>
          <a href="{{ route('admin.vehiculos.index') }}" class="btn btn-secondary ms-2">
            <i class="fas fa-times me-1"></i> Cancelar
          </a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  function previewImagen(input) {
    const preview = document.getElementById('preview');
    if (input.files && input.files[0]) {
      const reader = new FileReader();
      reader.onload = e => {
        preview.src = e.target.result;
        preview.style.display = 'block';
      };
      reader.readAsDataURL(input.files[0]);
    }
  }
</script>
@endpush