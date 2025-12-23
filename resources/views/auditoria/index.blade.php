@extends('layouts.master')
@section('title','Panel del Auditor')
@section('content')
@php
    use App\Enums\RolEnum;
    $role = Auth::check() ? Auth::user()->rol : null;
@endphp
<div class="flex min-h-screen bg-gray-50">
    {{-- Menú Lateral --}}
    <x-dynamic-sidebar />
    {{-- Contenido principal --}}
    <div class="flex-1 p-6">
        {{-- Validación --}}
        @if (session('success'))
            <div class="mb-4 p-2 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- Título --}}
        <h2 class="text-2xl font-bold mb-4 text-center">Bitácora del Auditor</h2>

        {{-- Formulario de filtros --}}
<form method="GET" action="{{ route('auditoria.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6 p-4 bg-blue-50 rounded shadow">

    {{-- Fecha desde --}}
    <div>
        <label for="fecha_desde" class="block text-sm font-medium text-gray-700">Fecha desde</label>
        <input type="date" id="fecha_desde" name="fecha_desde" value="{{ request('fecha_desde') }}"
               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
    </div>

    {{-- Fecha hasta --}}
    <div>
        <label for="fecha_hasta" class="block text-sm font-medium text-gray-700">Fecha hasta</label>
        <input type="date" id="fecha_hasta" name="fecha_hasta" value="{{ request('fecha_hasta') }}"
               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
    </div>

    {{-- Usuario --}}
    <div>
        <label for="usuario" class="block text-sm font-medium text-gray-700">Usuario</label>
        <select id="usuario" name="usuario"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            <option value="">Todos</option>
            @foreach($usuarios as $u)
                <option value="{{ $u->usuario }}" {{ request('usuario') == $u->usuario ? 'selected' : '' }}>
                    {{ $u->usuario }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Módulo --}}
    <div>
        <label for="modulo" class="block text-sm font-medium text-gray-700">Módulo</label>
        <select id="modulo" name="modulo"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            <option value="">Todos</option>
            @foreach($modulos as $m)
                <option value="{{ $m->modulo }}" {{ request('modulo') == $m->modulo ? 'selected' : '' }}>
                    {{ $m->modulo }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Acción --}}
    <div>
        <label for="accion" class="block text-sm font-medium text-gray-700">Acción</label>
        <select id="accion" name="accion"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            <option value="">Todas</option>
            @foreach($acciones as $a)
                <option value="{{ $a->accion }}" {{ request('accion') == $a->accion ? 'selected' : '' }}>
                    {{ $a->accion }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Botones --}}
    <div class="md:col-span-5 flex items-end gap-2">
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Filtrar
        </button>
        <a href="{{ route('auditoria.index') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
            Limpiar
        </a>
    </div>
</form>
        {{-- Tabla de bitácora --}}
        @if ($bitacoras->isEmpty())
            <div class="bg-blue-100 text-blue-800 p-3 rounded">
                No hay registros disponibles en la bitácora.
            </div>
            @else
            <div class="d-flex justify-content-end mb-3">
                <form method="GET" action="{{ route('auditoria.index') }}" class="row g-2 align-items-center" data-bs-toggle="tooltip" data-bs-placement="top" title="Selecciona cuántos registros ver por página">
                    
{{-- Mantener filtros --}}
    <input type="hidden" name="fecha_desde" value="{{ request('fecha_desde') }}">
    <input type="hidden" name="fecha_hasta" value="{{ request('fecha_hasta') }}">
    <input type="hidden" name="usuario" value="{{ request('usuario') }}">
    <input type="hidden" name="modulo" value="{{ request('modulo') }}">
    <input type="hidden" name="accion" value="{{ request('accion') }}">

                    <div class="col-auto">
                        <label for="per_page" class="col-form-label">
                            <i class="bi bi-list-ul me-1"></i> Mostrar:
                        </label>
                    </div>
                    <div class="col-auto">
                        <select name="per_page" id="per_page" class="form-select" onchange="this.form.submit()">
                            <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                            <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                        </select>
                    </div>
                </form>
            </div>
            <table class="min-w-full table-auto border-collapse">
                <thead class="bg-gray-200 text-gray-700 text-left">
                    <tr>
                        <th class="p-2">Fecha</th>
                        <th class="p-2">Usuario</th>
                        <th class="p-2">Módulo</th>
                        <th class="p-2">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bitacoras as $registro)
                        <tr>
                            <td class="border px-4 py-2">{{ $registro->fecha }}</td>
                            <td class="border px-4 py-2">{{ $registro->usuario }}</td>
                            <td class="border px-4 py-2">{{ $registro->modulo }}</td>
                            <td class="border px-4 py-2">{{ $registro->accion }}</td>
                        </tr>
                    @endforeach
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                            tooltipTriggerList.forEach(function (tooltipTriggerEl) {
                            new bootstrap.Tooltip(tooltipTriggerEl)
                            })
                            });
                        </script>
                </tbody>
            </table>
            <div class="mt-4">
                <a href="{{ route('auditoria.pdf', ['per_page' => $perPage]) }}" class="btn btn-danger mb-3">
                    <i class="bi bi-file-earmark-pdf"></i> Descargar PDF
                </a>
                <a href="{{ route('auditoria.excel', ['per_page' => $perPage]) }}" class="btn btn-success mb-3">
                    <i class="bi bi-file-earmark-excel"></i> Descargar Excel
                </a>
            </div>
            <div class="mt-4">
                {{ $bitacoras->appends(['per_page' => $perPage])->links() }}
            </div>
        @endif
                {{-- BOTÓN VOLVER --}}
<div class="mt-6">
    @if ($role === RolEnum::admin->value)
        <a href="{{ route('dashboard.admin') }}" 
           class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition duration-150">
            REGRESAR
        </a>
    @elseif ($role === RolEnum::revisor->value)
        <a href="{{ route('dashboard.revisor') }}" 
           class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition duration-150">
            REGRESAR
        </a>
    @endif
</div>
    </div>

</div>

@endsection