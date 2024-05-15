<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BuquesController; // Asegúrate de importar el controlador

// Redirigir la raíz a la ruta de inicio de sesión
Route::redirect('/', '/login');

// Agrupación de rutas que requieren autenticación
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        // Puedes pasar los datos de los buques a la vista del dashboard
        $buques = Auth::user()->buques;
        return view('dashboard', compact('buques'));
    })->name('dashboard');

    // Añadir las rutas para Buques dentro del grupo autenticado
    Route::get('/buques', [BuquesController::class, 'index'])->name('buques.index');
    Route::get('/buques/create', [BuquesController::class, 'create'])->name('buques.create');
    Route::post('/buques', [BuquesController::class, 'store'])->name('buques.store');
    Route::delete('/buques/{buque}', [BuquesController::class, 'destroy'])->name('buques.destroy');
});
