@extends('layouts.master')
@section('title','Inicio')
@section('content')
<h2 class="text-2x1 font-bold mb-4"> Listado de entidades   </h2>
@if (session('success'))
    <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif
    {{--BOTON PARA LLAMAR AL FORMULARIO CREAR ENTIDADES--}}
<a href="{{route('entidad.create')}}"class="font-bold mb-4 inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Nueva Entidad</a>
{{-- FORMULARIO DE FILTROS --}}
<form method="GET" action="{{ route('entidad.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6 p-4 bg-gray-100 rounded shadow-sm">
    {{-- Filtro por Estado --}}
    <div>
        <label for="estado" class="block text-sm font-medium text-gray-700">Estado</label>
        <select id="estado" name="estado" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            <option value="">Todos</option>
            @foreach($estados as $e)
                <option value="{{ $e }}" {{ request('estado') == $e ? 'selected' : '' }}>
                    {{ $e }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Filtro por nivel de Gobierno --}}
    <div>
        <label for="nivelGobierno" class="block text-sm font-medium text-gray-700">Nivel de Gobierno</label>
        <select id="nivelGobierno" name="nivelGobierno" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            <option value="">Todos</option>
            @foreach($nivelesGobierno as $s)
                <option value="{{ $s }}" {{ request('nivelGobierno') == $s ? 'selected' : '' }}>
                    {{ $s }}
                </option>
            @endforeach
        </select>
    </div>
    {{-- Filtro por Fecha de Creación Desde --}}
    <div>
        <label for="fecha_desde" class="block text-sm font-medium text-gray-700">F. Creación</label>
        <input type="date" id="fecha_desde" name="fecha_desde" value="{{ request('fecha_desde') }}"
               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
    </div>
    {{-- Botones de Acción --}}
    <div class="md:col-span-1 flex items-end gap-2">
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Filtrar
        </button>
        <a href="{{ route('entidad.index') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
            Limpiar
        </a>
    </div>
</form> 
{{-- FORMULARIO PARA CAMBIAR REGISTROS POR PÁGINA --}}
<div class="flex justify-end mb-3">
    <form method="GET" action="{{ route('entidad.index') }}" class="flex items-center gap-2">
        <label for="per_page" class="text-sm font-medium text-gray-700">Mostrar:</label>
        <select name="per_page" id="per_page" class="form-select" onchange="this.form.submit()">
            <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
            <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
            <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
        </select>
    </form>
</div>
{{--TABLA PARA LISTAR TODAS LAS ENTIDADES--}}
<div class="overflow-x-auto bg-white rounded shadow">
    <table class="min-w-full table-auto border-collapse">
        <thead class="bg-gray-200 text-gray-700 text-left">
            <tr>
                <th style="border: 1px solid #ccc; padding: 8px">ID</th>
                <th style="border: 1px solid #ccc; padding: 8px">CODIGO</th>
                <th style="border: 1px solid #ccc; padding: 8px">SUBSECTOR</th>
                <th style="border: 1px solid #ccc; padding: 8px">NIVEL DE GOBIERNO</th>
                <th style="border: 1px solid #ccc; padding: 8px">ESTADO</th>
                <th style="border: 1px solid #ccc; padding: 8px">FECHA DE CREACION</th>
                <th style="border: 1px solid #ccc; padding: 8px">FECHA DE ACTUALIZACION</th>
                <th style="border: 1px solid #ccc; padding: 8px">ACCIONES</th>
            </tr>
        </thead>
<tbody> 
    @foreach($entidad as $item)
    <tr class="border-b" >
        <td  class="p-2">{{$item->idEntidad}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$item->codigo}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$item->subSector}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$item->nivelGobierno}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$item->estado}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$item->fechaCreacion}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$item->fechaActualizacion}}</td>
 <td class="p-2 flex gap-2">

    {{-- Enlace para Editar --}}
    <a href="{{ route('entidad.edit', $item->idEntidad) }}" class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600">Editar</a>
 {{-- Enlace para Eliminar --}}
    <form method="POST" action="{{ route('entidad.destroy', $item->idEntidad) }}" onsubmit="return confirm('¿Está seguro de eliminar esta entidad?')">
        @csrf
        @method('DELETE')
        <button class="bg-red-600 text-white px-2 py-1 rounded hover:bg-red-700">Eliminar</button>
    </form>
</td>
</tr>
@endforeach
</tbody>
</table>
</div>
<div class="mt-4">
        {{ $entidad->links() }} 
</div>
<div class="mt-4">
<a href="{{ route('dashboard.admin') }}" class="font-bold bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">REGRESAR</a> 
</div>
@endsection