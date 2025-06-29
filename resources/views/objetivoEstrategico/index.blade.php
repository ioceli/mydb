@extends('layouts.app')

@section('title','Inicio')

@section('content')
<h2 class="text-2x1 font-bold mb-4"> Listado de Objetivo Estrategico   </h2>

{{--VALIDACION--}}
    @if (session ('success'))
        <div>
            {{session('success')}}
        </div>
    @endif
    {{--BOTON PARA LLAMAR AL FORMULARIO CREAR OBJETIVO ESTRATEGICO--}}

<a href="{{route('objetivoEstrategico.create')}}"> + Nuevo Objetivo Estrategico</a>
    {{--TABLA PARA LISTAR TODOS LOS OBJETIVO ESTRATEGICO--}}

<table style="background-color: #f8f8fa;">
<thead>
<tr>
<th style="border: 1px solid #ccc; padding: 8px">ID</th>
<th style="border: 1px solid #ccc; padding: 8px">DESCRIPCION</th>
<th style="border: 1px solid #ccc; padding: 8px">FECHA REGISTRO</th>
<th style="border: 1px solid #ccc; padding: 8px">ESTADO</th>
<th style="border: 1px solid #ccc; padding: 8px">ACCIONES</th>

</tr>

</thead>
<tbody> 
    @foreach($objetivoEstrategico as $objetivoEstrategico)
    <tr>
        <td style="border: 1px solid #ccc; padding: 8px">{{$objetivoEstrategico->idObjetivoEstrategico}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$objetivoEstrategico->descripcion}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$objetivoEstrategico->fechaRegistro}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$objetivoEstrategico->estado}}</td>
<td style="border: 1px solid #ccc; padding: 8px">

    {{-- Enlace para Editar --}}
    <a href="{{ route('objetivoEstrategico.edit', $objetivoEstrategico->idObjetivoEstrategico) }}" style="margin-right: 10px;">✏️Editar</a>

    {{-- Enlace para Eliminar --}}
    <a href="{{ route('objetivoEstrategico.edit', $objetivoEstrategico->idObjetivoEstrategico) }}" onclick="event.preventDefault(); if(confirm('¿Estás seguro de eliminar este Objetivo Estrategico?')) { document.getElementById('form-eliminar-{{ $objetivoEstrategico->idObjetivoEstrategico }}').submit(); }" style="color: red;">🗑️ Eliminar</a>

    {{-- Formulario oculto --}}
    <form id="form-eliminar-{{ $objetivoEstrategico->idObjetivoEstrategico }}" action="{{ route('objetivoEstrategico.destroy', $objetivoEstrategico->idObjetivoEstrategico) }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

</td>
</tr>

@endforeach
</tbody>
@endsection