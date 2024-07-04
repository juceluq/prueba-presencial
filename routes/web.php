<?php

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
});
