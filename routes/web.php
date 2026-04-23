<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Rutas de autenticación
Route::get('/',       [AuthController::class, 'showLogin'])->name('login');
Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas temporales de dashboard (las expandiremos después)
Route::get('/admin/dashboard',    fn() => view('home'))->name('admin.dashboard');
Route::get('/operador/dashboard', fn() => view('home'))->name('operador.dashboard');
Route::get('/chofer/dashboard',   fn() => view('home'))->name('chofer.dashboard');