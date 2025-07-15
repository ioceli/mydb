@extends('layouts.master')
@section('title','Editar Meta Estrategica')
@section('content')
<h2 class="text-xl font-bold mb-4"> EDITAR META ESTRATEGICA   </h2>
@if ($errors->any())
    <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
        <ul>
            @foreach($errors->all() as $error )
                <li>- {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <form action="{{route ('metaEstrategica.update', $metaEstrategica->idMetaEstrategica )}}"method="POST" class="space-y-4">
@csrf
@method('PUT')
<div>
    <label class="block font-bold mb-2">NOMBRE</label>
    <input type="text" class="w-full border rounded p-2" name="nombre" required value="{{old('nombre', $metaEstrategica->nombre)}}">
</div>
<div>
    <label class="block font-bold mb-2">DESCRIPCION</label>
    <input type="text" class="w-full border rounded p-2" name="descripcion" required value="{{old('descripcion', $metaEstrategica->descripcion)}}">
</div>
<div>
    <label class="block font-bold mb-2">FECHA INICIO</label>
    <input type="date" class="w-full border rounded p-2" name="fechaInicio" required value="{{old('fechaInicio', $metaEstrategica->fechaInicio)}}">
</div>
<div>
    <label class="block font-bold mb-2">FECHA FIN</label>
    <input type="date" class="w-full border rounded p-2" name="fechaFin" required value="{{old('fechaFin', $metaEstrategica->fechaFin)}}">
</div>
<div>
    <label class="block font-bold mb-2">FORMULA INDICADOR</label>
    <input type="string" class="w-full border rounded p-2" name="formulaIndicador" required value="{{old('formulaIndicador', $metaEstrategica->formulaIndicador)}}">
</div>
<div>
    <label class="block font-bold mb-2">META ESPERADA</label>
    <input type="number" class="w-full border rounded p-2" name="metaEsperada" required value="{{old('metaEsperada', $metaEstrategica->metaEsperada)}}">
</div>
<div>
    <label class="block font-bold mb-2">PROGRESO ACTUAL</label>
    <input type="number" class="w-full border rounded p-2" name="progresoActual" required value="{{old('progresoActual', $metaEstrategica->progresoActual)}}">
</div>
<div>
    <label class="block font-bold mb-2">TIPO INDICADOR</label>
    <input type="number" class="w-full border rounded p-2" name="tipoIndicador" required value="{{old('tipoIndicador', $metaEstrategica->tipoIndicador)}}">
</div>
<div>
    <label class="block font-bold mb-2">UNIDAD MEDIDA</label>
    <input type="string" class="w-full border rounded p-2" name="unidadMedida" required value="{{old('unidadMedida', $metaEstrategica->unidadMedida)}}">
</div>
<div class="flex gap-4">
<button type="submit" class="bg-green-500 text-white rounded px-4 py-2">ACTUALIZAR</button>
<a href="{{route('metaEstrategica.index')}}" class="bg-gray-500 text-white rounded px-4 py-2">CANCELAR</a>
</div>
</form>
</div>
@endsection