@extends('layouts.master')

@section('title','Inicio')

@section('content')
<h2 class="text-2x1 font-bold mb-4"> Listado de Meta Estrategica   </h2>
 
{{--VALIDACION--}}
    @if (session ('success'))
        <div>
            {{session('success')}}
        </div>
    @endif
    {{--BOTON PARA LLAMAR AL FORMULARIO CREAR META ESTRATEGICA--}}

<a href="{{route('metaEstrategica.create')}}"> + Nueva Meta Estrategica</a>
    {{--TABLA PARA LISTAR TODOS LOS META ESTRATEGICA--}}

<table style="background-color: #f8f8fa;">
<thead>
<tr>
<th style="border: 1px solid #ccc; padding: 8px">ID</th>
<th style="border: 1px solid #ccc; padding: 8px">NOMBRE</th>
<th style="border: 1px solid #ccc; padding: 8px">DESCRIPCION</th>
<th style="border: 1px solid #ccc; padding: 8px">FECHA INICIO</th>
<th style="border: 1px solid #ccc; padding: 8px">FECHA FIN</th>
<th style="border: 1px solid #ccc; padding: 8px">FORMULA INDICADOR</th>
<th style="border: 1px solid #ccc; padding: 8px">META ESPERADA</th>
<th style="border: 1px solid #ccc; padding: 8px">PROGRESO ACTUAL </th>
<th style="border: 1px solid #ccc; padding: 8px">TIPO INDICADOR </th>
<th style="border: 1px solid #ccc; padding: 8px">UNIDAD MEDIDA</th>
<th style="border: 1px solid #ccc; padding: 8px">ACCIONES</th>

</tr>

</thead>
<tbody> 
    @foreach($metaEstrategica as $metaEstrategica)
    <tr>
        <td style="border: 1px solid #ccc; padding: 8px">{{$metaEstrategica->idMetaEstrategica}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$metaEstrategica->nombre}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$metaEstrategica->descripcion}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$metaEstrategica->fechaInicio}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$metaEstrategica->fechaFin}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$metaEstrategica->formulaIndicador}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$metaEstrategica->metaEsperada}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$metaEstrategica->progresoActual}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$metaEstrategica->tipoIndicador}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$metaEstrategica->unidadMedida}}</td>
<td style="border: 1px solid #ccc; padding: 8px">

    {{-- Enlace para Editar --}}
    <a href="{{ route('metaEstrategica.edit', $metaEstrategica->idMetaEstrategica) }}" style="margin-right: 10px;">✏️Editar</a>

    {{-- Enlace para Eliminar --}}
    <a href="{{ route('metaEstrategica.edit', $metaEstrategica->idMetaEstrategica) }}" onclick="event.preventDefault(); if(confirm('¿Estás seguro de eliminar este Meta Estrategica?')) { document.getElementById('form-eliminar-{{ $metaEstrategica->idMetaEstrategica }}').submit(); }" style="color: red;">🗑️ Eliminar</a>

    {{-- Formulario oculto --}}
    <form id="form-eliminar-{{ $metaEstrategica->idMetaEstrategica }}" action="{{ route('metaEstrategica.destroy', $metaEstrategica->idMetaEstrategica) }}" method="POST" style="display: none;">
       @csrf
        @method('DELETE')
    </form>

</td>
</tr>

@endforeach
</tbody>
</table>
@endsection