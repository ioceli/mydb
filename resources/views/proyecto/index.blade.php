@extends('layouts.app')

@section('title','Inicio')

@section('content')
<h2 class="text-2x1 font-bold mb-4"> Listado de proyecto   </h2>

{{--VALIDACION--}}
    @if (session ('success'))
        <div>
            {{session('success')}}
        </div>
    @endif
    {{--BOTON PARA LLAMAR AL FORMULARIO CREAR PROYECTO--}}

<a href="{{route('proyecto.create')}}"> + Nuevo Proyecto</a>
    {{--TABLA PARA LISTAR TODOS LOS PROYECTOS--}}

<table style="background-color: #f8f8fa;">
<thead>
<tr>
<th style="border: 1px solid #ccc; padding: 8px">ID</th>
<th style="border: 1px solid #ccc; padding: 8px">ENTIDAD</th>
<th style="border: 1px solid #ccc; padding: 8px">NOMBRE</th>
<th style="border: 1px solid #ccc; padding: 8px">ESTADO</th>
<th style="border: 1px solid #ccc; padding: 8px">ACCIONES</th>

</tr>

</thead>
<tbody> 
    @foreach($proyecto as $proyecto)
    <tr>
        <td style="border: 1px solid #ccc; padding: 8px">{{$proyecto->idProyecto}}</td>
                <td style="border: 1px solid #ccc; padding: 8px">{{$proyecto->entidad->subSector}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$proyecto->nombre}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$proyecto->estado}}</td>
<td style="border: 1px solid #ccc; padding: 8px">

    {{-- Enlace para Editar --}}
    <a href="{{ route('proyecto.edit', $proyecto->idProyecto) }}" style="margin-right: 10px;">✏️Editar</a>

    {{-- Enlace para Eliminar --}}
    <a href="{{ route('proyecto.edit', $proyecto->idProyecto) }}" onclick="event.preventDefault(); if(confirm('¿Estás seguro de eliminar este Proyecto?')) { document.getElementById('form-eliminar-{{ $proyecto->idProyecto }}').submit(); }" style="color: red;">🗑️ Eliminar</a>

    {{-- Formulario oculto --}}
    <form id="form-eliminar-{{ $proyecto->idProyecto }}" action="{{ route('proyecto.destroy', $proyecto->idProyecto) }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

</td>
</tr>

@endforeach
</tbody>
</table>
@endsection