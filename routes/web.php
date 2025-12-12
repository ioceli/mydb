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
Route::middleware(['auth', 'two_factor_verified'])->group(function () { 
    // Dashboard principal (accesible por todos)
    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');

    //  ADMINISTRADOR DEL SISTEMA
    Route::middleware(['role:Administrador del Sistema'])->group(function () {
        Route::get('/dashboard/admin', fn() => view('dashboard.admin'))->name('dashboard.admin');
        
        // Módulos exclusivos de admin
        Route::resource('persona', PersonaController::class);
        Route::resource('entidad', EntidadController::class);
    });

    //  TÉCNICO DE PLANIFICACIÓN
    Route::middleware(['role:Técnico de Planificación'])->group(function () {
        Route::get('/dashboard/tecnico', fn() => view('dashboard.tecnico'))->name('dashboard.tecnico');
        
        // Módulos de planificación
        Route::resource('objetivoDesarrolloSostenible', ObjetivoDesarrolloSostenibleController::class);
        Route::resource('objetivoEstrategico', ObjetivoEstrategicoController::class);
        Route::resource('objetivoPlanNacional', ObjetivoPlanNacionalController::class);
        Route::resource('metaEstrategica', MetaEstrategicaController::class);
        Route::resource('metaPlanNacional', MetaPlanNacionalController::class);
        Route::resource('indicador', IndicadorController::class);
    });

    //  REVISOR INSTITUCIONAL
    Route::middleware(['role:Revisor Institucional'])->group(function () {
        Route::get('/dashboard/revisor', [RevisionController::class, 'dashboard'])->name('dashboard.revisor');
        
        // Módulo de revisión
        Route::get('/revision', [RevisionController::class, 'index'])->name('revision.index');
        Route::get('/revision/detalle/{tipo}/{id}', [RevisionController::class, 'getDetalle'])->name('revision.detalle');
        Route::get('/revision/pdf/{tipo}/{id}', [RevisionController::class, 'downloadPdf'])->name('revision.download');
        Route::put('/revision/{tipo}/{id}/estado_revision', [RevisionController::class, 'cambiarEstado'])->name('revision.estado');
    });

    //  AUTORIDAD VALIDANTE
    Route::middleware(['role:Autoridad Validante'])->group(function () {
        Route::get('/dashboard/autoridad', fn() => view('dashboard.autoridad'))->name('dashboard.autoridad');
        
        // Módulo de autoridad
        Route::get('/autoridad', [AutoridadController::class, 'index'])->name('autoridad.index');
        Route::put('/autoridad/{tipo}/{id}/estado_autoridad', [AutoridadController::class, 'cambiarEstado'])->name('autoridad.estado');
    });

    //  USUARIO EXTERNO
    Route::middleware(['role:Usuario Externo'])->group(function () {
        Route::get('/dashboard/externo', [App\Http\Controllers\ExternoController::class, 'index'])->name('dashboard.externo');
        
        // Módulos de consulta externa
        Route::resource('plan', PlanController::class)->only(['index', 'show']);
        Route::resource('programa', ProgramaController::class)->only(['index', 'show']);
        Route::resource('proyecto', ProyectoController::class)->only(['index', 'show']);
    });

    //  AUDITOR
    Route::middleware(['role:Auditor'])->group(function () {
        Route::get('/dashboard/auditor', fn() => view('dashboard.auditor'))->name('dashboard.auditor');
        
        // Módulo de auditoría
        Route::get('/auditoria', [AuditoriaController::class, 'index'])->name('auditoria.index');
        Route::get('/auditoria/pdf', [AuditoriaController::class, 'exportPdf'])->name('auditoria.pdf');
        Route::get('/auditoria/excel', [AuditoriaController::class, 'exportExcel'])->name('auditoria.excel');
    });
    
    // PERFIL (accesible por todos los roles)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Breeze o Fortify auth routes
require __DIR__.'/auth.php';