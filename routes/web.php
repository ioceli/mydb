<?php
use App\Http\Controllers\EntidadController;
use App\Http\Controllers\ObjetivoDesarrolloSostenibleController;
use App\Http\Controllers\ObjetivoPlanNacionalController;
use App\Http\Controllers\MetaEstrategicaController;
use App\Http\Controllers\MetaPlanNacionalController;
use App\Http\Controllers\ObjetivoEstrategicoController;
use App\Http\Controllers\IndicadorController;
use App\Http\Controllers\AuditoriaController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\PlanController;

use App\Http\Controllers\ProgramaController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('home');
}); 

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
//RUTA PARA MODULO PERSONA
Route::resource('persona', PersonaController::class);
Route::resource('entidad', EntidadController::class);
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
//RUTA PARA MODULO INDICADOR
Route::resource('indicador', IndicadorController::class);
//RUTA PARA MODULO AUDITORIA
Route::resource('auditoria', AuditoriaController::class);
    Route::get('/dashboard/admin', fn() => view('dashboard.admin'))->name('dashboard.admin');
    Route::get('/dashboard/tecnico', fn() => view('dashboard.tecnico'))->name('dashboard.tecnico');
    Route::get('/dashboard/revisor', fn() => view('dashboard.revisor'))->name('dashboard.revisor');
    Route::get('/dashboard/autoridad', fn() => view('dashboard.autoridad'))->name('dashboard.autoridad');
    Route::get('/dashboard/externo', fn() => view('dashboard.externo'))->name('dashboard.externo');
    Route::get('/dashboard/auditor', fn() => view('dashboard.auditor'))->name('dashboard.auditor');
    Route::get('/dashboard/desarrollador', fn() => view('dashboard.desarrollador'))->name('dashboard.desarrollador');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';



