<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Iniciar Sesión | Sistema de Flotilla</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('css/adminlte.css') }}">
</head>
<body class="login-page bg-body-secondary">

<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>Sistema</b> Flotilla</a>
  </div>

  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Inicia sesión para continuar</p>

      @if(session('error'))
        <div class="alert alert-danger">
          {{ session('error') }}
        </div>
      @endif

      <form action="{{ route('login.post') }}" method="POST">
        @csrf
        <div class="input-group mb-3">
          <input type="email"
                 name="email"
                 class="form-control @error('email') is-invalid @enderror"
                 placeholder="Correo electrónico"
                 value="{{ old('email') }}"
                 required>
          <div class="input-group-text">
            <span class="fas fa-envelope"></span>
          </div>
          @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="input-group mb-3">
          <input type="password"
                 name="password"
                 class="form-control @error('password') is-invalid @enderror"
                 placeholder="Contraseña"
                 required>
          <div class="input-group-text">
            <span class="fas fa-lock"></span>
          </div>
          @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary w-100">
              <i class="fas fa-sign-in-alt me-1"></i> Iniciar Sesión
            </button>
          </div>
        </div>
      </form>

    </div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/adminlte.js') }}"></script>
</body>
</html>