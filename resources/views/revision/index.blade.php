@extends('layouts.master')
@section('content')
@php
    use App\Enums\EstadoRevisionEnum;
@endphp
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-extrabold mb-6 text-gray-800 border-b pb-2">Panel de Revisión Técnica</h1>
    {{-- Mensaje de éxito --}}
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-sm" role="alert">
            <p class="font-bold">¡Éxito!</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif
    {{-- FORMULARIO DE FILTROS Y SELECCIÓN --}}
    <div class="bg-white p-6 rounded-xl shadow-lg mb-8 border border-blue-200">
        <h2 class="text-xl font-semibold mb-4 text-gray-700">1. Seleccionar Tipo y Filtros</h2>
        <form method="GET" action="{{ route('revision.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
            {{-- 1. Tipo de Revisión --}}
            <div>
                <label for="tipo_revision" class="block text-sm font-medium text-gray-700">¿Qué desea revisar?</label>
                <select id="tipo_revision" name="tipo_revision" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 text-base bg-blue-50 font-bold">
                    <option value="" disabled {{ !request('tipo_revision') ? 'selected' : '' }}>-- Seleccione Tipo --</option>
                    @foreach(['planes', 'programas', 'proyectos'] as $type)
                        <option value="{{ $type }}" {{ request('tipo_revision') == $type ? 'selected' : '' }}>
                            {{ ucfirst($type) }}
                        </option>
                    @endforeach
                </select>
            </div>
            {{-- 2. Filtro por Subsector --}}
            <div>
                <label for="subsector" class="block text-sm font-medium text-gray-700">Filtrar por Subsector</label>
                <select id="subsector" name="subsector"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2">
                    <option value="">Todos los Subsectores</option>
                    @foreach($subsectores as $subsector)
                        <option value="{{ $subsector }}" {{ request('subsector') == $subsector ? 'selected' : '' }}>
                            {{ $subsector }}
                        </option>
                    @endforeach
                </select>
            </div>
            {{-- 3. Filtro por Estado --}}
            <div>
                <label for="estado_revision" class="block text-sm font-medium text-gray-700">Filtrar por Estado</label>
                <select id="estado_revision" name="estado_revision"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2">
                    <option value="">Todos los Estados</option>
                    @foreach($estadosRevision as $estado)
                        @php $estadoValue = $estado instanceof \App\Enums\EstadoRevisionEnum ? $estado->value : $estado; @endphp
                        <option value="{{ $estadoValue }}" {{ request('estado_revision') == $estadoValue ? 'selected' : '' }}>
                            {{ ucfirst($estadoValue) }}
                        </option>
                    @endforeach
                </select>
            </div>
            {{-- 4. Registros por página --}}
            <div>
                <label for="per_page" class="block text-sm font-medium text-gray-700">Registros por página</label>
                <select id="per_page" name="per_page"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2">
                    @foreach([10, 50, 100] as $num)
                        <option value="{{ $num }}" {{ request('per_page', $perPage) == $num ? 'selected' : '' }}>
                            {{ $num }}
                        </option>
                    @endforeach
                </select>
            </div>
            {{-- 5. Botones --}}
            <div class="flex space-x-2">
                <button type="submit"
                    class="w-full px-4 py-2 bg-blue-600 text-white rounded-md font-bold hover:bg-blue-700 transition duration-150 shadow-md">
                    <i class="fas fa-search mr-1"></i> Buscar
                </button>
                <a href="{{ route('revision.index') }}"
                    class="w-full px-4 py-2 bg-gray-300 text-gray-800 rounded-md font-bold hover:bg-gray-400 transition duration-150 text-center shadow-md">
                    <i class="fas fa-eraser mr-1"></i> Limpiar
                </a>
            </div>
        </form>
    </div>
    {{-- TABLAS DE RESULTADOS --}}
    @php
        $dataCollections = [
            'planes' => $planes,
            'programas' => $programas,
            'proyectos' => $proyectos,
        ];
    @endphp
    @foreach ($dataCollections as $tipo => $items)
        @if (!empty($items) && request('tipo_revision') === $tipo)
            <div class="mb-10 p-4 border rounded-xl shadow-lg bg-gray-50">
                <h2 class="text-2xl font-bold mb-4 text-blue-800">
                    2. Resultados de Revisión: {{ ucfirst($tipo) }} 
                    <span class="text-gray-600 text-base font-normal">({{ $items->total() }} encontrados)</span>
                </h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden border">
                        <thead class="bg-blue-600 text-white">
                            <tr>
                                <th class="px-4 py-3 text-left">ID</th>
                                <th class="px-4 py-3 text-left">Entidad</th>
                                <th class="px-4 py-3 text-left">Subsector</th>
                                <th class="px-4 py-3 text-left">Nombre</th>
                                <th class="px-4 py-3 text-left">Estado provisional</th>
                                <th class="px-4 py-3 text-left">Objetivos Estratégicos</th>
                                <th class="px-4 py-3 text-left">Metas Estratégicas</th>
                                <th class="px-4 py-3 text-center">Actualizar Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                @php
                                    $primaryKey = $tipo === 'planes' ? 'idPlan' : ($tipo === 'programas' ? 'idPrograma' : 'idProyecto');
                                    $entidadCodigo = $item->entidad->codigo ?? '-'; 
                                    $entidadSubsector = $item->entidad->subSector ?? '-';
                                    $currentStatus = $item->estado_revision instanceof \App\Enums\EstadoRevisionEnum 
                                        ? $item->estado_revision->value 
                                        : $item->estado_revision;
                                @endphp
                                <tr class="border-b hover:bg-blue-50 transition duration-100">
                                    <td class="border p-3 font-semibold">{{ $item->$primaryKey }}</td>
                                    <td class="border p-3">{{ $entidadCodigo }}</td>
                                    <td class="border p-3">{{ $entidadSubsector }}</td>
                                    <td class="border p-3 max-w-xs truncate">{{ $item->nombre ?? '-' }}</td>
                                    <td class="border p-3">
                                        <span class="px-3 py-1 text-sm rounded-full font-bold 
                                            {{ $currentStatus == 'Aprobado' ? 'bg-green-200 text-green-800' : 
                                               ($currentStatus == 'Devuelto' ? 'bg-red-200 text-red-800' : 'bg-yellow-200 text-yellow-800') }}">
                                            {{ ucfirst($currentStatus) }}
                                        </span>
                                    </td>
                                    <td class="border p-3 text-sm max-w-xs">
                                        @forelse ($item->objetivosEstrategicos as $obj)
                                            <div class="truncate">- {{ $obj->descripcion }}</div>
                                        @empty
                                            <span class="text-gray-400">Sin objetivos</span>
                                        @endforelse
                                    </td>
                                    <td class="border p-3 text-sm max-w-xs">
                                        @forelse ($item->metasEstrategicas as $meta)
                                            <div class="truncate">- {{ $meta->nombre }}</div>
                                        @empty
                                            <span class="text-gray-400">Sin metas</span>
                                        @endforelse
                                    </td>
                                    <td class="border p-3 text-center">
                                        <form action="{{ route('revision.estado', ['tipo' => $tipo, 'id' => $item->$primaryKey]) }}" method="POST" class="flex flex-col items-center space-y-1">
                                            @csrf
                                            @method('PUT')
                                            {{-- Mantener filtros --}}
                                            <input type="hidden" name="tipo_revision" value="{{ request('tipo_revision') }}">
                                            <input type="hidden" name="subsector" value="{{ request('subsector') }}">
                                            <input type="hidden" name="estado_revision_filtro" value="{{ request('estado_revision') }}">
                                            <input type="hidden" name="page" value="{{ $items->currentPage() }}">
                                            <input type="hidden" name="per_page" value="{{ request('per_page', $perPage) }}">
                                            <select name="estado_revision" class="border rounded px-2 py-1 text-sm w-full focus:ring-blue-500">
                                                @foreach($estadosRevision as $estadoUpdate)
                                                    @php $updateValue = $estadoUpdate instanceof \App\Enums\EstadoRevisionEnum ? $estadoUpdate->value : $estadoUpdate; @endphp
                                                    <option value="{{ $updateValue }}" {{ $currentStatus == $updateValue ? 'selected' : '' }}>
                                                        {{ ucfirst($updateValue) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <button type="submit"
                                                class="w-full bg-green-500 text-white px-3 py-1 text-sm rounded hover:bg-green-600 font-semibold transition duration-150">
                                                Guardar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- PAGINACIÓN --}}
                <div class="mt-6 flex justify-center">
                    {{ $items->appends(request()->query())->links() }}
                </div>
            </div>
        @endif
    @endforeach
    {{-- MENSAJE INICIAL --}}
    @if (!request('tipo_revision'))
        <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-6 rounded-lg shadow-md mt-8" role="alert">
            <h3 class="font-bold text-lg mb-2"><i class="fas fa-info-circle mr-2"></i> Bienvenid@ al Módulo de Revisión</h3>
            <p>Para empezar, <strong>seleccione un tipo de elemento</strong> (Plan, Programa o Proyecto) en el formulario de arriba y haga clic en <strong>Buscar</strong>. Los filtros de Subsector y Estado son opcionales.</p>
        </div>
    @endif
</div>
{{-- BOTÓN VOLVER --}}
<div class="p-4 bg-gray-100 mt-4 border-t">
    <a href="{{ route('dashboard.revisor') }}" class="font-bold bg-gray-700 text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition duration-150 inline-flex items-center">
        <i class="fas fa-arrow-left mr-2"></i> VOLVER AL DASHBOARD
    </a>
</div>
{{-- Íconos Font Awesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
@endsection