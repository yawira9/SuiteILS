<?php

use Illuminate\Support\Facades\Route;

// Redirigir la raíz a la ruta de inicio de sesión
Route::redirect('/', '/login');

// Agrupación de rutas que requieren autenticación
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

