<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    EntidadController,
    ObjetivoDesarrolloSostenibleController,
    ObjetivoPlanNacionalController,
    MetaEstrategicaController,
    MetaPlanNacionalController,
    ObjetivoEstrategicoController,
    IndicadorController,
    AuditoriaController,
    PersonaController,
    PlanController,
    ProgramaController,
    ProyectoController,
    ProfileController,
    RevisionController,
    AutoridadController,
    Auth\TwoFactorController
};

// Solo una ruta raíz
Route::get('/', function () {
    return view('home');
});
// Estas rutas no requieren MFA todavía
Route::middleware(['auth'])->group(function () {
    Route::get('/two-factor-challenge', [TwoFactorController::class, 'showChallengeForm'])->name('two-factor.challenge');
    Route::post('/two-factor-challenge', [TwoFactorController::class, 'verifyChallenge'])->name('two-factor.verify'); 
});


// Rutas protegidas por login + MFA
 Route::middleware(['auth'/* ,'two_factor_verified' */])->group(function () { 
    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');

    // Dashboards por rol
    Route::get('/dashboard/admin', fn() => view('dashboard.admin'))->name('dashboard.admin');
    Route::get('/dashboard/tecnico', fn() => view('dashboard.tecnico'))->name('dashboard.tecnico');
    Route::get('/dashboard/revisor', fn() => view('dashboard.revisor'))->name('dashboard.revisor');
    Route::get('/dashboard/autoridad', fn() => view('dashboard.autoridad'))->name('dashboard.autoridad');
    Route::get('/dashboard/externo', fn() => view('dashboard.externo'))->name('dashboard.externo');
    Route::get('/dashboard/auditor', fn() => view('dashboard.auditor'))->name('dashboard.auditor');
    Route::get('/revision', [RevisionController::class, 'index'])->name('revision.index');
    Route::put('/revision/{tipo}/{id}/estado_revision', [RevisionController::class, 'cambiarEstado'])->name('revision.estado');
    Route::get('/autoridad', [AutoridadController::class, 'index'])->name('autoridad.index');
    Route::put('/autoridad/{tipo}/{id}/estado_autoridad', [AutoridadController::class, 'cambiarEstado'])->name('autoridad.estado');
    Route::get('/bitacora', [AuditoriaController::class, 'index'])->name('auditoria.index');

    // Módulos protegidos
    Route::resources([
        'persona' => PersonaController::class,
        'entidad' => EntidadController::class,
        'plan' => PlanController::class,
        'proyecto' => ProyectoController::class,
        'programa' => ProgramaController::class,
        'objetivoEstrategico' => ObjetivoEstrategicoController::class,
        'objetivoDesarrolloSostenible' => ObjetivoDesarrolloSostenibleController::class,
        'objetivoPlanNacional' => ObjetivoPlanNacionalController::class,
        'metaEstrategica' => MetaEstrategicaController::class,
        'metaPlanNacional' => MetaPlanNacionalController::class,
        'indicador' => IndicadorController::class,
        'auditoria' => AuditoriaController::class,
    ]);

    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
  });  




Route::put('/entidad/{entidad}', [EntidadController::class, 'update'])->name('entidad.update');
Route::put('/plan/{plan}', [PlanController::class, 'update'])->name('plan.update');
// Breeze o Fortify auth routes
require __DIR__.'/auth.php';




