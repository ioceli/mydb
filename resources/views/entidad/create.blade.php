@extends('layouts.app')

@section('title','Nueva Entidad')

@section('content')

@php
    use App\Enums\EstadoEnum;
@endphp

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

{{--FORMULAIO PARA LA CREACION DE ENTIDADES--}}
<form action="{{ route ('entidad.store')}} "method="POST" class="space-y-4">
    @csrf
<div>
    <label class="block">Codigo</label>
    <input type="number" name="codigo" required>
</div>
<div>
    <label class="block">Sub-Sector</label>
    <input type="text" name="subSector" required>
</div>
<div>
    <label class="block">Nivel de Gobierno</label>
    <input type="text" name="nivelGobierno" required>
</div>
<div>
    <label class="block">ESTADO</label>
     <select name="estado" required>
 <option value="">Seleccione un estado</option>
        @foreach (EstadoEnum::cases() as $estado)
            <option value="{{ $estado->value }}" {{ old('estado') === $estado->value ? 'selected' : '' }}>
                {{ $estado->value }}
            </option>
        @endforeach
    </select>
</div>
<div>
    <label class="block">Fecha de Creacion</label>
    <input type="date" name="fechaCreacion" required>
</div>
<div>
    <label class="block">Fecha de Actualizacion</label>
    <input type="date" name="fechaActualizacion" required>
</div>
<button type="submit">GUARDAR</button>

<a href="{{route('entidad.index')}}">VOLVER</a>
</form>

@endsection