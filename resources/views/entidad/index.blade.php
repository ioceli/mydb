@extends('layouts.app')

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

<a href="{{route('entidad.create')}}"> + Nueva Entidad</a>
    {{--TABLA PARA LISTAR TODAS LAS ENTIDADES--}}

<table style="background-color: #f8f8fa;">
<thead>
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
    <tr>
        <td style="border: 1px solid #ccc; padding: 8px">{{$entidad->idEntidad}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$entidad->codigo}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$entidad->subSector}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$entidad->nivelGobierno}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$entidad->estado}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$entidad->fechaCreacion}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$entidad->fechaActualizacion}}</td>
 <td style="border: 1px solid #ccc; padding: 8px">

    {{-- Enlace para Editar --}}
    <a href="{{ route('entidad.edit', $entidad->idEntidad) }}" style="margin-right: 10px;">✏️Editar</a>

    {{-- Enlace para Eliminar --}}
    <a href="{{ route('entidad.edit', $entidad->idEntidad) }}" onclick="event.preventDefault(); if(confirm('¿Estás seguro de eliminar esta entidad?')) { document.getElementById('form-eliminar-{{ $entidad->idEntidad }}').submit(); }" style="color: red;">🗑️ Eliminar</a>

    {{-- Formulario oculto --}}
    <form id="form-eliminar-{{ $entidad->idEntidad }}" action="{{ route('entidad.destroy', $entidad->idEntidad) }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

</td>
</tr>

@endforeach
</tbody>
@endsection