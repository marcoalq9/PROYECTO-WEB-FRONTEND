<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Rutas de autenticación
Route::get('/',       [AuthController::class, 'showLogin'])->name('login');
Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// ==================== ADMIN ====================
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', fn() => view('home'))->name('dashboard');

    // Usuarios
    Route::get('/usuarios',            fn() => view('home'))->name('usuarios.index');
    Route::get('/usuarios/crear',      fn() => view('home'))->name('usuarios.create');
    Route::get('/usuarios/{id}/editar',fn() => view('home'))->name('usuarios.edit');

    // Vehículos
    Route::get('/vehiculos',             fn() => view('home'))->name('vehiculos.index');
    Route::get('/vehiculos/crear',       fn() => view('home'))->name('vehiculos.create');
    Route::get('/vehiculos/{id}/editar', fn() => view('home'))->name('vehiculos.edit');

    // Mantenimientos
    Route::get('/mantenimientos',             fn() => view('home'))->name('mantenimientos.index');
    Route::get('/mantenimientos/crear',       fn() => view('home'))->name('mantenimientos.create');
    Route::get('/mantenimientos/{id}/editar', fn() => view('home'))->name('mantenimientos.edit');

    // Reportes
    Route::get('/reportes/disponibilidad',   fn() => view('home'))->name('reportes.disponibilidad');
    Route::get('/reportes/uso',              fn() => view('home'))->name('reportes.uso');
    Route::get('/reportes/historial-chofer', fn() => view('home'))->name('reportes.historial-chofer');
});

// ==================== OPERADOR ====================
Route::prefix('operador')->name('operador.')->group(function () {
    Route::get('/dashboard', fn() => view('home'))->name('dashboard');

    // Solicitudes
    Route::get('/solicitudes',             fn() => view('home'))->name('solicitudes.index');
    Route::get('/solicitudes/{id}',        fn() => view('home'))->name('solicitudes.show');

    // Asignación directa
    Route::get('/asignacion-directa',      fn() => view('home'))->name('asignacion-directa.create');

    // Viajes
    Route::get('/viajes',                  fn() => view('home'))->name('viajes.index');
    Route::get('/viajes/crear',            fn() => view('home'))->name('viajes.create');

    // Rutas
    Route::get('/rutas',                   fn() => view('home'))->name('rutas.index');
    Route::get('/rutas/crear',             fn() => view('home'))->name('rutas.create');
    Route::get('/rutas/{id}/editar',       fn() => view('home'))->name('rutas.edit');

    // Mantenimientos
    Route::get('/mantenimientos',             fn() => view('home'))->name('mantenimientos.index');
    Route::get('/mantenimientos/crear',       fn() => view('home'))->name('mantenimientos.create');
    Route::get('/mantenimientos/{id}/editar', fn() => view('home'))->name('mantenimientos.edit');
});

// ==================== CHOFER ====================
Route::prefix('chofer')->name('chofer.')->group(function () {
    Route::get('/dashboard', fn() => view('home'))->name('dashboard');

    // Vehículos disponibles
    Route::get('/vehiculos',        fn() => view('home'))->name('vehiculos.index');
    Route::get('/vehiculos/{id}',   fn() => view('home'))->name('vehiculos.show');

    // Solicitudes
    Route::get('/solicitudes',      fn() => view('home'))->name('solicitudes.index');
    Route::get('/solicitudes/crear',fn() => view('home'))->name('solicitudes.create');

    // Historial
    Route::get('/historial',        fn() => view('home'))->name('historial');
});