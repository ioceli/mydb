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

{{--FORMULAIO PARA LA CREACION DE META PLAN NACIONAL--}}
<form action="{{ route ('metaPlanNacional.store')}} "method="POST" class="space-y-4">
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
    <label class="block">PORCENTAJE ALINEACION</label>
    <input type="number" name="porcentajeAlineacion" required>
</div>

<button type="submit">GUARDAR</button>
<a href="{{route('metaPlanNacional.index')}}">VOLVER</a>
</form>

@endsection