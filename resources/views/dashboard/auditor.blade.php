@extends('layouts.master')

@section('title', 'Panel del Auditor')

@section('content')
<div class="flex min-h-screen bg-gray-50">

    {{-- Menú Lateral --}}
    <x-auditor-sidebar/>

    {{-- Contenido principal --}}
    <main class="flex-1 p-8">
        <header class="mb-8 border-b pb-4">
            <h1 class="text-3xl font-light text-gray-800">
                Panel de Auditoría, <span class="font-bold text-blue-600">{{ Auth::user()->name }}</span>
            </h1>
            <p class="text-gray-500 mt-1">
                Revisa, monitorea y valida el funcionamiento del sistema desde este panel.
            </p>
        </header>

        {{-- CONTENIDO PRINCIPAL --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

            {{-- ====================== TARJETA DE ACCIONES RÁPIDAS ====================== --}}
            <div class="p-6 bg-white rounded-xl shadow-lg border-t-2 border-blue-100">
                <h3 class="text-xl font-semibold mb-4 text-gray-700 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Acciones Rápidas
                </h3>

                <p class="text-gray-600 mb-4">
                    Accede rápidamente a las herramientas clave del módulo de auditoría.
                </p>

                <div class="space-x-6 mt-4">
                    <a href="{{ route('auditoria.index') }}"
                       class="inline-flex flex-col items-center justify-center w-28 h-28 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition duration-150 ease-in-out">
                        <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M9 17v-5l12-7v5z"/>
                        </svg>
                        <span class="text-sm text-center">Trazabilidad</span>
                    </a>
                </div>
            </div>

            {{-- ====================== TARJETA DE INFORMACIÓN DEL AUDITOR ====================== --}}
            <div class="p-6 bg-white rounded-xl shadow-lg border-t-2 border-gray-100">
                <h3 class="text-xl font-semibold mb-4 text-gray-700 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Información del Auditor
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
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857
                            m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <div>
                            <p class="text-sm text-gray-500">Rol del usuario</p>
                            <p class="font-medium text-blue-600">{{ Auth::user()->rol }}</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- ====================== SECCIÓN DE ALERTA ====================== --}}
        <div class="p-6 bg-yellow-50 border-l-4 border-yellow-500 rounded-r-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" 
                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 
                        1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" 
                        clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700">
                        <span class="font-medium">Aviso importante:</span>
                        Como auditor, tienes acceso a información sensible del sistema.
                        Asegura el uso responsable y la integridad de los datos analizados.
                    </p>
                </div>
            </div>
        </div>

    </main>
</div>
@endsection
