<?php

use App\Http\Controllers\EventoController;
use App\Http\Controllers\TipoEventoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes();
Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('index');
    })->name('index');
    Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios');
    Route::get('/usuarios/search', [UserController::class, 'search'])->name('usuarios.search');
    Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.store');
    Route::delete('/usuarios/{id}', [UserController::class, 'destroy'])->name('usuarios.destroy');
    Route::put('/usuario', [UserController::class, 'update'])->name('usuarios.update');

    Route::get('/tipo_eventos', [TipoEventoController::class, 'index'])->name('tipo_eventos');
    Route::get('/tipo_eventos/search', [TipoEventoController::class, 'search'])->name('tipo_eventos.search');
    Route::post('/tipo_eventos', [TipoEventoController::class, 'store'])->name('tipo_eventos.store');
    Route::delete('/tipo_eventos/{id}', [TipoEventoController::class, 'destroy'])->name('tipo_eventos.destroy');
    Route::put('/tipo_evento', [TipoEventoController::class, 'update'])->name('tipo_eventos.update');

    Route::get('/apiGetEventos', [EventoController::class, 'apiGetEventos'])->name('apiGetEvent');
});
