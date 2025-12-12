@extends('layouts.master')
@section('title', 'Panel del Externo')
@section('content')
<div class="flex min-h-screen bg-gray-50">
    {{-- Menú Lateral --}}
<x-externo-sidebar />

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
{{-- Sección de Instrucciones Técnicas para Usuario Externo --}}
<div class="p-6 bg-gradient-to-r from-blue-50 to-cyan-50 border-l-4 border-blue-600 rounded-r-lg shadow-md mb-8">
    <div class="flex">
        <div class="flex-shrink-0">
            <i class="fas fa-user-check text-blue-600 text-2xl mt-1"></i>
        </div>
        <div class="ml-4">
            <h4 class="text-xl font-bold text-blue-800 mb-2">Guía del Usuario Externo</h4>
            <p class="text-sm text-gray-700 mb-4">
                Como usuario externo, tienes acceso para ingresar datos de planes, programas y proyectos institucionales. 
                A continuación, las funciones disponibles para tu perfil:
            </p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Funciones Disponibles --}}
                <div class="bg-white p-4 rounded-lg border border-blue-100">
                    <h5 class="font-semibold text-blue-700 mb-2 flex items-center">
                        <i class="fas fa-eye text-blue-500 mr-2"></i>
                        Funciones Disponibles
                    </h5>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-2 text-xs"></i>
                            <span>Ingreso de Planes, Programas y Proyectos</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-2 text-xs"></i>
                            <span>Seguimiento del estado de revisión</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-2 text-xs"></i>
                            <span>Visualización de documentos aprobados</span>
                        </li>
                    </ul>
                </div>
                
                {{-- Restricciones --}}
                <div class="bg-white p-4 rounded-lg border border-blue-100">
                    <h5 class="font-semibold text-red-600 mb-2 flex items-center">
                        <i class="fas fa-ban text-red-500 mr-2"></i>
                        Restricciones del Perfil
                    </h5>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li class="flex items-start">
                            <i class="fas fa-times-circle text-red-500 mt-1 mr-2 text-xs"></i>
                            <span>No puedes aprobar o rechazar documentos</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-times-circle text-red-500 mt-1 mr-2 text-xs"></i>
                            <span>Acceso limitado a datos sensibles</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            {{-- Flujo de Trabajo --}}
            <div class="mt-4 bg-blue-100 p-4 rounded-lg">
                <h5 class="font-semibold text-blue-800 mb-2">
                    <i class="fas fa-project-diagram text-blue-600 mr-2"></i>
                    Flujo de Trabajo Sugerido
                </h5>
                <ol class="text-sm text-blue-900 space-y-2 ml-4">
                    <li class="flex items-center">
                        <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center mr-2 text-xs">1</span>
                        Revisa el resumen de actividades en el panel principal
                    </li>
                    <li class="flex items-center">
                        <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center mr-2 text-xs">2</span>
                        Navega por el menú lateral para acceder a documentos específicos
                    </li>
                    <li class="flex items-center">
                        <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center mr-2 text-xs">3</span>
                        Consulta documentos pendientes de tu revisión
                    </li>
                </ol>
            </div>

        </div>
    </div>
</div>
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