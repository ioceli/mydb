@extends('layouts.master')
@section('title', 'Panel de la Autoridad')
@section('content')
<div class="flex min-h-screen bg-gray-50">
    {{-- Menú Lateral Mejorado (Similar al de Revisor) --}}
    <aside class="w-64 bg-blue-100 p-6 shadow-xl border-r border-gray-200">
        <h3 class="text-xl font-extrabold text-blue-800 mb-6 border-b pb-2">
            Panel de Autoridad
        </h3>
        <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">
            Acciones de Aprobación
        </p>
        <nav class="space-y-2">
            {{-- Enlace principal: Emitir Aprobación Final --}}
            <a href="{{ route('autoridad.index') }}" 
                class="flex items-center p-3 text-blue-700 font-medium rounded-lg hover:bg-blue-50 transition duration-150 ease-in-out border border-transparent hover:border-blue-300">
                {{-- Ícono de Aprobación (Checkmark/Certificado) --}}
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.047m17.236 0c-.39.358-.87.674-1.4 1.157l-1.42 1.42a1 1 0 01-1.414 0L12 11.586l-4.787-4.787a1 1 0 01-1.414 0l-1.42-1.42c-.53-.483-1.01-.8-1.4-1.157m17.236 0L12 17.586l-4.787-4.787a1 1 0 00-1.414 0L4 14.586V19a2 2 0 002 2h12a2 2 0 002-2v-4.414l-.793-.793a1 1 0 00-1.414 0L12 11.586l-4.787-4.787a1 1 0 00-1.414 0L4 7.586V19a2 2 0 002 2h12a2 2 0 002-2v-4.414l-.793-.793a1 1 0 00-1.414 0L12 11.586l-4.787-4.787a1 1 0 00-1.414 0L4 7.586V19a2 2 0 002 2h12a2 2 0 002-2v-4.414l-.793-.793a1 1 0 00-1.414 0L12 11.586z"></path></svg>
                <span>**Emitir Aprobación Final**</span>
            </a>
        </nav>
        {{-- Área de usuario al final del menú --}}
        <div class="mt-8 pt-4 border-t border-gray-200">
             <p class="text-sm text-gray-500">Sesión iniciada como:</p>
             <p class="font-semibold text-gray-700">{{ Auth::user()->name }}</p>
        </div>
    </aside>
    {{-- Contenido principal --}}
    <main class="flex-1 p-8">
        <header class="mb-8 border-b pb-4">
            <h1 class="text-3xl font-light text-gray-800">
                Bienvenido de vuelta, <span class="font-bold text-orange-600">{{ Auth::user()->name }}</span>
            </h1>
            <p class="text-gray-500 mt-1">
                Utiliza el menú lateral para aprobar o rechazar el Plan Institucional.
            </p>
        </header>
        <div class="mt-8 p-6 bg-white rounded-xl shadow-lg border-t-2 border-orange-300">
            <h3 class="text-xl font-semibold mb-4 text-gray-700">Flujo de Aprobación</h3>
            <p class="text-gray-600">
                Tu tarea principal es dar la **Aprobación Final del Plan Institucional**. Haz clic en **"Emitir Aprobación Final"** en el menú lateral para revisar y tomar la decisión correspondiente.
            </p>
        </div>
    </main>
</div>
@endsection