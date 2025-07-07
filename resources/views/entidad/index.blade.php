@extends('layouts.master')

@section('title','Inicio')

@section('content')


<h2 class="text-2x1 font-bold mb-4"> Listado de entidades   </h2>

{{--VALIDACION--}}
    @if (session ('success'))
        <div>
            {{session('success')}}
        </div>
    @endif
    {{--BOTON PARA LLAMAR AL FORMULARIO CREAR ENTIDADES--}}

<a href="{{route('entidad.create')}}"class="mb-4 inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Nueva Entidad</a>
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
    @foreach($entidad as $entidad)
    <tr class="border-b" >
        <td  class="p-2">{{$entidad->idEntidad}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$entidad->codigo}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$entidad->subSector}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$entidad->nivelGobierno}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$entidad->estado}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$entidad->fechaCreacion}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$entidad->fechaActualizacion}}</td>
 <td class="p-2 flex gap-2">

    {{-- Enlace para Editar --}}
    <a href="{{ route('entidad.edit', $entidad->idEntidad) }}" class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600">Editar</a>
 {{-- Enlace para Eliminar --}}
    <form method="POST" action="{{ route('entidad.destroy', $entidad->idEntidad) }}" onsubmit="return confirm('¿Está seguro de eliminar esta entidad?')">
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
<a href="{{ route('dashboard.admin') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">REGRESAR</a> 
</div>
@endsection