<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BuquesController;
use App\Http\Controllers\UserController;

// Redirigir la raíz a la ruta de inicio de sesión
Route::redirect('/', '/login');

// Agrupación de rutas que requieren autenticación
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        $buques = Auth::user()->buques;
        return view('dashboard', compact('buques'));
    })->name('dashboard');

    Route::get('/buques/create', [BuquesController::class, 'create'])->name('buques.create');
    Route::post('/buques', [BuquesController::class, 'store'])->name('buques.store');
    Route::get('/buques/{buque}/edit', [BuquesController::class, 'edit'])->name('buques.edit');
    Route::put('/buques/{buque}', [BuquesController::class, 'update'])->name('buques.update');
    Route::delete('/buques/{buque}', [BuquesController::class, 'destroy'])->name('buques.destroy');
    Route::get('/buques/{buque}', [BuquesController::class, 'show'])->name('buques.show');
    Route::get('/buques', [BuquesController::class, 'index'])->name('buques.index');
    Route::get('/buques/{buque}/sistemas-equipos', [BuquesController::class, 'getSistemasEquipos']);

    // Ruta para mostrar los detalles del buque
    Route::get('/buques/{buque}', [BuquesController::class, 'show'])->name('buques.show');

    Route::get('/buques/{buque}/mod_gres', [BuquesController::class, 'showGres'])->name('buques.gres');
    Route::get('/buques/{buque}/mod_fua', [BuquesController::class, 'showFua'])->name('buques.fua');

    // Ruta para actualizar el MEC de un sistema de equipo específico para un buque
    Route::put('/buques/{buque}/sistemas-equipos/{equipo}/mec', [BuquesController::class, 'updateMEC']);

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
});
