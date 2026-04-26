<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\Admin\VehiculoController;
use App\Http\Controllers\Admin\MantenimientoController;
use App\Http\Controllers\Operador\SolicitudController;
use App\Http\Controllers\Operador\AsignacionDirectaController;
use App\Http\Controllers\Operador\RutaController;
use App\Http\Controllers\Operador\ViajeController;
use App\Http\Controllers\Chofer\VehiculoController as ChoferVehiculoController;
use App\Http\Controllers\Chofer\SolicitudController as ChoferSolicitudController;
use App\Http\Controllers\Chofer\HistorialController;
use App\Http\Controllers\Admin\ReporteController;
use App\Http\Controllers\Operador\MantenimientoController as OperadorMantenimientoController;

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
    Route::patch('/usuarios/{id}/activar', [UsuarioController::class, 'restore'])->name('usuarios.restore');

    // Vehículos
    Route::get('/vehiculos',             [VehiculoController::class, 'index'])->name('vehiculos.index');
    Route::get('/vehiculos/crear',       [VehiculoController::class, 'create'])->name('vehiculos.create');
    Route::post('/vehiculos',            [VehiculoController::class, 'store'])->name('vehiculos.store');
    Route::get('/vehiculos/{id}/editar', [VehiculoController::class, 'edit'])->name('vehiculos.edit');
    Route::put('/vehiculos/{id}',        [VehiculoController::class, 'update'])->name('vehiculos.update');
    Route::delete('/vehiculos/{id}',     [VehiculoController::class, 'destroy'])->name('vehiculos.destroy');
    Route::patch('/vehiculos/{id}/activar', [VehiculoController::class, 'restore'])->name('vehiculos.restore');

    // Mantenimientos
    Route::get('/mantenimientos',              [MantenimientoController::class, 'index'])->name('mantenimientos.index');
    Route::get('/mantenimientos/crear',        [MantenimientoController::class, 'create'])->name('mantenimientos.create');
    Route::post('/mantenimientos',             [MantenimientoController::class, 'store'])->name('mantenimientos.store');
    Route::get('/mantenimientos/{id}/editar',  [MantenimientoController::class, 'edit'])->name('mantenimientos.edit');
    Route::put('/mantenimientos/{id}',         [MantenimientoController::class, 'update'])->name('mantenimientos.update');
    Route::patch('/mantenimientos/{id}/cerrar',[MantenimientoController::class, 'cerrar'])->name('mantenimientos.cerrar');
    Route::delete('/mantenimientos/{id}',      [MantenimientoController::class, 'destroy'])->name('mantenimientos.destroy');
    Route::patch('/mantenimientos/{id}/activar',[MantenimientoController::class, 'restore'])->name('mantenimientos.restore');

    // Reportes
    Route::get('/reportes/disponibilidad',   [ReporteController::class, 'disponibilidad'])->name('reportes.disponibilidad');
    Route::get('/reportes/uso',              [ReporteController::class, 'uso'])->name('reportes.uso');
    Route::get('/reportes/historial-chofer', [ReporteController::class, 'historialChofer'])->name('reportes.historial-chofer');
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

    // Viajes
    Route::get('/viajes',                      [ViajeController::class, 'index'])->name('viajes.index');
    Route::get('/viajes/crear',                [ViajeController::class, 'create'])->name('viajes.create');
    Route::get('/viajes/chofer/{id}/vehiculos-aprobados', [ViajeController::class, 'vehiculosAprobados'])->name('viajes.vehiculos-aprobados');
    Route::post('/viajes',                     [ViajeController::class, 'store'])->name('viajes.store');
    Route::patch('/viajes/{id}/retorno',       [ViajeController::class, 'registrarRetorno'])->name('viajes.retorno');

    // Rutas
    Route::get('/rutas',             [RutaController::class, 'index'])->name('rutas.index');
    Route::get('/rutas/crear',       [RutaController::class, 'create'])->name('rutas.create');
    Route::post('/rutas',            [RutaController::class, 'store'])->name('rutas.store');
    Route::get('/rutas/{id}/editar', [RutaController::class, 'edit'])->name('rutas.edit');
    Route::put('/rutas/{id}',        [RutaController::class, 'update'])->name('rutas.update');
    Route::delete('/rutas/{id}',     [RutaController::class, 'destroy'])->name('rutas.destroy');

    // Mantenimientos
    Route::get('/mantenimientos',              [OperadorMantenimientoController::class, 'index'])->name('mantenimientos.index');
    Route::get('/mantenimientos/crear',        [OperadorMantenimientoController::class, 'create'])->name('mantenimientos.create');
    Route::post('/mantenimientos',             [OperadorMantenimientoController::class, 'store'])->name('mantenimientos.store');
    Route::get('/mantenimientos/{id}/editar',  [OperadorMantenimientoController::class, 'edit'])->name('mantenimientos.edit');
    Route::put('/mantenimientos/{id}',         [OperadorMantenimientoController::class, 'update'])->name('mantenimientos.update');
    Route::patch('/mantenimientos/{id}/cerrar',[OperadorMantenimientoController::class, 'cerrar'])->name('mantenimientos.cerrar');
    Route::delete('/mantenimientos/{id}',      [OperadorMantenimientoController::class, 'destroy'])->name('mantenimientos.destroy');
});

// ==================== CHOFER ====================
Route::prefix('chofer')->name('chofer.')->middleware('sesion:chofer')->group(function () {
    Route::get('/dashboard', fn() => view('chofer.dashboard'))->name('dashboard');

    // Vehículos disponibles
    Route::get('/vehiculos',         [ChoferVehiculoController::class, 'index'])->name('vehiculos.index');
    Route::get('/vehiculos/{id}',    [ChoferVehiculoController::class, 'show'])->name('vehiculos.show');

    // Solicitudes
    Route::get('/solicitudes',                    [ChoferSolicitudController::class, 'index'])->name('solicitudes.index');
    Route::get('/solicitudes/crear',              [ChoferSolicitudController::class, 'create'])->name('solicitudes.create');
    Route::post('/solicitudes',                   [ChoferSolicitudController::class, 'store'])->name('solicitudes.store');
    Route::patch('/solicitudes/{id}/cancelar',    [ChoferSolicitudController::class, 'cancelar'])->name('solicitudes.cancelar');

    // Historial
    Route::get('/historial', [HistorialController::class, 'index'])->name('historial');
});
