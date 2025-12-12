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

        {{-- ESTADÍSTICAS PRINCIPALES --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            {{-- Total de Planes --}}
            <div class="p-4 bg-white rounded-xl shadow border-t-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Total de Planes</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $total_planes ?? 0 }}</p>
                    </div>
                    <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            </div>

            {{-- Planes Pendientes --}}
            <div class="p-4 bg-white rounded-xl shadow border-t-4 border-yellow-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Pendientes</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $pendientes_count ?? 0 }}</p>
                    </div>
                    <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="mt-2 text-xs text-gray-500">
                    @php
                        $porcentajePendientes = $total_planes > 0 ? round(($pendientes_count / $total_planes) * 100, 1) : 0;
                    @endphp
                    {{ $porcentajePendientes }}% del total
                </div>
            </div>

            {{-- Planes Aprobados --}}
            <div class="p-4 bg-white rounded-xl shadow border-t-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Aprobados</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $aprobados_count ?? 0 }}</p>
                    </div>
                    <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <div class="mt-2 text-xs text-gray-500">
                    @php
                        $porcentajeAprobados = $total_planes > 0 ? round(($aprobados_count / $total_planes) * 100, 1) : 0;
                    @endphp
                    {{ $porcentajeAprobados }}% del total
                </div>
            </div>

            {{-- Planes Devueltos --}}
            <div class="p-4 bg-white rounded-xl shadow border-t-4 border-red-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Devueltos</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $devueltos_count ?? 0 }}</p>
                    </div>
                    <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
                <div class="mt-2 text-xs text-gray-500">
                    @php
                        $porcentajeDevueltos = $total_planes > 0 ? round(($devueltos_count / $total_planes) * 100, 1) : 0;
                    @endphp
                    {{ $porcentajeDevueltos }}% del total
                </div>
            </div>
        </div>

        {{-- CONTENIDO PRINCIPAL --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

            {{-- ====================== TARJETA DE ACCIONES RÁPIDAS ====================== --}}
            <div class="p-6 bg-white rounded-xl shadow-lg border-t-2 border-orange-100">
                <h3 class="text-xl font-semibold mb-4 text-gray-700 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Aprobaciones Pendientes
                </h3>

                <p class="text-gray-600 mb-4">
                    Planes institucionales que requieren tu revisión y decisión final.
                </p>

                @if(($pendientes_count ?? 0) > 0)
                <div class="mb-4 p-4 bg-yellow-50 border-l-4 border-yellow-500 rounded-r">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="h-10 w-10 rounded-full bg-yellow-100 flex items-center justify-center">
                                <span class="text-yellow-800 font-bold text-lg">{{ $pendientes_count }}</span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-yellow-800 font-medium">Tienes {{ $pendientes_count }} plan(es) pendiente(s)</p>
                            <p class="text-yellow-600 text-sm mt-1">Requieren tu revisión inmediata</p>
                        </div>
                    </div>
                </div>

                <a href="{{ route('autoridad.index', ['tipo_autorizacion' => 'planes', 'estado_autoridad_filtro' => 'pendiente']) }}" 
                   class="inline-flex items-center px-4 py-3 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors duration-200 font-medium">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                    Revisar Planes Pendientes
                </a>
                @else
                <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 rounded-r">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-green-800 font-medium">¡Al día con las revisiones!</p>
                            <p class="text-green-600 text-sm mt-1">No hay planes pendientes de revisión</p>
                        </div>
                    </div>
                </div>
                @endif

                <div class="mt-4 pt-4 border-t border-gray-100">
                    <p class="text-sm text-gray-500 mb-2">Acciones rápidas:</p>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('autoridad.index', ['tipo_autorizacion' => 'planes', 'estado_autoridad_filtro' => 'Aprobado']) }}" 
                           class="px-3 py-2 bg-green-100 text-green-800 rounded text-sm hover:bg-green-200 transition">
                            Ver Aprobados
                        </a>
                        <a href="{{ route('autoridad.index', ['tipo_autorizacion' => 'planes', 'estado_autoridad_filtro' => 'Devuelto']) }}" 
                           class="px-3 py-2 bg-red-100 text-red-800 rounded text-sm hover:bg-red-200 transition">
                            Ver Devueltos
                        </a>
                        <a href="{{ route('autoridad.index', ['tipo_autorizacion' => 'planes']) }}" 
                           class="px-3 py-2 bg-blue-100 text-blue-800 rounded text-sm hover:bg-blue-200 transition">
                            Ver Todos
                        </a>
                    </div>
                </div>
            </div>

            {{-- ====================== TARJETA DE ESTADÍSTICAS ====================== --}}
            <div class="p-6 bg-white rounded-xl shadow-lg border-t-2 border-gray-100">
                <h3 class="text-xl font-semibold mb-4 text-gray-700 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    Resumen de Actividad
                </h3>

                <div class="space-y-4">

                    {{-- Total de Planes --}}
                    <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <div>
                                <p class="text-sm text-gray-500">Total de planes</p>
                                <p class="font-medium text-gray-700">{{ $total_planes ?? 0 }} planes</p>
                            </div>
                        </div>
                        <span class="text-blue-600 font-semibold text-lg">📊</span>
                    </div>

                    {{-- Planes aprobados --}}
                    <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M5 13l4 4L19 7"/>
                            </svg>
                            <div>
                                <p class="text-sm text-gray-500">Planes aprobados</p>
                                <p class="font-medium text-gray-700">{{ $aprobados_count ?? 0 }} total</p>
                            </div>
                        </div>
                        <span class="text-green-600 font-semibold text-lg">✓</span>
                    </div>

                    {{-- Planes devueltos --}}
                    <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            <div>
                                <p class="text-sm text-gray-500">Planes devueltos</p>
                                <p class="font-medium text-gray-700">{{ $devueltos_count ?? 0 }} total</p>
                            </div>
                        </div>
                        <span class="text-red-600 font-semibold text-lg">✗</span>
                    </div>

                    {{-- Gráfico de distribución --}}
                    <div class="p-3 bg-gray-50 rounded-lg">
                        <p class="text-sm font-medium text-gray-700 mb-3">Distribución de Planes</p>
                        @php
                            $porcentajeAprobados = $total_planes > 0 ? round(($aprobados_count / $total_planes) * 100, 1) : 0;
                            $porcentajePendientes = $total_planes > 0 ? round(($pendientes_count / $total_planes) * 100, 1) : 0;
                            $porcentajeDevueltos = $total_planes > 0 ? round(($devueltos_count / $total_planes) * 100, 1) : 0;
                        @endphp
                        
                        <div class="space-y-2">
                            {{-- Barra Aprobados --}}
                            <div>
                                <div class="flex justify-between text-xs text-gray-600 mb-1">
                                    <span>Aprobados</span>
                                    <span>{{ $aprobados_count }} ({{ $porcentajeAprobados }}%)</span>
                                </div>
                                <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="h-full bg-green-500 rounded-full" style="width: {{ $porcentajeAprobados }}%"></div>
                                </div>
                            </div>
                            
                            {{-- Barra Pendientes --}}
                            <div>
                                <div class="flex justify-between text-xs text-gray-600 mb-1">
                                    <span>Pendientes</span>
                                    <span>{{ $pendientes_count }} ({{ $porcentajePendientes }}%)</span>
                                </div>
                                <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="h-full bg-yellow-500 rounded-full" style="width: {{ $porcentajePendientes }}%"></div>
                                </div>
                            </div>
                            
                            {{-- Barra Devueltos --}}
                            <div>
                                <div class="flex justify-between text-xs text-gray-600 mb-1">
                                    <span>Devueltos</span>
                                    <span>{{ $devueltos_count }} ({{ $porcentajeDevueltos }}%)</span>
                                </div>
                                <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="h-full bg-red-500 rounded-full" style="width: {{ $porcentajeDevueltos }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- ====================== SECCIÓN DE INSTRUCCIONES ====================== --}}
        <div class="p-6 bg-gradient-to-r from-orange-50 to-yellow-50 border-l-4 border-orange-500 rounded-r-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-orange-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" 
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" 
                        clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h4 class="text-lg font-medium text-orange-800 mb-2">Flujo de Aprobación</h4>
                    <p class="text-orange-700">
                        Tu tarea principal es dar la <strong>Aprobación Final del Plan Institucional</strong>. 
                        Utiliza el menú lateral para:
                    </p>
                    <ul class="mt-2 text-orange-700 list-disc list-inside space-y-1">
                        <li>Revisar planes pendientes de aprobación (actualmente: <strong>{{ $pendientes_count ?? 0 }}</strong>)</li>
                        <li>Emitir decisiones de aprobación o rechazo</li>
                        <li>Ver el historial de decisiones tomadas</li>
                        <li>Consultar planes ya aprobados (<strong>{{ $aprobados_count ?? 0 }}</strong> actualmente)</li>
                    </ul>
                    <div class="mt-3 p-3 bg-orange-100 rounded-lg border border-orange-200">
                        <p class="text-orange-800 text-sm font-medium">
                            <strong>Resumen actual:</strong> 
                            {{ $total_planes ?? 0 }} planes totales • 
                            {{ $aprobados_count ?? 0 }} aprobados • 
                            {{ $pendientes_count ?? 0 }} pendientes • 
                            {{ $devueltos_count ?? 0 }} devueltos
                        </p>
                    </div>
                    <p class="mt-3 text-orange-700 text-sm">
                        Cada decisión queda registrada en el sistema con fecha y hora.
                    </p>
                </div>
            </div>
        </div>

        {{-- ====================== ACCESO RÁPIDO ====================== --}}
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('autoridad.index', ['tipo_autorizacion' => 'planes', 'estado_autoridad_filtro' => 'pendiente']) }}" 
               class="p-5 bg-white rounded-xl shadow border border-yellow-100 hover:shadow-md transition-all duration-200 hover:border-yellow-300">
                <div class="flex items-center">
                    <div class="h-10 w-10 rounded-full bg-yellow-100 flex items-center justify-center mr-4">
                        <span class="text-yellow-800 font-bold">{{ $pendientes_count ?? 0 }}</span>
                    </div>
                    <div>
                        <div class="text-yellow-700 font-semibold">Revisar Pendientes</div>
                        <div class="text-sm text-gray-500 mt-1">Planes que requieren tu atención</div>
                    </div>
                </div>
            </a>
            
            <a href="{{ route('autoridad.index', ['tipo_autorizacion' => 'planes', 'estado_autoridad_filtro' => 'Aprobado']) }}" 
               class="p-5 bg-white rounded-xl shadow border border-green-100 hover:shadow-md transition-all duration-200 hover:border-green-300">
                <div class="flex items-center">
                    <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center mr-4">
                        <span class="text-green-800 font-bold">{{ $aprobados_count ?? 0 }}</span>
                    </div>
                    <div>
                        <div class="text-green-700 font-semibold">Ver Aprobados</div>
                        <div class="text-sm text-gray-500 mt-1">Planes ya aprobados</div>
                    </div>
                </div>
            </a>
            
            <a href="{{ route('autoridad.index', ['tipo_autorizacion' => 'planes']) }}" 
               class="p-5 bg-white rounded-xl shadow border border-blue-100 hover:shadow-md transition-all duration-200 hover:border-blue-300">
                <div class="flex items-center">
                    <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center mr-4">
                        <span class="text-blue-800 font-bold">{{ $total_planes ?? 0 }}</span>
                    </div>
                    <div>
                        <div class="text-blue-700 font-semibold">Ver Todos</div>
                        <div class="text-sm text-gray-500 mt-1">Todos los planes del sistema</div>
                    </div>
                </div>
            </a>
        </div>

    </main>
</div>
@endsection