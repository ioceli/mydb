@extends('layouts.master')

@section('title','Editar Proyecto')

@php
    use App\Enums\EstadoEnum;
@endphp

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

<h2 class="text-2x1 font-bold mb-4"> EDITAR PROYECTOS</h2>

<form action="{{route ('proyecto.update', $proyecto->idProyecto )}}"method="POST" class="space-y-4">
@csrf
@method('PUT')
<div>
    <label class="block">ENTIDAD</label>
    <select name="idEntidad" required>
        @foreach ($entidad as $entidad)
        <option value="{{$entidad->idEntidad}}">{{$entidad->subSector}}
        </option>
        @endforeach
    </select>
 </div>
<div>
    <label class="block">nombre</label>
    <input type="text" name="nombre" required value="{{old('nombre', $proyecto->nombre)}}">
<div>
    <label class="block font-semibold">ESTADO</label>
    <select name="estado" required>
        <option value="">Seleccione un estado</option>
        @foreach (EstadoEnum::cases() as $estado)
            <option value="{{ $estado->value }}" {{ old('estado',  $persona->estado ??'') === $estado->value? 'selected' : '' }}>
                {{ $estado->value }}
            </option>
        @endforeach
    </select>
</div>

<button type="submit">ACTUALIZAR</button>

<a href="{{route('proyecto.index')}}">CANCELAR</a>
</form>

@endsection