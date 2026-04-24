@extends('layouts.dashboard')

@section('title', 'Dashboard - Operador')
@section('page_title', 'Dashboard')

@section('content')
<div class="row">
  {{-- Solicitudes Pendientes --}}
  <div class="col-lg-3 col-6">
    <div class="small-box bg-warning">
      <div class="inner">
        <h3>--</h3>
        <p>Solicitudes Pendientes</p>
      </div>
      <div class="icon"><i class="fas fa-clipboard-list"></i></div>
      <a href="{{ route('operador.solicitudes.index') }}" class="small-box-footer">
        Ver más <i class="fas fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>

  {{-- Vehículos Disponibles --}}
  <div class="col-lg-3 col-6">
    <div class="small-box bg-success">
      <div class="inner">
        <h3>--</h3>
        <p>Vehículos Disponibles</p>
      </div>
      <div class="icon"><i class="fas fa-car"></i></div>
      <a href="{{ route('operador.asignacion-directa.create') }}" class="small-box-footer">
        Ver más <i class="fas fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>

  {{-- Viajes Activos --}}
  <div class="col-lg-3 col-6">
    <div class="small-box bg-info">
      <div class="inner">
        <h3>--</h3>
        <p>Viajes Activos</p>
      </div>
      <div class="icon"><i class="fas fa-route"></i></div>
      <a href="{{ route('operador.viajes.index') }}" class="small-box-footer">
        Ver más <i class="fas fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>

  {{-- Mantenimientos Abiertos --}}
  <div class="col-lg-3 col-6">
    <div class="small-box bg-danger">
      <div class="inner">
        <h3>--</h3>
        <p>Mantenimientos Abiertos</p>
      </div>
      <div class="icon"><i class="fas fa-tools"></i></div>
      <a href="{{ route('operador.mantenimientos.index') }}" class="small-box-footer">
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
        <a href="{{ route('operador.solicitudes.index') }}" class="btn btn-warning me-2 mb-2">
          <i class="fas fa-clipboard-list me-1"></i> Ver Solicitudes
        </a>
        <a href="{{ route('operador.asignacion-directa.create') }}" class="btn btn-success me-2 mb-2">
          <i class="fas fa-hand-pointer me-1"></i> Asignación Directa
        </a>
        <a href="{{ route('operador.viajes.create') }}" class="btn btn-info me-2 mb-2">
          <i class="fas fa-route me-1"></i> Registrar Viaje
        </a>
        <a href="{{ route('operador.rutas.index') }}" class="btn btn-secondary me-2 mb-2">
          <i class="fas fa-map-marked-alt me-1"></i> Ver Rutas
        </a>
      </div>
    </div>
  </div>
</div>
@endsection