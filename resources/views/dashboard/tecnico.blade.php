@extends('layouts.master')
@section('title', 'Panel del Técnico')
@section('content')
<div class="flex min-h-screen bg-gray-50">
    {{-- Menú Lateral Mejorado --}}
    <aside class="w-64 bg-blue-100 p-6 shadow-xl border-r border-gray-200">
        <h3 class="text-xl font-extrabold text-blue-800 mb-6 border-b pb-2">
            Panel Técnico
        </h3>
        
        {{-- Sección: Gestión de Objetivos --}}
        <div class="mb-8">
            <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">
                Gestión de Objetivos
            </p>
            <nav class="space-y-2">
                <a href="{{ route('objetivoDesarrolloSostenible.index') }}" 
                   class="flex items-center p-3 text-blue-700 font-medium rounded-lg hover:bg-blue-50 transition duration-150 ease-in-out border border-transparent hover:border-blue-300 group">
                    <i class="fas fa-globe-americas w-5 h-5 mr-3 group-hover:scale-110 transition-transform"></i>
                    <span>Objetivos ODS</span>
                </a>
                
                <a href="{{ route('objetivoPlanNacional.index') }}" 
                   class="flex items-center p-3 text-blue-700 font-medium rounded-lg hover:bg-blue-50 transition duration-150 ease-in-out border border-transparent hover:border-blue-300 group">
                    <i class="fas fa-flag w-5 h-5 mr-3 group-hover:scale-110 transition-transform"></i>
                    <span>Objetivos PND</span>
                </a>
                
                <a href="{{ route('objetivoEstrategico.index') }}" 
                   class="flex items-center p-3 text-blue-700 font-medium rounded-lg hover:bg-blue-50 transition duration-150 ease-in-out border border-transparent hover:border-blue-300 group">
                    <i class="fas fa-bullseye w-5 h-5 mr-3 group-hover:scale-110 transition-transform"></i>
                    <span>Objetivos Estratégicos</span>
                </a>
            </nav>
        </div>
        
        {{-- Sección: Gestión de Metas --}}
        <div class="mb-8">
            <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">
                Gestión de Metas
            </p>
            <nav class="space-y-2">
                <a href="{{ route('metaEstrategica.index') }}" 
                   class="flex items-center p-3 text-blue-700 font-medium rounded-lg hover:bg-blue-50 transition duration-150 ease-in-out border border-transparent hover:border-blue-300 group">
                    <i class="fas fa-chart-line w-5 h-5 mr-3 group-hover:scale-110 transition-transform"></i>
                    <span>Metas Estratégicas</span>
                </a>
                <a href="{{ route('metaPlanNacional.index') }}" 
                   class="flex items-center p-3 text-blue-700 font-medium rounded-lg hover:bg-blue-50 transition duration-150 ease-in-out border border-transparent hover:border-blue-300 group">
                    <i class="fas fa-chart-bar w-5 h-5 mr-3 group-hover:scale-110 transition-transform"></i>
                    <span>Metas Plan Nacional</span>
                </a>
            </nav>
        </div>
        
        {{-- Sección: Indicadores --}}
        <div class="mb-8">
            <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">
                Indicadores
            </p>
            <nav class="space-y-2">
                <a href="{{ route('indicador.index') }}" 
                   class="flex items-center p-3 text-blue-700 font-medium rounded-lg hover:bg-blue-50 transition duration-150 ease-in-out border border-transparent hover:border-blue-300 group">
                    <i class="fas fa-chart-pie w-5 h-5 mr-3 group-hover:scale-110 transition-transform"></i>
                    <span>Gestión de Indicadores</span>
                </a>
            </nav>
        </div>
        
        {{-- Área de usuario --}}
        <div class="mt-8 pt-4 border-t border-gray-200">
            <p class="text-sm text-gray-500">Sesión iniciada como:</p>
            <p class="font-semibold text-gray-700">{{ Auth::user()->name }}</p>
            <p class="text-xs text-blue-600 font-medium mt-1"> Técnico Institucional</p>
        </div>
    </aside>
    
    {{-- Contenido principal --}}
    <main class="flex-1 p-8">
        <header class="mb-8 border-b pb-4">
            <h1 class="text-3xl font-light text-gray-800">
                Panel Técnico, <span class="font-bold text-orange-600">{{ Auth::user()->name }}</span>
            </h1>
            <p class="text-gray-500 mt-1">
                Gestiona los componentes estratégicos y técnicos del sistema desde este panel.
            </p>
        </header>
        
        {{-- Contenido principal --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            {{-- Tarjeta de Objetivos ODS --}}
            <a href="{{ route('objetivoDesarrolloSostenible.index') }}" 
               class="p-6 bg-white rounded-xl shadow-lg border-t-2 border-green-500 hover:shadow-xl transition duration-200 ease-in-out transform hover:-translate-y-1">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-globe-americas text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Objetivos ODS</h3>
                        <p class="text-sm text-gray-500">Objetivos de Desarrollo Sostenible</p>
                    </div>
                </div>
                <p class="text-gray-600 text-sm">Gestiona los 17 objetivos de desarrollo sostenible establecidos por la ONU.</p>
            </a>
            
            {{-- Tarjeta de Objetivos PND --}}
            <a href="{{ route('objetivoPlanNacional.index') }}" 
               class="p-6 bg-white rounded-xl shadow-lg border-t-2 border-blue-500 hover:shadow-xl transition duration-200 ease-in-out transform hover:-translate-y-1">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-flag text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Objetivos PND</h3>
                        <p class="text-sm text-gray-500">Plan Nacional de Desarrollo</p>
                    </div>
                </div>
                <p class="text-gray-600 text-sm">Administra los objetivos del plan nacional de desarrollo del país.</p>
            </a>
            
            {{-- Tarjeta de Objetivos Estratégicos --}}
            <a href="{{ route('objetivoEstrategico.index') }}" 
               class="p-6 bg-white rounded-xl shadow-lg border-t-2 border-purple-500 hover:shadow-xl transition duration-200 ease-in-out transform hover:-translate-y-1">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-bullseye text-purple-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Objetivos Estratégicos</h3>
                        <p class="text-sm text-gray-500">Estrategias Institucionales</p>
                    </div>
                </div>
                <p class="text-gray-600 text-sm">Gestiona los objetivos estratégicos de la institución.</p>
            </a>
            
            {{-- Tarjeta de Metas Estratégicas --}}
            <a href="{{ route('metaEstrategica.index') }}" 
               class="p-6 bg-white rounded-xl shadow-lg border-t-2 border-yellow-500 hover:shadow-xl transition duration-200 ease-in-out transform hover:-translate-y-1">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-chart-line text-yellow-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Metas Estratégicas</h3>
                        <p class="text-sm text-gray-500">Metas de Planificación</p>
                    </div>
                </div>
                <p class="text-gray-600 text-sm">Define y gestiona las metas estratégicas institucionales.</p>
            </a>
            
            {{-- Tarjeta de Metas Plan Nacional --}}
            <a href="{{ route('metaPlanNacional.index') }}" 
               class="p-6 bg-white rounded-xl shadow-lg border-t-2 border-red-500 hover:shadow-xl transition duration-200 ease-in-out transform hover:-translate-y-1">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-chart-bar text-red-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Metas PND</h3>
                        <p class="text-sm text-gray-500">Metas Nacionales</p>
                    </div>
                </div>
                <p class="text-gray-600 text-sm">Administra las metas establecidas en el plan nacional de desarrollo.</p>
            </a>
            
            {{-- Tarjeta de Indicadores --}}
            <a href="{{ route('indicador.index') }}" 
               class="p-6 bg-white rounded-xl shadow-lg border-t-2 border-blue-500 hover:shadow-xl transition duration-200 ease-in-out transform hover:-translate-y-1">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-chart-pie text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Indicadores</h3>
                        <p class="text-sm text-gray-500">Seguimiento y Evaluación</p>
                    </div>
                </div>
                <p class="text-gray-600 text-sm">Gestiona los indicadores de seguimiento y evaluación.</p>
            </a>
        </div>

        {{-- Sección de alerta --}}
        <div class="p-6 bg-blue-50 border-l-4 border-blue-500 rounded-r-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-info-circle text-blue-500 text-xl mt-1"></i>
                </div>
                <div class="ml-3">
                    <h4 class="text-lg font-semibold text-blue-800">Instrucciones Técnicas</h4>
                    <p class="text-sm text-blue-700 mt-1">
                        Como técnico institucional, tu responsabilidad es garantizar que todos los objetivos, metas e indicadores 
                        estén correctamente configurados y alineados con las políticas institucionales y nacionales.
                    </p>
                    <div class="mt-3 text-sm text-blue-600">
                        <p><strong>Recomendaciones:</strong></p>
                        <ul class="list-disc ml-5 mt-1 space-y-1">
                            <li>Verifica la consistencia entre objetivos ODS y PND</li>
                            <li>Asegura que los indicadores sean medibles y alcanzables</li>
                            <li>Mantén actualizada la información estratégica</li>
                            <li>Reporta inconsistencias al administrador del sistema</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

{{-- Íconos Font Awesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
@endsection