<?php

use App\Http\Controllers\EventoController;
use App\Http\Controllers\TipoEventoController;
use App\Http\Controllers\UserController;
use App\Models\Evento;
use App\Models\TipoEvento;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes();

// TODO Rutas protegidas por autenticación
Route::middleware('auth')->group(function () {

    //TODO Ruta de index 
    Route::get('/', function () {

        if (Auth::check() && !Auth::user()->activado) {
            Auth::logout();
            return redirect('/login')->with('alert', [
                'type' => 'danger',
                'message' => 'Debes activar tu cuenta para acceder al sistema.'
            ]);
        }

        $tipoEventos = TipoEvento::all();
        $eventos = Evento::all();
        return view('index', compact('tipoEventos', 'eventos'));
    })->name('index');

    //TODO Rutas para los usuarios
    Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios');
    Route::get('/usuarios/search', [UserController::class, 'search'])->name('usuarios.search');
    Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.store');
    Route::delete('/usuarios/{id}', [UserController::class, 'destroy'])->name('usuarios.destroy');
    Route::put('/usuario', [UserController::class, 'update'])->name('usuarios.update');

    //TODO Rutas para los tipos de eventos
    Route::get('/tipo_eventos', [TipoEventoController::class, 'index'])->name('tipo_eventos');
    Route::get('/tipo_eventos/search', [TipoEventoController::class, 'search'])->name('tipo_eventos.search');
    Route::post('/tipo_eventos', [TipoEventoController::class, 'store'])->name('tipo_eventos.store');
    Route::delete('/tipo_eventos/{id}', [TipoEventoController::class, 'destroy'])->name('tipo_eventos.destroy');
    Route::put('/tipo_evento', [TipoEventoController::class, 'update'])->name('tipo_eventos.update');


    //TODO Rutas para los eventos
    Route::post('/eventos', [EventoController::class, 'store'])->name('eventos.store');
    Route::put('/evento', [EventoController::class, 'update'])->name('eventos.update');
    Route::delete('/eventos/{id}', [EventoController::class, 'destroy'])->name('eventos.destroy');
    Route::get('/apiGetEventos', [EventoController::class, 'apiGetEventos'])->name('apiGetEvent');
});
