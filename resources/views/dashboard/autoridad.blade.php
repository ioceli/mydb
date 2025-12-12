@extends('layouts.master')

@section('title', 'Panel de la Autoridad')

@section('content')
<div class="flex min-h-screen bg-gray-50">

    {{-- Menú Lateral --}}
    <x-autoridad-sidebar/>

    {{-- Contenido principal --}}
    <main class="flex-1 p-8">
        <header class="mb-8 border-b pb-4">
            <h1 class="text-3xl font-light text-gray-800">
                Panel de Autoridad, <span class="font-bold text-orange-600">{{ Auth::user()->name }}</span>
            </h1>
            <p class="text-gray-500 mt-1">
                Aprueba, revisa y gestiona los planes institucionales desde este panel.
            </p>
        </header>

      {{-- ESTADÍSTICAS DE PLANES --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

    {{-- PLANES PENDIENTES --}}
    <div class="bg-white rounded-xl shadow-lg border-t-4 border-yellow-500 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium">Planes Pendientes</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totales['planes']['pendientes'] }}</p>
                <p class="text-xs text-gray-400 mt-1">Esperando revisión</p>
            </div>
            <div class="p-3 bg-yellow-50 rounded-full">
                <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>

    {{-- PLANES APROBADOS --}}
    <div class="bg-white rounded-xl shadow-lg border-t-4 border-green-500 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium">Planes Aprobados</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totales['planes']['aprobados'] }}</p>
                <p class="text-xs text-gray-400 mt-1">Revisión completada</p>
            </div>
            <div class="p-3 bg-green-50 rounded-full">
                <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>

    {{-- PLANES DEVUELTOS --}}
    <div class="bg-white rounded-xl shadow-lg border-t-4 border-red-500 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium">Planes Devueltos</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totales['planes']['devueltos'] }}</p>
                <p class="text-xs text-gray-400 mt-1">Requieren modificaciones</p>
            </div>
            <div class="p-3 bg-red-50 rounded-full">
                <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>
</div>

        {{-- ESTADISTICA DE PROGRAMAS --}}
       <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

    {{-- PROGRAMAS PENDIENTES --}}
    <div class="bg-white rounded-xl shadow-lg border-t-4 border-yellow-500 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium">Programas Pendientes</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totales['programas']['pendientes'] }}</p>
                <p class="text-xs text-gray-400 mt-1">Esperando revisión</p>
            </div>
            <div class="p-3 bg-yellow-50 rounded-full">
                <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>

    {{-- PROGRAMAS APROBADOS --}}
    <div class="bg-white rounded-xl shadow-lg border-t-4 border-green-500 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium">Programas Aprobados</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totales['programas']['aprobados'] }}</p>
                <p class="text-xs text-gray-400 mt-1">Revisión completada</p>
            </div>
            <div class="p-3 bg-green-50 rounded-full">
                <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>

    {{-- PROGRAMAS DEVUELTOS --}}
    <div class="bg-white rounded-xl shadow-lg border-t-4 border-red-500 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium">Programas Devueltos</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totales['programas']['devueltos'] }}</p>
                <p class="text-xs text-gray-400 mt-1">Requieren modificaciones</p>
            </div>
            <div class="p-3 bg-red-50 rounded-full">
                <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>
</div>
{{-- ESTADISTICA DE PROYECTOS --}}
       <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

    {{-- PROYECTOS PENDIENTES --}}
    <div class="bg-white rounded-xl shadow-lg border-t-4 border-yellow-500 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium">Proyectos Pendientes</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totales['proyectos']['pendientes'] }}</p>
                <p class="text-xs text-gray-400 mt-1">Esperando revisión</p>
            </div>
            <div class="p-3 bg-yellow-50 rounded-full">
                <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>

    {{-- PROYECTOS APROBADOS --}}
    <div class="bg-white rounded-xl shadow-lg border-t-4 border-green-500 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium">Proyectos Aprobados</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totales['proyectos']['aprobados'] }}</p>
                <p class="text-xs text-gray-400 mt-1">Revisión completada</p>
            </div>
            <div class="p-3 bg-green-50 rounded-full">
                <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>

    {{-- PROYECTOS DEVUELTOS --}}
    <div class="bg-white rounded-xl shadow-lg border-t-4 border-red-500 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium">Proyectos Devueltos</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totales['proyectos']['devueltos'] }}</p>
                <p class="text-xs text-gray-400 mt-1">Requieren modificaciones</p>
            </div>
            <div class="p-3 bg-red-50 rounded-full">
                <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>
</div>



          {{-- RESUMEN DE ACTIVIDAD RECIENTE --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            
            {{-- INFORMACIÓN DE LA AUTORIDAD --}}
            <div class="p-6 bg-white rounded-xl shadow-lg border-t-2 border-gray-100">
                <h3 class="text-xl font-semibold mb-4 text-gray-700 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Información de la Autoridad
                </h3>

                <div class="space-y-4">
                    {{-- Último acceso --}}
                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                        <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <p class="text-sm text-gray-500">Último acceso</p>
                            <p class="font-medium text-gray-700">Hoy, {{ date('H:i') }}</p>
                        </div>
                    </div>

                    {{-- Rol --}}
                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                        <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        <div>
                            <p class="text-sm text-gray-500">Rol del usuario</p>
                            <p class="font-medium text-orange-600">Autoridad Validante</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ACCIONES RÁPIDAS --}}
            <div class="p-6 bg-white rounded-xl shadow-lg border-t-2 border-blue-100">
                <h3 class="text-xl font-semibold mb-4 text-gray-700 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Acciones Rápidas
                </h3>
                <p class="text-gray-600 mb-4">
                    Gestiona eficientemente las tareas de revisión con estas acciones directas.
                </p>
{{-- Botón de Gestión de Autoridad --}}
        <a href="{{ route('autoridad.index') }}" {{-- Ajusta la ruta según tu aplicación --}}
           class="inline-flex flex-col items-center justify-center w-28 h-28 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition duration-150 ease-in-out">
            <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="text-sm text-center">Gestión de Autoridad</span>
        </a>
           </div>
        </div>

        {{-- ALERTA IMPORTANTE --}}
        <div class="p-6 bg-blue-50 border-l-4 border-blue-500 rounded-r-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" 
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" 
                        clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-blue-700">
                        <span class="font-medium">Recordatorio:</span>
                        Como autoridad validante, tu labor es fundamental para garantizar la calidad y el cumplimiento de los planes. 
                        Revisa cada plan con atención y proporciona retroalimentación constructiva cuando sea necesario.
                    </p>
                </div>
            </div>
        </div>

    </main>
</div>
@endsection