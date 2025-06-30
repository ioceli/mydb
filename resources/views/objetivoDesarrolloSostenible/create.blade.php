@extends('layouts.app')

@section('title','Nuevo Objetivo Desarrollo Sostenible')

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

{{--FORMULARIO PARA LA CREACION DE OBJETIVO DESARROLLO SOSTENIBLE--}}
<form action="{{ route ('objetivoDesarrolloSostenible.store')}} "method="POST" class="space-y-4">
    @csrf
<div>
    <label class="block">NUMERO</label>
    <input type="number" name="numero" required>
</div>
<div>
    <label class="block">NOMBRE</label>
    <input type="text" name="nombre" required>
</div>
<div>
    <label class="block">DESCRIPCION</label>
    <input type="text" name="descripcion" required>
</div>

<button type="submit">GUARDAR</button>
<a href="{{route('objetivoDesarrolloSostenible.index')}}">VOLVER</a>
</form>

@endsection