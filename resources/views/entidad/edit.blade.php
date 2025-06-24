@extends('layouts.app')

@section('title','Inicio')

@section('content')
<h2 class="text-2x1 font-bold mb-4"> EDITAR ENTIDADES   </h2>
<form action="{{route ('entidad.update', $entidad->idEntidad )}}"method="POST" class="space-y-4">
@csrf
@method('PUT')

<div>
    <label class="block">Codigo</label>
    <input type="number" name="codigo" require value="{{old('codigo', $entidad->codigo)}}">
</div>
<div>
    <label class="block">Subsector</label>
    <input type="text" name="subSector" require value="{{old('subSector', $entidad->subSector)}}">
</div>
<div>
    <label class="block">Nivel de Gobierno</label>
    <input type="text" name="nivelGobierno" require value="{{old('nivelGobierno', $entidad->nivelGobierno)}}">
</div>
<div>
    <label class="block">Estado</label>
    <input type="text" name="estado" require value="{{old('estado', $entidad->estado)}}">
</div>
<div>
    <label class="block">Fecha de Creacion</label>
    <input type="date" name="fechaCreacion" require value="{{old('fechaCreacion', $entidad->fechaCreacion)}}">
</div>
<div>
    <label class="block">Fecha de Actualizacion</label>
    <input type="date" name="fechaActualizacion" require value="{{old('fechaActualizacion', $entidad->fechaActualizacion)}}">
</div>

<button type="submit">GUARDAR</button>

<a href="{{route('entidad.index')}}">VOLVER</a>
</form>

@endsection