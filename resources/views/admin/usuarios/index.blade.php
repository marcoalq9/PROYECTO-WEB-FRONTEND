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
          <a href="{{ route('admin.usuarios.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Nuevo Usuario
          </a>
        </div>
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
              <td>{{ $usuario['name'] }}</td>
              <td>{{ $usuario['email'] }}</td>
              <td>{{ $usuario['telephone'] ?? 'N/A' }}</td>
              <td>
                <span class="badge bg-info">{{ $usuario['role']['role_name'] ?? 'N/A' }}</span>
              </td>
              <td>
                <span class="badge bg-{{ isset($usuario['deleted_at']) && $usuario['deleted_at'] ? 'danger' : 'success' }}">
                  {{ isset($usuario['deleted_at']) && $usuario['deleted_at'] ? 'Inactivo' : 'Activo' }}
                </span>
              </td>
              <td>
                <a href="{{ route('admin.usuarios.edit', $usuario['id']) }}"
                  class="btn btn-warning btn-sm">
                  <i class="fas fa-edit"></i>
                </a>
                <form action="{{ route('admin.usuarios.destroy', $usuario['id']) }}"
                      method="POST" class="d-inline"
                      onsubmit="return confirm('¿Deseas eliminar este usuario?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm">
                    <i class="fas fa-trash"></i>
                  </button>
                </form>
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