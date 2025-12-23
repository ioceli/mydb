@extends('layouts.master')

@section('title','Editar Indicador')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="flex">
        {{-- Menú Lateral --}}
        <<x-dynamic-sidebar />
        {{-- Contenido Principal --}}
        <div class="flex-1 p-6">
<h2 class="text-2x1 font-bold mb-4"> EDITAR INDICADOR   </h2>
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
<form action="{{route ('indicador.update', $indicador->idIndicador )}}"method="POST" class="space-y-4">
@csrf
@method('PUT')
<div>
    <label class="block font-bold mb-2">NOMBRE</label>
    <input type="text" class="w-full border rounded p-2" name="nombre" required value="{{old('nombre', $indicador->nombre)}}">
</div>
<div>
    <label class="block font-bold mb-2">DESCRIPCION</label>
    <input type="text" class="w-full border rounded p-2" name="descripcion" required value="{{old('descripcion', $indicador->descripcion)}}">
</div>
<div>
    <label class="block font-bold mb-2">FECHA MEDICION</label>
    <input type="date" class="w-full border rounded p-2" name="fechaMedicion" required value="{{old('fechaMedicion', $indicador->fechaMedicion)}}">
</div>
<div>
    <label class="block font-bold mb-2">FORMULA</label>
    <input type="text" class="w-full border rounded p-2" name="formula" required value="{{old('formula', $indicador->formula)}}">
</div>
<div>
    <label class="block font-bold mb-2">TIPO</label>
    <input type="text" class="w-full border rounded p-2" name="tipo" required value="{{old('tipo', $indicador->tipo)}}">
</div>
<div>
    <label class="block font-bold mb-2">UNIDAD MEDIDA</label>
    <input type="text" class="w-full border rounded p-2" name="unidadMedida" required value="{{old('unidadMedida', $indicador->unidadMedida)}}">
</div>
<div>
    <label class="block font-bold mb-2">VALOR ACTUAL</label>
    <input type="number" class="w-full border rounded p-2" name="valorActual" required value="{{old('valorActual', $indicador->valorActual)}}">
</div>
<div>
    <label class="block font-bold mb-2">VALOR BASE</label>
    <input type="number" class="w-full border rounded p-2" name="valorBase" required value="{{old('valorBase', $indicador->valorBase)}}">
</div>
<div>
    <label class="block font-bold mb-2">VALOR META</label>
    <input type="number" class="w-full border rounded p-2" name="valorMeta" required value="{{old('valorMeta', $indicador->valorMeta)}}">
</div>
<button type="submit" class="bg-green-500 text-white rounded px-4 py-2">ACTUALIZAR</button>
<a href="{{route('indicador.index')}}" class="bg-gray-500 text-white rounded px-4 py-2">CANCELAR</a>
</form>
    </div>
        </div>
    </div>
    </div>
@endsection