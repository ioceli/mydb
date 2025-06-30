@extends('layouts.app')

@section('title','Editar Objetivo Desarrollo Sostenible')

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

<h2 class="text-2x1 font-bold mb-4"> EDITAR OBJETIVO DESARROLLO SOSTENIBLE   </h2>

<form action="{{route ('objetivoDesarrolloSostenible.update', $objetivoDesarrolloSostenible->idObjetivoDesarrolloSostenible )}}"method="POST" class="space-y-4">
@csrf
@method('PUT')
<div>
    <label class="block">NUMERO</label>
    <input type="number" name="numero" required value="{{old('numero', $objetivoDesarrolloSostenible->numero)}}">
</div>
<div>
    <label class="block">NOMBRE</label>
    <input type="text" name="nombre" required value="{{old('nombre', $objetivoDesarrolloSostenible->nombre)}}">
</div>
<div>
    <label class="block">DESCRIPCION</label>
    <input type="text" name="descripcion" required value="{{old('descripcion', $objetivoDesarrolloSostenible->descripcion)}}">
</div>
<button type="submit">ACTUALIZAR</button>

<a href="{{route('objetivoDesarrolloSostenible.index')}}">CANCELAR</a>
</form>

@endsection