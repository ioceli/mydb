<?php

use App\Http\Controllers\EntidadController;
use App\Http\Controllers\ObjetivoDesarrolloSostenibleController;
use App\Http\Controllers\ObjetivoPlanNacionalController;
use App\Http\Controllers\MetaEstrategicaController;
use App\Http\Controllers\MetaPlanNacionalController;
use App\Http\Controllers\ObjetivoEstrategicoController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ProgramaController;
use App\Http\Controllers\ProyectoController;
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
//RUTA PARA MODULO PLAN
Route::resource('plan', PlanController::class);
//RUTA PARA MODULO PROYECTO
Route::resource('proyecto', ProyectoController::class);
//RUTA PARA MODULO PROGRAMA
Route::resource('programa', ProgramaController::class);
//RUTA PARA MODULO OBJETIVO ESTRATEGICO
Route::resource('objetivoEstrategico', ObjetivoEstrategicoController::class);
//RUTA PARA MODULO OBJETIVO DESARROLLO SOSTENIBLE
Route::resource('objetivoDesarrolloSostenible', ObjetivoDesarrolloSostenibleController::class);
//RUTA PARA MODULO OBJETIVO PLAN NACIONAL
Route::resource('objetivoPlanNacional', ObjetivoPlanNacionalController::class);
//RUTA PARA MODULO META ESTRATEGICA
Route::resource('metaEstrategica', MetaEstrategicaController::class);
//RUTA PARA MODULO META PLAN NACIONAL
Route::resource('metaPlanNacional', MetaPlanNacionalController::class);