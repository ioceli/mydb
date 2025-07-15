@extends('layouts.master')
@section('title','Editar Meta Plan Nacional')
@section('content')
<h2 class="text-xl font-bold mb-4"> EDITAR META PLAN NACIONAL   </h2>
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
<form action="{{route ('metaPlanNacional.update', $metaPlanNacional->idMetaPlanNacional )}}"method="POST" class="space-y-4">
@csrf
@method('PUT')
<div>
    <label class="block font-bold mb-2">NOMBRE</label>
    <input class="w-full max-w-xl mb-2 border rounded p-2" type="text" name="nombre" required value="{{old('nombre', $metaPlanNacional->nombre)}}">
</div>
<div>
    <label class="block font-bold mb-2">DESCRIPCION</label>
    <input class="w-full max-w-xl mb-2 border rounded p-2" type="text" name="descripcion" required value="{{old('descripcion', $metaPlanNacional->descripcion)}}">
</div>
@csrf
@method('PUT')
<div>
    <label class="block font-bold mb-2">NOMBRE</label>
    <input class="w-full max-w-xl mb-2 border rounded p-2" type="text" name="nombre" required value="{{old('nombre', $metaPlanNacional->nombre)}}">
</div>
<div>
    <label class="block font-bold mb-2">DESCRIPCION</label>
    <input class="w-full max-w-xl mb-2 border rounded p-2" type="text" name="descripcion" required value="{{old('descripcion', $metaPlanNacional->descripcion)}}">
</div>
<div>
    <label class="block font-bold mb-2">PORCENTAJE ALINEACION</label>
    <input class="w-full max-w-xl mb-2 border rounded p-2" type="number" name="porcentajeAlineacion" required value="{{old('porcentajeAlineacion', $metaPlanNacional->porcentajeAlineacion)}}">
</div>
<button type="submit" class="bg-green-500 text-white rounded px-4 py-2">ACTUALIZAR</button>
<a href="{{route('metaPlanNacional.index')}}" class="bg-gray-500 text-white rounded px-4 py-2">CANCELAR</a>
</form>
@endsection