
@extends('layouts.master')
@section('title', 'Panel del Externo')

@section('content')
<div class="flex h-screen">


    {{-- Menú lateral ocultable --}}
    <nav id="sidebar" class="fixed top-0 left-0 h-full w-64 bg-blue-100 shadow-md transform -translate-x-full transition-transform duration-300 z-40 p-4">
        <h3 class="text-lg font-bold mb-4">Menú Usuario externo</h3>
        <p class="mb-4 font-bold">Acciones disponibles:</p>
        <ul class="list-disc ml-6 text-blue-700 space-y-2">
            <li><a href="{{ route('plan.index') }}" class="block p-2 rounded hover:bg-gray-200">Ingresar/Revisar Plan Institucional</a></li>
            <li><a href="{{ route('programa.index') }}" class="block p-2 rounded hover:bg-gray-200">Ingresar/Revisar Programa Institucional</a></li>
            <li><a href="{{ route('proyecto.index') }}" class="block p-2 rounded hover:bg-gray-200">Ingresar/Revisar Proyecto Institucional</a></li>
        </ul>
    </nav>


{{-- Contenido principal --}}
<div class="flex-1 p-6 ml-0 md:ml-64 transition-all duration-300">
    <h2 class="text-2xl font-bold mb-4 text-orange-600">
        Bienvenido, {{ Auth::user()->name }}
    </h2>

    {{-- Botón para mostrar/ocultar el menú debajo del encabezado --}}
    <button id="toggleSidebar" class="p-2 bg-blue-600 text-white rounded hover:bg-blue-700 mb-4">
         Menú
    </button>
</div>
</div>


{{-- Script para mostrar/ocultar el menú --}}
<script>
    const toggleButton = document.getElementById('toggleSidebar');
    const sidebar = document.getElementById('sidebar');

    toggleButton.addEventListener('click', () => {
        sidebar.classList.toggle('-translate-x-full');
    });
</script>
@endsection
