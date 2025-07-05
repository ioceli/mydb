@extends('layouts.master')

@section('title','Inicio')

@section('content')
<h2 class="text-2x1 font-bold mb-4"> Listado de Auditoria   </h2>
 
{{--VALIDACION--}}
    @if (session ('success'))
        <div>
            {{session('success')}}
        </div>
    @endif
    {{--BOTON PARA LLAMAR AL FORMULARIO CREAR AUDITORIA--}}

<a href="{{route('auditoria.create')}}"> + Nueva Auditoria</a>
    {{--TABLA PARA LISTAR TODOS LOS AUDITORIA--}}

<table style="background-color: #f8f8fa;">
<thead>
<tr>
<th style="border: 1px solid #ccc; padding: 8px">ID</th>
<th style="border: 1px solid #ccc; padding: 8px">NOMBRE</th>
<th style="border: 1px solid #ccc; padding: 8px">ACCIONES</th>

</tr>

</thead>
<tbody> 
    @foreach($auditoria as $auditoria)
    <tr>
        <td style="border: 1px solid #ccc; padding: 8px">{{$auditoria->idAuditoria}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$auditoria->nombre}}</td>
<td style="border: 1px solid #ccc; padding: 8px">

    {{-- Enlace para Editar --}}
    <a href="{{ route('auditoria.edit', $auditoria->idAuditoria) }}" style="margin-right: 10px;">✏️Editar</a>

    {{-- Enlace para Eliminar --}}
    <a href="{{ route('auditoria.edit', $auditoria->idAuditoria) }}" onclick="event.preventDefault(); if(confirm('¿Estás seguro de eliminar esta Auditoria?')) { document.getElementById('form-eliminar-{{ $auditoria->idAuditoria }}').submit(); }" style="color: red;">🗑️ Eliminar</a>

    {{-- Formulario oculto --}}
    <form id="form-eliminar-{{ $auditoria->idAuditoria }}" action="{{ route('auditoria.destroy', $auditoria->idAuditoria) }}" method="POST" style="display: none;">
       @csrf
        @method('DELETE')
    </form>

</td>
</tr>

@endforeach
</tbody>
</table>
@endsection