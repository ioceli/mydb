@extends('layouts.master')

@section('title','Inicio')

@section('content')
<h2 class="text-2x1 font-bold mb-4"> Listado de Objetivo Desarrollo Sostenible   </h2>

{{--VALIDACION--}}
    @if (session ('success'))
        <div>
            {{session('success')}}
        </div>
    @endif
    {{--BOTON PARA LLAMAR AL FORMULARIO CREAR OBJETIVO DESARROLLO SOSTENIBLE--}}

<a href="{{route('objetivoDesarrolloSostenible.create')}}"> + Nuevo Objetivo Desarrollo Sostenible</a>
    {{--TABLA PARA LISTAR TODOS LOS OBJETIVO DESARROLLO SOSTENIBLE--}}

<table style="background-color: #f8f8fa;">
<thead>
<tr>
<th style="border: 1px solid #ccc; padding: 8px">ID</th>
<th style="border: 1px solid #ccc; padding: 8px">NUMERO</th>
<th style="border: 1px solid #ccc; padding: 8px">NOMBRE</th>
<th style="border: 1px solid #ccc; padding: 8px">DESCRIPCION</th>
<th style="border: 1px solid #ccc; padding: 8px">ACCIONES</th>

</tr>

</thead>
<tbody> 
    @foreach($objetivoDesarrolloSostenible as $objetivoDesarrolloSostenible)
    <tr>
        <td style="border: 1px solid #ccc; padding: 8px">{{$objetivoDesarrolloSostenible->idObjetivoDesarrolloSostenible}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$objetivoDesarrolloSostenible->numero}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$objetivoDesarrolloSostenible->nombre}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$objetivoDesarrolloSostenible->descripcion}}</td>
<td style="border: 1px solid #ccc; padding: 8px">

    {{-- Enlace para Editar --}}
    <a href="{{ route('objetivoDesarrolloSostenible.edit', $objetivoDesarrolloSostenible->idObjetivoDesarrolloSostenible) }}" style="margin-right: 10px;">✏️Editar</a>

    {{-- Enlace para Eliminar --}}
    <a href="{{ route('objetivoDesarrolloSostenible.edit', $objetivoDesarrolloSostenible->idObjetivoDesarrolloSostenible) }}" onclick="event.preventDefault(); if(confirm('¿Estás seguro de eliminar este Objetivo Desarrollo Sostenible?')) { document.getElementById('form-eliminar-{{ $objetivoDesarrolloSostenible->idObjetivoDesarrolloSostenible }}').submit(); }" style="color: red;">🗑️ Eliminar</a>

    {{-- Formulario oculto --}}
    <form id="form-eliminar-{{ $objetivoDesarrolloSostenible->idObjetivoDesarrolloSostenible }}" action="{{ route('objetivoDesarrolloSostenible.destroy', $objetivoDesarrolloSostenible->idObjetivoDesarrolloSostenible) }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

</td>
</tr>

@endforeach
</tbody>
</table>
@endsection