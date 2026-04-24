@extends('layouts.dashboard')

@section('title', 'Dashboard - Administrador')
@section('page_title', 'Dashboard')

@section('content')
<div class="row">
  {{-- Tarjeta Usuarios --}}
  <div class="col-lg-3 col-6">
    <div class="small-box bg-info">
      <div class="inner">
        <h3>--</h3>
        <p>Usuarios Registrados</p>
      </div>
      <div class="icon"><i class="fas fa-users"></i></div>
      <a href="{{ route('admin.usuarios.index') }}" class="small-box-footer">
        Ver más <i class="fas fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>

  {{-- Tarjeta Vehículos --}}
  <div class="col-lg-3 col-6">
    <div class="small-box bg-success">
      <div class="inner">
        <h3>--</h3>
        <p>Vehículos Activos</p>
      </div>
      <div class="icon"><i class="fas fa-car"></i></div>
      <a href="{{ route('admin.vehiculos.index') }}" class="small-box-footer">
        Ver más <i class="fas fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>

  {{-- Tarjeta Mantenimientos --}}
  <div class="col-lg-3 col-6">
    <div class="small-box bg-warning">
      <div class="inner">
        <h3>--</h3>
        <p>En Mantenimiento</p>
      </div>
      <div class="icon"><i class="fas fa-tools"></i></div>
      <a href="{{ route('admin.mantenimientos.index') }}" class="small-box-footer">
        Ver más <i class="fas fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>

  {{-- Tarjeta Reportes --}}
  <div class="col-lg-3 col-6">
    <div class="small-box bg-danger">
      <div class="inner">
        <h3>3</h3>
        <p>Reportes Disponibles</p>
      </div>
      <div class="icon"><i class="fas fa-chart-bar"></i></div>
      <a href="{{ route('admin.reportes.disponibilidad') }}" class="small-box-footer">
        Ver más <i class="fas fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-info-circle me-1"></i> Accesos Rápidos
        </h3>
      </div>
      <div class="card-body">
        <a href="{{ route('admin.usuarios.create') }}" class="btn btn-info me-2 mb-2">
          <i class="fas fa-user-plus me-1"></i> Nuevo Usuario
        </a>
        <a href="{{ route('admin.vehiculos.create') }}" class="btn btn-success me-2 mb-2">
          <i class="fas fa-car me-1"></i> Nuevo Vehículo
        </a>
        <a href="{{ route('admin.mantenimientos.create') }}" class="btn btn-warning me-2 mb-2">
          <i class="fas fa-tools me-1"></i> Nuevo Mantenimiento
        </a>
        <a href="{{ route('admin.reportes.disponibilidad') }}" class="btn btn-danger me-2 mb-2">
          <i class="fas fa-chart-bar me-1"></i> Ver Reportes
        </a>
      </div>
    </div>
  </div>
</div>
@endsection