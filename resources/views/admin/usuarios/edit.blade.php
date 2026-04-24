@extends('layouts.dashboard')

@section('title', 'Editar Usuario')
@section('page_title', 'Editar Usuario')

@section('content')
<div class="row">
  <div class="col-md-8 offset-md-2">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-user-edit me-1"></i> Editar Usuario</h3>
      </div>
      <form action="{{ route('admin.usuarios.update', $usuario['id']) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">

          <div class="mb-3">
            <label class="form-label">Nombre Completo <span class="text-danger">*</span></label>
            <input type="text" name="nombre"
                   class="form-control @error('nombre') is-invalid @enderror"
                   value="{{ old('nombre', $usuario['nombre']) }}">
            @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Correo Electrónico <span class="text-danger">*</span></label>
            <input type="email" name="correo"
                   class="form-control @error('correo') is-invalid @enderror"
                   value="{{ old('correo', $usuario['correo']) }}">
            @error('correo')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Teléfono</label>
            <input type="text" name="telefono"
                   class="form-control @error('telefono') is-invalid @enderror"
                   value="{{ old('telefono', $usuario['telefono']) }}">
            @error('telefono')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Rol <span class="text-danger">*</span></label>
            <select name="rol" class="form-select @error('rol') is-invalid @enderror">
              <option value="">-- Seleccione un rol --</option>
              @foreach($roles as $rol)
                <option value="{{ $rol }}"
                  {{ old('rol', $usuario['rol']) == $rol ? 'selected' : '' }}>
                  {{ $rol }}
                </option>
              @endforeach
            </select>
            @error('rol')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Nueva Contraseña <small class="text-muted">(dejar vacío para no cambiar)</small></label>
            <input type="password" name="password"
                   class="form-control @error('password') is-invalid @enderror"
                   placeholder="Nueva contraseña">
            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Confirmar Nueva Contraseña</label>
            <input type="password" name="password_confirmation"
                   class="form-control" placeholder="Repite la nueva contraseña">
          </div>

        </div>
        <div class="card-footer">
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save me-1"></i> Actualizar
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