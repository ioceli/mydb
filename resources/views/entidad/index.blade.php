@extends('layouts.master')
@section('title', 'Gestión de Entidades')
@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="flex">
        {{-- Menú Lateral --}}
        <x-admin-sidebar />
        {{-- Contenido Principal --}}
        <div class="flex-1 p-6">
    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-gray-800 border-b pb-2">Gestión de Entidades Institucionales</h1>
        <p class="text-gray-500 mt-2">Administra todas las entidades del sistema desde este panel</p>
    </div>
    {{-- Mensaje de éxito --}}
@if (session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-sm" role="alert">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            <p class="font-bold">¡Éxito!</p>
        </div>
        <p class="mt-1">{{ session('success') }}</p>
    </div>
@endif

    {{-- Acción Principal y Estadísticas --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
        <div>
            <a href="{{ route('entidad.create') }}" 
                class="inline-flex items-center px-4 py-3 bg-green-600 text-white font-bold rounded-lg hover:bg-green-700 transition duration-150 ease-in-out shadow-md hover:shadow-lg">
                <i class="fas fa-plus mr-2"></i>
                Nueva Entidad
            </a>
        </div>
        @if(request()->hasAny(['estado', 'nivelGobierno', 'subsector']))
        <div class="mt-4 md:mt-0">
            <div class="bg-blue-50 px-4 py-2 rounded-lg border border-blue-200">
                <p class="text-sm text-gray-600">Total de entidades: <span class="font-bold text-blue-700">{{ $entidad->total() }}</span></p>
            </div>
        </div>
        @endif
    </div>

    {{-- FORMULARIO DE FILTROS --}}
    <div class="bg-white p-6 rounded-xl shadow-lg mb-8 border border-blue-200">
        <h2 class="text-xl font-semibold mb-4 text-gray-700 flex items-center">
            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
            </svg>
            Filtros de Búsqueda
        </h2>
        
        <form method="GET" action="{{ route('entidad.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
            {{-- Filtro por Estado --}}
            <div>
                <label for="estado" class="block text-sm font-medium text-gray-700 mb-1">Estado de la Entidad</label>
                <select id="estado" name="estado" 
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 bg-gray-50">
                    <option value="">Todos los Estados</option>
                    @foreach($estados as $e)
                        <option value="{{ $e }}" {{ request('estado') == $e ? 'selected' : '' }}>
                            {{ ucfirst($e) }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Filtro por Nivel de Gobierno --}}
            <div>
                <label for="nivelGobierno" class="block text-sm font-medium text-gray-700 mb-1">Nivel de Gobierno</label>
                <select id="nivelGobierno" name="nivelGobierno" 
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 bg-gray-50">
                    <option value="">Todos los Niveles</option>
                    @foreach($nivelesGobierno as $s)
                        <option value="{{ $s }}" {{ request('nivelGobierno') == $s ? 'selected' : '' }}>
                            {{ $s }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Filtro por Subsector --}}
            <div>
                <label for="subsector" class="block text-sm font-medium text-gray-700 mb-1">Subsector</label>
                <select id="subsector" name="subsector" 
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 bg-gray-50">
                    <option value="">Todos los Subsectores</option>
                    @foreach($entidad->pluck('subSector')->unique() as $subsector)
                        @if($subsector)
                            <option value="{{ $subsector }}" {{ request('subsector') == $subsector ? 'selected' : '' }}>
                                {{ $subsector }}
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>

            {{-- Registros por página --}}
            <div>
                <label for="per_page" class="block text-sm font-medium text-gray-700 mb-1">Registros por página</label>
                <select id="per_page" name="per_page" 
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 bg-gray-50">
                    @foreach([10, 25, 50, 100] as $num)
                        <option value="{{ $num }}" {{ request('per_page', $perPage) == $num ? 'selected' : '' }}>
                            {{ $num }} registros
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Botones de Acción --}}
            <div class="flex space-x-2">
                <button type="submit" name="buscar" value="true"
                   class="w-full px-4 py-2 bg-blue-600 text-white rounded-md font-bold hover:bg-blue-700 transition duration-150 shadow-md">
                    <i class="fas fa-search mr-1"></i> Buscar
                </button>
                <a href="{{ route('entidad.index') }}"
                     class="w-full px-4 py-2 bg-gray-300 text-gray-800 rounded-md font-bold hover:bg-gray-400 transition duration-150 text-center shadow-md">
                    <i class="fas fa-eraser mr-1"></i> Limpiar
                </a>
            </div>
        </form>
    </div>

    {{-- TABLA - SOLO SE MUESTRA SI SE APLICARON FILTROS --}}
    @if(request()->has('buscar') || request()->hasAny(['estado', 'nivelGobierno', 'subsector']))
    <div class="mb-10 p-4 border rounded-xl shadow-lg bg-gray-50">
        <div class="px-6 py-4 border-b bg-gradient-to-r from-gray-50 to-gray-100">
            <h2 class="text-xl font-bold text-gray-800">Resultados de la Búsqueda</h2>
            <p class="text-sm text-gray-600 mt-1">{{ $entidad->total() }} entidades encontradas</p>
            
            {{-- Mostrar filtros activos --}}
            @if(request()->hasAny(['estado', 'nivelGobierno', 'subsector']))
            <div class="mt-2 flex flex-wrap gap-2">
                @if(request('estado'))
                <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full flex items-center">
                    <i class="fas fa-filter mr-1 text-xs"></i> Estado: {{ request('estado') }}
                </span>
                @endif
                @if(request('nivelGobierno'))
                <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full flex items-center">
                    <i class="fas fa-filter mr-1 text-xs"></i> Nivel: {{ request('nivelGobierno') }}
                </span>
                @endif
                @if(request('subsector'))
                <span class="px-2 py-1 text-xs bg-purple-100 text-purple-800 rounded-full flex items-center">
                    <i class="fas fa-filter mr-1 text-xs"></i> Subsector: {{ request('subsector') }}
                </span>
                @endif
            </div>
            @endif
        </div>

        @if($entidad->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden border">
                <thead class="bg-blue-600 text-white">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">CÓDIGO</th>
                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">SUBSECTOR</th>
                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">NIVEL GOBIERNO</th>
                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">ESTADO</th>
                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">CREACIÓN</th>
                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">ACTUALIZACIÓN</th>
                        <th class="px-6 py-3 text-center text-xs font-bold uppercase tracking-wider">ACCIONES</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($entidad as $item)
                    <tr class="border-b hover:bg-blue-50 transition duration-100">
                        <td class="border p-3">
                            <span class="text-sm font-semibold text-gray-900">{{ $item->idEntidad }}</span>
                        </td>
                        <td class="border p-3">
                            <span class="text-sm font-bold text-blue-700">{{ $item->codigo }}</span>
                        </td>
                        <td class="border p-3">
                            <span class="text-sm text-gray-900">{{ $item->subSector }}</span>
                        </td>
                        <td class="border p-3">
                            <span class="text-sm text-gray-900">{{ $item->nivelGobierno }}</span>
                        </td>
                        <td class="border p-3">
                            <span class="px-2.5 py-0.5 text-xs font-bold rounded-full 
                                {{ $item->estado == 'Activo' ? 'bg-green-100 text-green-800' : 
                                   ($item->estado == 'Inactivo' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ $item->estado }}
                            </span>
                        </td>
                        <td class="border p-3">
                            <span class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($item->fechaCreacion)->format('d/m/Y') }}</span>
                        </td>
                        <td class="border p-3">
                            <span class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($item->fechaActualizacion)->format('d/m/Y') }}</span>
                        </td>
                        <td class="border p-3 text-center">
                            <div class="flex justify-center space-x-2">
                                <a href="{{ route('entidad.edit', $item->idEntidad) }}" 
                                   class="inline-flex items-center px-3 py-1.5 bg-yellow-500 text-white text-xs font-bold rounded hover:bg-yellow-600 transition duration-150 shadow-sm"
                                   title="Editar entidad">
                                    <i class="fas fa-edit mr-1"></i>
                                    Editar
                                </a>
                                <form method="POST" action="{{ route('entidad.destroy', $item->idEntidad) }}" 
                                      class="inline"
                                      onsubmit="return confirmDelete(event)">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white text-xs font-bold rounded hover:bg-red-700 transition duration-150 shadow-sm"
                                            title="Eliminar entidad">
                                        <i class="fas fa-trash-alt mr-1"></i>
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Paginación --}}
        @if($entidad->hasPages())
        <div class="px-6 py-4 border-t bg-gray-50">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <p class="text-sm text-gray-700">
                        Mostrando 
                        <span class="font-semibold">{{ $entidad->firstItem() ?? 0 }}</span> 
                        a 
                        <span class="font-semibold">{{ $entidad->lastItem() ?? 0 }}</span> 
                        de 
                        <span class="font-semibold">{{ $entidad->total() }}</span> 
                        entidades
                    </p>
                </div>
                <div class="flex justify-center">
                    {{ $entidad->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
        @endif
        
        @else
        {{-- Mensaje cuando no hay resultados --}}
        <div class="p-12 text-center">
            <div class="flex flex-col items-center justify-center">
                <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-700">No se encontraron entidades</h3>
                <p class="text-gray-500 mt-2">No hay entidades que coincidan con los filtros aplicados.</p>
                <a href="{{ route('entidad.index') }}" class="mt-4 px-4 py-2 bg-blue-100 text-blue-700 rounded-lg font-medium hover:bg-blue-200 transition">
                    <i class="fas fa-eraser mr-1"></i> Limpiar filtros
                </a>
            </div>
        </div>
        @endif
    </div>
    @else
    {{-- Mensaje inicial cuando no hay filtros aplicados --}}
    <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-6 rounded-lg shadow-md mt-8" role="alert">
        <h3 class="font-bold text-lg mb-2 flex items-center">
            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Instrucciones
        </h3>
        <p class="mb-4">Para ver las entidades, selecciona al menos un filtro y haz clic en <strong class="text-blue-800">Buscar</strong>.</p>
        <div class="mt-4 flex flex-wrap gap-2">
            <a href="{{ route('entidad.index') }}?estado=Activo&buscar=true" 
               class="px-3 py-2 bg-blue-100 text-blue-700 text-sm font-medium rounded-lg hover:bg-blue-200 transition flex items-center">
                <i class="fas fa-check-circle mr-2"></i> Ver entidades activas
            </a>
            <a href="{{ route('entidad.index') }}?nivelGobierno=Nacional&buscar=true" 
               class="px-3 py-2 bg-green-100 text-green-700 text-sm font-medium rounded-lg hover:bg-green-200 transition flex items-center">
                <i class="fas fa-flag mr-2"></i> Ver nivel nacional
            </a>
            <a href="{{ route('entidad.index') }}?buscar=true&per_page=10" 
               class="px-3 py-2 bg-purple-100 text-purple-700 text-sm font-medium rounded-lg hover:bg-purple-200 transition flex items-center">
                <i class="fas fa-list mr-2"></i> Ver todas las entidades
            </a>
        </div>
    </div>
    @endif

    {{-- Botón Volver --}}
    <div class="mt-8 pt-4 border-t">
        <a href="{{ route('dashboard.admin') }}" 
           class="inline-flex items-center px-4 py-3 bg-gray-700 text-white font-bold rounded-lg hover:bg-gray-800 transition duration-150 shadow-md">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            VOLVER AL PANEL ADMINISTRATIVO
        </a>
    </div>
</div>

{{-- JavaScript para confirmación de eliminación --}}
<script>
    function confirmDelete(event) {
        event.preventDefault();
        const form = event.target;
        Swal.fire({
            title: '¿Está seguro?',
            text: "Esta acción eliminará permanentemente la entidad y no podrá revertirse",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
        return false;
    }
</script>

{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    .pagination {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .pagination li {
        margin: 0 2px;
    }
    .pagination li a,
    .pagination li span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 2.5rem;
        height: 2.5rem;
        border: 1px solid #e5e7eb;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        font-weight: 500;
        color: #6b7280;
        transition: all 0.15s ease;
    }
    .pagination li a:hover {
        background-color: #f3f4f6;
        color: #374151;
        border-color: #d1d5db;
    }
    .pagination li.active span {
        background-color: #4f46e5;
        color: white;
        border-color: #4f46e5;
    }
</style>
{{-- Íconos Font Awesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
@endsection