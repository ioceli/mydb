@extends('layouts.app')

@section('title','Inicio')

@section('content')
<h2 class="text-2x1 font-bold mb-4"> LISTADO DE PERSONAS   </h2>

{{--VALIDACION--}}
    @if (session ('success'))
        <div>
            {{session('success')}}
        </div>
    @endif
    {{--BOTON PARA LLAMAR AL FORMULARIO CREAR PERSONA--}}

<a href="{{route('persona.create')}}"> + Nueva Persona</a>
    {{--TABLA PARA LISTAR TODAS LAS PERSONAS--}}

<table style="background-color: #f8f8fa;">
<thead>
<tr>
<th style="border: 1px solid #ccc; padding: 8px">ID</th>
<th style="border: 1px solid #ccc; padding: 8px">CEDULA</th>
<th style="border: 1px solid #ccc; padding: 8px">NOMBRES</th>
<th style="border: 1px solid #ccc; padding: 8px">APELLIDOS</th>
<th style="border: 1px solid #ccc; padding: 8px">ROL</th>
<th style="border: 1px solid #ccc; padding: 8px">ESTADO</th>
<th style="border: 1px solid #ccc; padding: 8px">CORREO</th>
<th style="border: 1px solid #ccc; padding: 8px">GENERO</th>
<th style="border: 1px solid #ccc; padding: 8px">TELEFONO</th>
<th style="border: 1px solid #ccc; padding: 8px">CONTRASEÑA</th>
<th style="border: 1px solid #ccc; padding: 8px">ACCIONES</th>

</tr>

</thead>
<tbody> 
    @foreach($persona as $persona)
    <tr>
        <td style="border: 1px solid #ccc; padding: 8px">{{$persona->idPersona}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$persona->cedula}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$persona->nombres}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$persona->apellidos}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$persona->rol}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$persona->estado}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$persona->correo}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$persona->genero}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$persona->telefono}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$persona->contraseña}}</td>  
 <td style="border: 1px solid #ccc; padding: 8px">

    {{-- Enlace para Editar --}}
    <a href="{{ route('persona.edit', $persona->idPersona) }}" style="margin-right: 10px;">✏️Editar</a>

    {{-- Enlace para Eliminar --}}
    <a href="{{ route('persona.edit', $persona->idPersona) }}" onclick="event.preventDefault(); if(confirm('¿Estás seguro de eliminar esta persona?')) { document.getElementById('form-eliminar-{{ $persona->idPersona }}').submit(); }" style="color: red;">🗑️ Eliminar</a>

    {{-- Formulario oculto --}}
    <form id="form-eliminar-{{ $persona->idPersona }}" action="{{ route('persona.destroy', $persona->idPersona) }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

</td>
</tr>

@endforeach
</tbody>
@endsection