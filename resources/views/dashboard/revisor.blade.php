@extends('layouts.master')

@section('title', 'Panel de Revisor')

@section('content')
<div class="flex min-h-screen bg-gray-50">
    
    {{-- Menú Lateral Mejorado --}}
    <aside class="w-64 bg-blue-100 p-6 shadow-xl border-r border-gray-200">
        <h3 class="text-xl font-extrabold text-blue-800 mb-6 border-b pb-2">
            Panel de Control
        </h3>
        
        <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">
            Tareas de Revisión
        </p>
        
        <nav class="space-y-2">
            {{-- Enlace a la acción principal --}}
            <a href="{{ route('revision.index') }}" 
               class="flex items-center p-3 text-blue-700 font-medium rounded-lg hover:bg-blue-50 transition duration-150 ease-in-out border border-transparent hover:border-blue-300">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.047m17.236 0c-.39.358-.87.674-1.4 1.157l-1.42 1.42a1 1 0 01-1.414 0L12 11.586l-4.787-4.787a1 1 0 01-1.414 0l-1.42-1.42c-.53-.483-1.01-.8-1.4-1.157m17.236 0L12 17.586l-4.787-4.787a1 1 0 00-1.414 0L4 14.586V19a2 2 0 002 2h12a2 2 0 002-2v-4.414l-.793-.793a1 1 0 00-1.414 0L12 11.586l-4.787-4.787a1 1 0 00-1.414 0L4 7.586V19a2 2 0 002 2h12a2 2 0 002-2v-4.414l-.793-.793a1 1 0 00-1.414 0L12 11.586l-4.787-4.787a1 1 0 00-1.414 0L4 7.586V19a2 2 0 002 2h12a2 2 0 002-2v-4.414l-.793-.793a1 1 0 00-1.414 0L12 11.586l-4.787-4.787a1 1 0 00-1.414 0L4 7.586V19a2 2 0 002 2h12a2 2 0 002-2v-4.414l-.793-.793a1 1 0 00-1.414 0L12 11.586z"></path></svg>
                <span>**Ver Alineaciones**</span>
            </a>
            
            {{-- Ejemplo de otro enlace futuro --}}
            {{-- <a href="#" 
               class="flex items-center p-3 text-gray-600 rounded-lg hover:bg-gray-100 transition duration-150 ease-in-out">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                <span>Notificaciones</span>
            </a> --}}
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
                Utiliza el menú lateral para gestionar las tareas de revisión.
            </p>
        </header>
        
            <div class="mt-8 p-6 bg-white rounded-xl shadow-lg border-t-2 border-gray-100">
            <h3 class="text-xl font-semibold mb-4 text-gray-700">Flujo de Trabajo</h3>
            <p class="text-gray-600">
                Para comenzar, haz clic en **"Ver Alineaciones"** en el menú lateral.
            </p>
            
        </div>
        
    </main>
</div>
@endsection