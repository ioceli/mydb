@extends('layouts.app')

@section('title','Inicio')

@section('content')
<h2 class="text-2x1 font-bold mb-4"> Listado de programa   </h2>

{{--VALIDACION--}}
    @if (session ('success'))
        <div>
            {{session('success')}}
        </div>
    @endif
    {{--BOTON PARA LLAMAR AL FORMULARIO CREAR PROGRAMA--}}

<a href="{{route('programa.create')}}"> + Nuevo Programa</a>
    {{--TABLA PARA LISTAR TODOS LOS PROGRAMAS--}}

<table style="background-color: #f8f8fa;">
<thead>
<tr>
<th style="border: 1px solid #ccc; padding: 8px">ID</th>
<th style="border: 1px solid #ccc; padding: 8px">NOMBRE</th>
<th style="border: 1px solid #ccc; padding: 8px">ESTADO</th>
<th style="border: 1px solid #ccc; padding: 8px">ACCIONES</th>

</tr>

</thead>
<tbody> 
    @foreach($programa as $programa)
    <tr>
        <td style="border: 1px solid #ccc; padding: 8px">{{$programa->idPrograma}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$programa->nombre}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$programa->estado}}</td>
<td style="border: 1px solid #ccc; padding: 8px">

    {{-- Enlace para Editar --}}
    <a href="{{ route('programa.edit', $programa->idPrograma) }}" style="margin-right: 10px;">✏️Editar</a>

    {{-- Enlace para Eliminar --}}
    <a href="{{ route('programa.edit', $programa->idPrograma) }}" onclick="event.preventDefault(); if(confirm('¿Estás seguro de eliminar este Programa?')) { document.getElementById('form-eliminar-{{ $programa->idPrograma }}').submit(); }" style="color: red;">🗑️ Eliminar</a>

    {{-- Formulario oculto --}}
    <form id="form-eliminar-{{ $programa->idPrograma }}" action="{{ route('programa.destroy', $programa->idPrograma) }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

</td>
</tr>

@endforeach
</tbody>
@endsection