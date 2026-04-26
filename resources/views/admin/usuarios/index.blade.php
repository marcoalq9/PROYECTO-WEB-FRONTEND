@extends('layouts.dashboard')

@section('title', 'Usuarios')
@section('page_title', 'Gestión de Usuarios')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-users me-1"></i> Lista de Usuarios</h3>
        <div class="card-tools">
          <a href="{{ route('admin.usuarios.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Nuevo Usuario
          </a>
        </div>
      </div>

      <div class="card-body border-bottom">
        <form method="GET" action="{{ route('admin.usuarios.index') }}" class="row g-2 align-items-end">
          <div class="col-md-4">
            <label class="form-label">Filtrar por Estado</label>
            <select name="estado" class="form-select">
              @foreach($estados as $opcion)
                <option value="{{ $opcion }}" {{ $estado === $opcion ? 'selected' : '' }}>
                  {{ $opcion }}
                </option>
              @endforeach
            </select>
          </div>
          <div class="col-md-2">
            <button type="submit" class="btn btn-secondary w-100">
              <i class="fas fa-filter me-1"></i> Filtrar
            </button>
          </div>
        </form>
      </div>

      <div class="card-body table-responsive p-0">
        <table class="table table-hover table-striped text-nowrap">
          <thead>
            <tr>
              <th>#</th>
              <th>Nombre</th>
              <th>Correo</th>
              <th>Teléfono</th>
              <th>Rol</th>
              <th>Estado</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @forelse($usuarios as $usuario)
            <tr>
              <td>{{ $usuario['id'] }}</td>
              <td>{{ $usuario['nombre'] }}</td>
              <td>{{ $usuario['correo'] }}</td>
              <td>{{ $usuario['telefono'] ?? 'N/A' }}</td>
              <td>
                <span class="badge bg-info">{{ $usuario['rol'] }}</span>
              </td>
              <td>
                <span class="badge bg-{{ $usuario['estado'] === 'Activo' ? 'success' : 'secondary' }}">
                  {{ $usuario['estado'] }}
                </span>
              </td>
              <td>
                @if($usuario['estado'] === 'Activo')
                <a href="{{ route('admin.usuarios.edit', $usuario['id']) }}"
                   class="btn btn-warning btn-action me-1 mb-1">
                  <i class="fas fa-edit me-1"></i> Editar
                </a>
                <form action="{{ route('admin.usuarios.destroy', $usuario['id']) }}"
                      method="POST" class="d-inline-block mb-1"
                      onsubmit="return confirm('¿Deseas eliminar este usuario?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-action">
                    <i class="fas fa-trash me-1"></i> Eliminar
                  </button>
                </form>
                @else
                  <form action="{{ route('admin.usuarios.restore', $usuario['id']) }}"
                        method="POST" class="d-inline-block mb-1"
                        onsubmit="return confirm('¿Deseas activar este usuario?')">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-success btn-action">
                      <i class="fas fa-user-check me-1"></i> Activar
                    </button>
                  </form>
                @endif
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="7" class="text-center">No hay usuarios registrados.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
