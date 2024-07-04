<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes();
Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('index');
    })->name('index');
});
