@extends('layouts.app')

@section('title','Inicio')

@section('content')
<h2 class="text-2x1 font-bold mb-4"> Listado de Meta Plan Nacional   </h2>

{{--VALIDACION--}}
    @if (session ('success'))
        <div>
            {{session('success')}}
        </div>
    @endif
    {{--BOTON PARA LLAMAR AL FORMULARIO CREAR META PLAN NACIONAL--}}

<a href="{{route('metaPlanNacional.create')}}"> + Nueva Meta Plan Nacional</a>
    {{--TABLA PARA LISTAR TODOS LOS META PLAN NACIONAL--}}

<table style="background-color: #f8f8fa;">
<thead>
<tr>
<th style="border: 1px solid #ccc; padding: 8px">ID</th>
<th style="border: 1px solid #ccc; padding: 8px">NOMBRE</th>
<th style="border: 1px solid #ccc; padding: 8px">DESCRIPCION</th>
<th style="border: 1px solid #ccc; padding: 8px">PORCENTAJE ALINEACION</th>
<th style="border: 1px solid #ccc; padding: 8px">ACCIONES</th>

</tr>

</thead>
<tbody> 
    @foreach($metaPlanNacional as $metaPlanNacional)
    <tr>
        <td style="border: 1px solid #ccc; padding: 8px">{{$metaPlanNacional->idMetaPlanNacional}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$metaPlanNacional->nombre}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$metaPlanNacional->descripcion}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$metaPlanNacional->porcentajeAlineacion}}</td>
<td style="border: 1px solid #ccc; padding: 8px">

    {{-- Enlace para Editar --}}
    <a href="{{ route('metaPlanNacional.edit', $metaPlanNacional->idMetaPlanNacional) }}" style="margin-right: 10px;">✏️Editar</a>

    {{-- Enlace para Eliminar --}}
    <a href="{{ route('metaPlanNacional.edit', $metaPlanNacional->idMetaPlanNacional) }}" onclick="event.preventDefault(); if(confirm('¿Estás seguro de eliminar esta Meta del Plan Nacional?')) { document.getElementById('form-eliminar-{{ $metaPlanNacional->idMetaPlanNacional }}').submit(); }" style="color: red;">🗑️ Eliminar</a>

    {{-- Formulario oculto --}}
    <form id="form-eliminar-{{ $metaPlanNacional->idMetaPlanNacional }}" action="{{ route('metaPlanNacional.destroy', $metaPlanNacional->idMetaPlanNacional) }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

</td>
</tr>

@endforeach
</tbody>
</table>
@endsection