@extends('layouts.master')

@section('title','Inicio')

@section('content')
<h2 class="text-2x1 font-bold mb-4"> Listado de Indicador   </h2>
 
{{--VALIDACION--}}
    @if (session ('success'))
        <div>
            {{session('success')}}
        </div>
    @endif
    {{--BOTON PARA LLAMAR AL FORMULARIO CREAR INDICADOR--}}

<a href="{{route('indicador.create')}}"> + Nuevo Indicador</a>
    {{--TABLA PARA LISTAR TODOS LOS INDICADOR--}}

<table style="background-color: #f8f8fa;">
<thead>
<tr>
<th style="border: 1px solid #ccc; padding: 8px">ID</th>
<th style="border: 1px solid #ccc; padding: 8px">NOMBRE</th>
<th style="border: 1px solid #ccc; padding: 8px">DESCRIPCION</th>
<th style="border: 1px solid #ccc; padding: 8px">FECHA MEDICION</th>
<th style="border: 1px solid #ccc; padding: 8px">FORMULA</th>
<th style="border: 1px solid #ccc; padding: 8px">TIPO</th>
<th style="border: 1px solid #ccc; padding: 8px">UNIDAD MEDIDA</th>
<th style="border: 1px solid #ccc; padding: 8px">VALOR ACTUAL </th>
<th style="border: 1px solid #ccc; padding: 8px">VALOR BASE </th>
<th style="border: 1px solid #ccc; padding: 8px">VALOR META</th>
<th style="border: 1px solid #ccc; padding: 8px">ACCIONES</th>

</tr>

</thead>
<tbody> 
    @foreach($indicador as $indicador)
    <tr>
        <td style="border: 1px solid #ccc; padding: 8px">{{$indicador->idIndicador}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$indicador->nombre}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$indicador->descripcion}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$indicador->fechaMedicion}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$indicador->formula}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$indicador->tipo}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$indicador->unidadMedida}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$indicador->valorActual}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$indicador->valorBase}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$indicador->valorMeta}}</td>
<td style="border: 1px solid #ccc; padding: 8px">

    {{-- Enlace para Editar --}}
    <a href="{{ route('indicador.edit', $indicador->idIndicador) }}" style="margin-right: 10px;">✏️Editar</a>

    {{-- Enlace para Eliminar --}}
    <a href="{{ route('indicador.edit', $indicador->idIndicador) }}" onclick="event.preventDefault(); if(confirm('¿Estás seguro de eliminar este Indicador?')) { document.getElementById('form-eliminar-{{ $indicador->idIndicador }}').submit(); }" style="color: red;">🗑️ Eliminar</a>

    {{-- Formulario oculto --}}
    <form id="form-eliminar-{{ $indicador->idIndicador }}" action="{{ route('indicador.destroy', $indicador->idIndicador) }}" method="POST" style="display: none;">
       @csrf
        @method('DELETE')
    </form>

</td>
</tr>

@endforeach
</tbody>
</table>
@endsection