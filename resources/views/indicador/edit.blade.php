@extends('layouts.app')

@section('title','Editar Indicador')

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

<h2 class="text-2x1 font-bold mb-4"> EDITAR INDICADOR   </h2>

<form action="{{route ('indicador.update', $indicador->idIndicador )}}"method="POST" class="space-y-4">
@csrf
@method('PUT')
<div>
    <label class="block">NOMBRE</label>
    <input type="text" name="nombre" required value="{{old('nombre', $indicador->nombre)}}">
</div>
<div>
    <label class="block">DESCRIPCION</label>
    <input type="text" name="descripcion" required value="{{old('descripcion', $indicador->descripcion)}}">
</div>
<div>
    <label class="block">FECHA MEDICION</label>
    <input type="date" name="fechaMedicion" required value="{{old('fechaMedicion', $indicador->fechaMedicion)}}">
</div>
<div>
    <label class="block">FORMULA </label>
    <input type="text" name="formula" required value="{{old('formula', $indicador->formula)}}">
</div>
<div>
    <label class="block">TIPO</label>
    <input type="text" name="tipo" required value="{{old('tipo', $indicador->tipo)}}">
</div>
<div>
    <label class="block">UNIDAD MEDIDA</label>
    <input type="text" name="unidadMedida" required value="{{old('unidadMedida', $indicador->unidadMedida)}}">
</div>
<div>
    <label class="block">VALOR ACTUAL</label>
    <input type="number" name="valorActual" required value="{{old('valorActual', $indicador->valorActual)}}">
</div>
<div>
    <label class="block">VALOR BASE</label>
    <input type="number" name="valorBase" required value="{{old('valorBase', $indicador->valorBase)}}">
</div>
<div>
    <label class="block">VALOR META</label>
    <input type="number" name="valorMeta" required value="{{old('valorMeta', $indicador->valorMeta)}}">
</div>


<button type="submit">ACTUALIZAR</button>

<a href="{{route('indicador.index')}}">CANCELAR</a>
</form>

@endsection