@extends('layouts.master')
@section('title','Nueva Meta Plan Nacional')
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
<h2 class="text-xl font-bold mb-4">Registrar nueva Meta Plan Nacional</h2>
<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
{{--FORMULAIO PARA LA CREACION DE META PLAN NACIONAL--}}
<form action="{{ route ('metaPlanNacional.store')}} "method="POST" class="space-y-4">
    @csrf
<div>
    <label class="w-full max-w-xl mb-2 font-bold">NOMBRE</label>
    <input class="w-full max-w-xl mb-2 border rounded p-2" type="text" name="nombre" required>
</div>
    <div>
    <label class="w-full max-w-xl mb-2 font-bold">DESCRIPCION</label>
    <input class="w-full max-w-xl mb-2 border rounded p-2" type="text" name="descripcion" required>
</div>
<div>
    <label class="w-full max-w-xl mb-2 font-bold">PORCENTAJE ALINEACION</label>
    <input class="w-full max-w-xl mb-2 border rounded p-2" type="number" name="porcentajeAlineacion" required>
</div>
<button type="submit" class="bg-green-500 text-white rounded px-4 py-2">GUARDAR</button>
<a href="{{route('metaPlanNacional.index')}}" class="bg-gray-500 text-white rounded px-4 py-2">VOLVER</a>
</form>
@endsection