@extends('layouts.dashboard')

@section('title', 'Dashboard - Chofer')
@section('page_title', 'Dashboard')

@section('content')
<div class="row">
  {{-- Mis Solicitudes --}}
  <div class="col-lg-4 col-6">
    <div class="small-box bg-info">
      <div class="inner">
        <h3>--</h3>
        <p>Mis Solicitudes</p>
      </div>
      <div class="icon"><i class="fas fa-file-alt"></i></div>
      <a href="{{ route('chofer.solicitudes.index') }}" class="small-box-footer">
        Ver más <i class="fas fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>

  {{-- Vehículos Disponibles --}}
  <div class="col-lg-4 col-6">
    <div class="small-box bg-success">
      <div class="inner">
        <h3>--</h3>
        <p>Vehículos Disponibles</p>
      </div>
      <div class="icon"><i class="fas fa-car"></i></div>
      <a href="{{ route('chofer.vehiculos.index') }}" class="small-box-footer">
        Ver más <i class="fas fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>

  {{-- Mi Historial --}}
  <div class="col-lg-4 col-6">
    <div class="small-box bg-warning">
      <div class="inner">
        <h3>--</h3>
        <p>Viajes Realizados</p>
      </div>
      <div class="icon"><i class="fas fa-history"></i></div>
      <a href="{{ route('chofer.historial') }}" class="small-box-footer">
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
        <a href="{{ route('chofer.vehiculos.index') }}" class="btn btn-success me-2 mb-2">
          <i class="fas fa-car me-1"></i> Ver Vehículos Disponibles
        </a>
        <a href="{{ route('chofer.solicitudes.create') }}" class="btn btn-info me-2 mb-2">
          <i class="fas fa-plus me-1"></i> Nueva Solicitud
        </a>
        <a href="{{ route('chofer.historial') }}" class="btn btn-warning me-2 mb-2">
          <i class="fas fa-history me-1"></i> Mi Historial
        </a>
      </div>
    </div>
  </div>
</div>
@endsection