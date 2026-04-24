@extends('layouts.dashboard')

@section('title', 'Nuevo Usuario')
@section('page_title', 'Crear Usuario')

@section('content')
<div class="row">
  <div class="col-md-8 offset-md-2">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-user-plus me-1"></i> Nuevo Usuario</h3>
      </div>
      <form action="{{ route('admin.usuarios.store') }}" method="POST">
        @csrf
        <div class="card-body">

          <div class="mb-3">
            <label class="form-label">Nombre Completo <span class="text-danger">*</span></label>
            <input type="text" name="nombre"
                   class="form-control @error('nombre') is-invalid @enderror"
                   value="{{ old('nombre') }}" placeholder="Ej: Juan Pérez">
            @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Correo Electrónico <span class="text-danger">*</span></label>
            <input type="email" name="correo"
                   class="form-control @error('correo') is-invalid @enderror"
                   value="{{ old('correo') }}" placeholder="correo@ejemplo.com">
            @error('correo')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Teléfono</label>
            <input type="text" name="telefono"
                   class="form-control @error('telefono') is-invalid @enderror"
                   value="{{ old('telefono') }}" placeholder="Ej: 8888-0000">
            @error('telefono')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Rol <span class="text-danger">*</span></label>
            <select name="rol" class="form-select @error('rol') is-invalid @enderror">
              <option value="">-- Seleccione un rol --</option>
              @foreach($roles as $rol)
                <option value="{{ $rol }}" {{ old('rol') == $rol ? 'selected' : '' }}>
                  {{ $rol }}
                </option>
              @endforeach
            </select>
            @error('rol')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Contraseña <span class="text-danger">*</span></label>
            <input type="password" name="password"
                   class="form-control @error('password') is-invalid @enderror"
                   placeholder="Mínimo 6 caracteres">
            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Confirmar Contraseña <span class="text-danger">*</span></label>
            <input type="password" name="password_confirmation"
                   class="form-control" placeholder="Repite la contraseña">
          </div>

        </div>
        <div class="card-footer">
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save me-1"></i> Guardar
          </button>
          <a href="{{ route('admin.usuarios.index') }}" class="btn btn-secondary ms-2">
            <i class="fas fa-times me-1"></i> Cancelar
          </a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection