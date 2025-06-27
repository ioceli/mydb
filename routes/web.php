<?php

use App\Http\Controllers\EntidadController;
use App\Http\Controllers\PersonaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('inicio');
})->name('inicio');

//  REDIRECCION AL INICIO
Route::get('/home', function () {
    return view('inicio');
});

//RUTA PARA MODULO ENTIDAD
Route::resource('entidad', EntidadController::class);
//RUTA PARA MODULO PERSONA
Route::resource('persona', PersonaController::class);