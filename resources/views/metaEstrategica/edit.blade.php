@extends('layouts.app')

@section('title','Editar Meta Estrategica')

@section('content')
@if ($errors->any())
    <div>
        <ul>
            @foreach($errors->all() as $error )
                <li>- {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<h2 class="text-2x1 font-bold mb-4"> EDITAR META ESTRATEGICA   </h2>

<form action="{{route ('metaEstrategica.update', $metaEstrategica->idMetaEstrategica )}}"method="POST" class="space-y-4">
@csrf
@method('PUT')
<div>
    <label class="block">NOMBRE</label>
    <input type="text" name="nombre" required value="{{old('nombre', $metaEstrategica->nombre)}}">
</div>
<div>
    <label class="block">DESCRIPCION</label>
    <input type="text" name="descripcion" required value="{{old('descripcion', $metaEstrategica->descripcion)}}">
</div>
<div>
    <label class="block">FECHA INICIO</label>
    <input type="date" name="fechaInicio" required value="{{old('fechaInicio', $metaEstrategica->fechaInicio)}}">
</div>
<div>
    <label class="block">FECHA FIN</label>
    <input type="date" name="fechaFin" required value="{{old('fechaFin', $metaEstrategica->fechaFin)}}">
</div>
<div>
    <label class="block">FORMULA INDICADOR</label>
    <input type="string" name="formulaIndicador" required value="{{old('formulaIndicador', $metaEstrategica->formulaIndicador)}}">
</div>
<div>
    <label class="block">META ESPERADA</label>
    <input type="number" name="metaEsperada" required value="{{old('metaEsperada', $metaEstrategica->metaEsperada)}}">
</div>
<div>
    <label class="block">PROGRESO ACTUAL</label>
    <input type="number" name="progresoActual" required value="{{old('progresoActual', $metaEstrategica->progresoActual)}}">
</div>
<div>
    <label class="block">TIPO INDICADOR</label>
    <input type="number" name="tipoIndicador" required value="{{old('tipoIndicador', $metaEstrategica->tipoIndicador)}}">
</div>
<div>
    <label class="block">UNIDAD MEDIDA</label>
    <input type="string" name="unidadMedida" required value="{{old('unidadMedida', $metaEstrategica->unidadMedida)}}">
</div>


<button type="submit">ACTUALIZAR</button>

<a href="{{route('metaEstrategica.index')}}">CANCELAR</a>
</form>

@endsection