@extends('layouts.master')

@section('title','Inicio')

@section('content')
<h2 class="text-2x1 font-bold mb-4"> Listado de Objetivo Plan Nacional   </h2>

{{--VALIDACION--}}
    @if (session ('success'))
        <div>
            {{session('success')}}
        </div>
    @endif
    {{--BOTON PARA LLAMAR AL FORMULARIO CREAR OBJETIVO PLAN NACIONAL--}}

<a href="{{route('objetivoPlanNacional.create')}}"> + Nuevo Objetivo Plan Nacional</a>
    {{--TABLA PARA LISTAR TODOS LOS OBJETIVO PLAN NACIONAL--}}

<table style="background-color: #f8f8fa;">
<thead>
<tr>
<th style="border: 1px solid #ccc; padding: 8px">ID</th>
<th style="border: 1px solid #ccc; padding: 8px">CODIGO</th>
<th style="border: 1px solid #ccc; padding: 8px">NOMBRE</th>
<th style="border: 1px solid #ccc; padding: 8px">DESCRIPCION</th>
<th style="border: 1px solid #ccc; padding: 8px">EJE PLAN NACIONAL</th>
<th style="border: 1px solid #ccc; padding: 8px">ACCIONES</th>

</tr>

</thead>
<tbody> 
    @foreach($objetivoPlanNacional as $objetivoPlanNacional)
    <tr>
        <td style="border: 1px solid #ccc; padding: 8px">{{$objetivoPlanNacional->idObjetivoPlanNacional}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$objetivoPlanNacional->codigo}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$objetivoPlanNacional->nombre}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$objetivoPlanNacional->descripcion}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$objetivoPlanNacional->ejePnd}}</td>
<td style="border: 1px solid #ccc; padding: 8px">

    {{-- Enlace para Editar --}}
    <a href="{{ route('objetivoPlanNacional.edit', $objetivoPlanNacional->idObjetivoPlanNacional) }}" style="margin-right: 10px;">✏️Editar</a>

    {{-- Enlace para Eliminar --}}
    <a href="{{ route('objetivoPlanNacional.edit', $objetivoPlanNacional->idObjetivoPlanNacional) }}" onclick="event.preventDefault(); if(confirm('¿Estás seguro de eliminar este Objetivo del Plan Nacional?')) { document.getElementById('form-eliminar-{{ $objetivoPlanNacional->idObjetivoPlanNacional }}').submit(); }" style="color: red;">🗑️ Eliminar</a>

    {{-- Formulario oculto --}}
    <form id="form-eliminar-{{ $objetivoPlanNacional->idObjetivoPlanNacional }}" action="{{ route('objetivoPlanNacional.destroy', $objetivoPlanNacional->idObjetivoPlanNacional) }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

</td>
</tr>

@endforeach
</tbody>
</table>
@endsection