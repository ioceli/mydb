@extends('layouts.app')

@section('title','Nueva Meta Estrategica')

@section('content')

@if ($errors->any())
<div>
    <ul>
        @foreach($errors->all() as $error )
        <li>-{{$error}}
@endforeach
        </li>
    </ul>
</div>
@endif

{{--FORMULAIO PARA LA CREACION DE META ESTRATEGICA--}}
<form action="{{ route ('metaEstrategica.store')}} "method="POST" class="space-y-4">
    @csrf
<div>
    <label class="block">NOMBRE</label>
    <input type="text" name="nombre" required>
</div>
    <div>
    <label class="block">DESCRIPCION</label>
    <input type="text" name="descripcion" required>
</div>
<div>
    <label class="block">FECHA INICIO</label>
    <input type="date" name="fechaInicio" required>
</div>
<div>
    <label class="block">FECHA FIN</label>
    <input type="date" name="fechaFin" required>
</div>
<div>
    <label class="block">FORMULA INDICADOR</label>
    <input type="string" name="formulaIndicador" required>
</div>
<div>
    <label class="block">META ESPERADA</label>
    <input type="number" name="metaEsperada" required>
</div>
<div>
    <label class="block">PROGRESO ACTUAL</label>
    <input type="number" name="progresoActual" required>
</div>
<div>
    <label class="block">TIPO INDICADOR</label>
    <input type="number" name="tipoIndicador" required>
</div>
<div>
    <label class="block">UNIDAD MEDIDA</label>
    <input type="string" name="unidadMedida" required>
</div>
<button type="submit">GUARDAR</button>
<a href="{{route('metaEstrategica.index')}}">VOLVER</a>
</form>

@endsection