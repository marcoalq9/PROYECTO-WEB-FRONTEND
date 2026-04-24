<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\Admin\VehiculoController;
use App\Http\Controllers\Admin\MantenimientoController;
use App\Http\Controllers\Operador\SolicitudController;
use App\Http\Controllers\Operador\AsignacionDirectaController;

// Rutas de autenticación
Route::get('/',       [AuthController::class, 'showLogin'])->name('login');
Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// ==================== ADMIN ====================
Route::prefix('admin')->name('admin.')->middleware('sesion:admin')->group(function () {
    Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');

    // Usuarios
    Route::get('/usuarios',                [UsuarioController::class, 'index'])->name('usuarios.index');
    Route::get('/usuarios/crear',          [UsuarioController::class, 'create'])->name('usuarios.create');
    Route::post('/usuarios',               [UsuarioController::class, 'store'])->name('usuarios.store');
    Route::get('/usuarios/{id}/editar',    [UsuarioController::class, 'edit'])->name('usuarios.edit');
    Route::put('/usuarios/{id}',           [UsuarioController::class, 'update'])->name('usuarios.update');
    Route::delete('/usuarios/{id}',        [UsuarioController::class, 'destroy'])->name('usuarios.destroy');

    // Vehículos
    Route::get('/vehiculos',             [VehiculoController::class, 'index'])->name('vehiculos.index');
    Route::get('/vehiculos/crear',       [VehiculoController::class, 'create'])->name('vehiculos.create');
    Route::post('/vehiculos',            [VehiculoController::class, 'store'])->name('vehiculos.store');
    Route::get('/vehiculos/{id}/editar', [VehiculoController::class, 'edit'])->name('vehiculos.edit');
    Route::put('/vehiculos/{id}',        [VehiculoController::class, 'update'])->name('vehiculos.update');
    Route::delete('/vehiculos/{id}',     [VehiculoController::class, 'destroy'])->name('vehiculos.destroy');

    // Mantenimientos
    Route::get('/mantenimientos',              [MantenimientoController::class, 'index'])->name('mantenimientos.index');
    Route::get('/mantenimientos/crear',        [MantenimientoController::class, 'create'])->name('mantenimientos.create');
    Route::post('/mantenimientos',             [MantenimientoController::class, 'store'])->name('mantenimientos.store');
    Route::get('/mantenimientos/{id}/editar',  [MantenimientoController::class, 'edit'])->name('mantenimientos.edit');
    Route::put('/mantenimientos/{id}',         [MantenimientoController::class, 'update'])->name('mantenimientos.update');
    Route::patch('/mantenimientos/{id}/cerrar',[MantenimientoController::class, 'cerrar'])->name('mantenimientos.cerrar');
    Route::delete('/mantenimientos/{id}',      [MantenimientoController::class, 'destroy'])->name('mantenimientos.destroy');

    Route::get('/reportes/disponibilidad',   fn() => view('home'))->name('reportes.disponibilidad');
    Route::get('/reportes/uso',              fn() => view('home'))->name('reportes.uso');
    Route::get('/reportes/historial-chofer', fn() => view('home'))->name('reportes.historial-chofer');
});

// ==================== OPERADOR ====================
Route::prefix('operador')->name('operador.')->middleware('sesion:operador')->group(function () {
    Route::get('/dashboard', fn() => view('operador.dashboard'))->name('dashboard');

    // Solicitudes
    Route::get('/solicitudes',                [SolicitudController::class, 'index'])->name('solicitudes.index');
    Route::get('/solicitudes/{id}',           [SolicitudController::class, 'show'])->name('solicitudes.show');
    Route::patch('/solicitudes/{id}/aprobar', [SolicitudController::class, 'aprobar'])->name('solicitudes.aprobar');
    Route::patch('/solicitudes/{id}/rechazar',[SolicitudController::class, 'rechazar'])->name('solicitudes.rechazar');

    // Asignación directa
    Route::get('/asignacion-directa',         [AsignacionDirectaController::class, 'create'])->name('asignacion-directa.create');
    Route::post('/asignacion-directa',        [AsignacionDirectaController::class, 'store'])->name('asignacion-directa.store');

    Route::get('/viajes',                   fn() => view('home'))->name('viajes.index');
    Route::get('/viajes/crear',             fn() => view('home'))->name('viajes.create');

    Route::get('/rutas',                    fn() => view('home'))->name('rutas.index');
    Route::get('/rutas/crear',              fn() => view('home'))->name('rutas.create');
    Route::get('/rutas/{id}/editar',        fn() => view('home'))->name('rutas.edit');

    Route::get('/mantenimientos',             fn() => view('home'))->name('mantenimientos.index');
    Route::get('/mantenimientos/crear',       fn() => view('home'))->name('mantenimientos.create');
    Route::get('/mantenimientos/{id}/editar', fn() => view('home'))->name('mantenimientos.edit');
});

// ==================== CHOFER ====================
Route::prefix('chofer')->name('chofer.')->middleware('sesion:chofer')->group(function () {
    Route::get('/dashboard', fn() => view('chofer.dashboard'))->name('dashboard');

    Route::get('/vehiculos',         fn() => view('home'))->name('vehiculos.index');
    Route::get('/vehiculos/{id}',    fn() => view('home'))->name('vehiculos.show');

    Route::get('/solicitudes',       fn() => view('home'))->name('solicitudes.index');
    Route::get('/solicitudes/crear', fn() => view('home'))->name('solicitudes.create');

    Route::get('/historial',         fn() => view('home'))->name('historial');
});