@extends('layouts.master')

@section('title','Editar Meta Plan Nacional')

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

<h2 class="text-2x1 font-bold mb-4"> EDITAR META PLAN NACIONAL   </h2>

<form action="{{route ('metaPlanNacional.update', $metaPlanNacional->idMetaPlanNacional )}}"method="POST" class="space-y-4">
@csrf
@method('PUT')
<div>
    <label class="block">NOMBRE</label>
    <input type="text" name="nombre" required value="{{old('nombre', $metaPlanNacional->nombre)}}">
</div>
<div>
    <label class="block">DESCRIPCION</label>
    <input type="text" name="descripcion" required value="{{old('descripcion', $metaPlanNacional->descripcion)}}">
</div>
<div>
    <label class="block">PRCENTAJE ALINEACION</label>
    <input type="number" name="porcentajeAlineacion" required value="{{old('porcentajeAlineacion', $metaPlanNacional->porcentajeAlineacion)}}">
</div>


<button type="submit">ACTUALIZAR</button>

<a href="{{route('metaPlanNacional.index')}}">CANCELAR</a>
</form>

@endsection