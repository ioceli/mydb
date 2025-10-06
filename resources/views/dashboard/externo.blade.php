@extends('layouts.master')
@section('title', 'Panel del Externo')
@section('content')
{{-- Contenedor principal para la estructura de la página --}}
<div class="flex min-h-screen bg-gray-50">
    <div id="sidebar-backdrop" class="fixed inset-0 bg-black bg-opacity-50 z-30 md:hidden hidden transition-opacity duration-300"></div>
    <nav id="sidebar" class="fixed top-0 left-0 h-full w-64 bg-blue-50 shadow-xl transform -translate-x-full md:translate-x-0 transition-all duration-300 z-40 p-5 flex flex-col">
        {{-- Encabezado del Menú --}}
        <div class="pb-4 border-b border-green-200 mb-6">
            <h3 class="text-xl font-extrabold text-blue-800">Panel de Acciones</h3>
            <p class="text-sm text-gray-500 mt-1">Usuario Externo</p>
        </div>
        {{-- Acciones del Menú --}}
        <ul class="text-gray-700 space-y-2 flex-grow">
            <li>
                <a href="{{ route('plan.index') }}" class="flex items-center p-3 rounded-lg hover:bg-blue-100 transition duration-150 group">
                    <span class="font-bold text-blue-600 ">Plan Institucional</span>
                </a>
            </li>
            <li>
                <a href="{{ route('programa.index') }}" class="flex items-center p-3 rounded-lg hover:bg-blue-100 transition duration-150 group">
                    <span class="font-bold text-blue-600">Programa Institucional</span>
                </a>
            </li>
            <li>
                <a href="{{ route('proyecto.index') }}" class="flex items-center p-3 rounded-lg hover:bg-blue-100 transition duration-150 group">
                    <span class="font-bold text-blue-600">Proyecto Institucional</span>
                </a>
            </li>
        </ul>
        {{-- Botón de cerrar para móviles --}}
        <button id="closeSidebar" class="absolute top-3 right-3 p-2 text-gray-500 hover:text-gray-900 md:hidden">
            <span class="font-bold text-2xl leading-none">&times;</span>
        </button>
    </nav>
    {{-- Contenido principal (Main Content) --}}
    <div id="main-content" class="flex-1 transition-all duration-300 md:pl-64 p-6 sm:p-8">
        {{-- Barra Superior (para botón de menú y saludo) --}}
        <header class="flex items-center justify-between border-b pb-4 mb-6 sticky top-0 bg-white z-20">
            <h2 class="text-3xl font-extrabold text-orange-600">
                Bienvenido, <span class="text-gray-800">{{ Auth::user()->name }}</span>
            </h2>
            {{-- Botón para mostrar/ocultar el menú (Visible solo en móviles) --}}
            <button id="toggleSidebar" class="p-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-150 md:hidden flex items-center shadow-lg">
                {{-- Simulación de icono de menú --}}
                <span class="text-xl mr-2">☰</span>
                Menú
            </button>
        </header>
        {{-- Área de Trabajo --}}
<section class="mt-6">
    <h3 class="text-2xl font-semibold mb-4 text-gray-700">Resumen de Actividades</h3>
    <p class="text-gray-600 mb-6">Utilice el menú de la izquierda para revisar a detalle los documentos Planes, Programas y Proyectos Institucionales.</p>
    {{-- Tarjetas de Información Dinámicas --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Tarjeta de Planes --}}
        <div class="bg-white p-6 rounded-xl shadow-md border-t-4 border-blue-500 hover:shadow-lg transition">
            <h4 class="text-lg font-bold text-gray-800">Total de Planes:</h4>
            <p class="text-4xl mt-2 font-extrabold text-blue-600 text-center">**{{ $totalPlanes }}**</p>
            <div class="bg-white p-6 rounded-xl shadow-md border-t-4 border-blue-500 hover:shadow-lg transition">
                <h4 class="text-lg font-bold text-gray-800">Pendientes de Revisión por el Revisor:</h4>
                <p class="text-4xl mt-2 font-extrabold text-blue-600 text-center" > **{{ $planesPendientesRevisor }}**</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-md border-t-4 border-blue-500 hover:shadow-lg transition">
                <h4 class="text-lg font-bold text-gray-800">Pendientes de Revisión por la Autoridad:</h4>
                <p class="text-4xl mt-2 font-extrabold text-blue-600 text-center">**{{ $planesPendientesAutoridad }}**</p>
            </div>  
        </div>
        {{-- Tarjeta de Programas --}}
        <div class="bg-white p-6 rounded-xl shadow-md border-t-4 border-orange-500 hover:shadow-lg transition">
            <h4 class="text-lg font-bold text-gray-800">Total de Programas</h4>
            <p class="text-4xl mt-2 font-extrabold text-orange-600 text-center">**{{ $totalProgramas }}**</p>
            <div class="bg-white p-6 rounded-xl shadow-md border-t-4 border-orange-500 hover:shadow-lg transition">
                <h4 class="text-lg font-bold text-gray-800">Pendientes de Revisión por el Revisor:</h4>
                <p class="text-4xl mt-2 font-extrabold text-orange-600 text-center">**{{ $programasPendientesRevisor }}**</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-md border-t-4 border-orange-500 hover:shadow-lg transition">
                <h4 class="text-lg font-bold text-gray-800">Pendientes de Revisión por la Autoridad:</h4>
                <p class="text-4xl mt-2 font-extrabold text-orange-600 text-center">**{{ $programasPendientesAutoridad }}**</p>
            </div>
        </div>
        {{-- Tarjeta de Proyectos --}}
        <div class="bg-white p-6 rounded-xl shadow-md border-t-4 border-green-500 hover:shadow-lg transition">
            <h4 class="text-lg font-bold text-gray-800">Total de Proyectos:</h4>
            <p class="text-4xl mt-2 font-extrabold text-green-600 text-center">**{{ $totalProyectos }}**</p>
            <div class="bg-white p-6 rounded-xl shadow-md border-t-4 border-green-500 hover:shadow-lg transition">
                <h4 class="text-lg font-bold text-gray-800">Pendientes de Revisión por el Revisor:</h4>
                <p class="text-4xl mt-2 font-extrabold text-green-600 text-center">**{{ $proyectosPendientesRevisor }}**</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-md border-t-4 border-green-500 hover:shadow-lg transition">
                <h4 class="text-lg font-bold text-gray-800">Pendientes de Revisión por la Autoridad:</h4>
                <p class="text-4xl mt-2 font-extrabold text-green-600 text-center">**{{ $proyectosPendientesAutoridad }}**</p>
            </div>
        </div>
    </div>
</section>
    </div>
</div>
{{-- Script para mejorar la interactividad --}}
<script>
    const toggleButton = document.getElementById('toggleSidebar');
    const closeButton = document.getElementById('closeSidebar');
    const sidebar = document.getElementById('sidebar');
    const backdrop = document.getElementById('sidebar-backdrop');
    // Función para abrir la barra lateral
    function openSidebar() {
        sidebar.classList.remove('-translate-x-full');
        backdrop.classList.remove('hidden');
    }
    // Función para cerrar la barra lateral
    function closeSidebar() {
        sidebar.classList.add('-translate-x-full');
        backdrop.classList.add('hidden');
    }
    // Eventos de clic para abrir/cerrar
    toggleButton.addEventListener('click', openSidebar);
    closeButton.addEventListener('click', closeSidebar);
    backdrop.addEventListener('click', closeSidebar);
    // Opcional: Cerrar con la tecla ESC
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !sidebar.classList.contains('-translate-x-full')) {
            closeSidebar();
        }
    });
    // Asegurar que el menú esté siempre visible en pantallas grandes al cargar
    window.addEventListener('load', () => {
        if (window.innerWidth >= 768) { 
            sidebar.classList.remove('-translate-x-full');
        }
    });
</script>
@endsection