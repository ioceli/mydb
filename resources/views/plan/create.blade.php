@extends('layouts.master')

@section('title','Nuevo Plan')

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

{{--FORMULAIO PARA LA CREACION DE PLANES--}}
<form action="{{ route ('plan.store')}} "method="POST" class="space-y-4">
    @csrf
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
    <label class="block">NOMBRE</label>
    <input type="text" name="nombre" required>
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
<button type="submit" class="btn btn-success">
    GUARDAR
</button>
<a href="{{ route('plan.index') }}" class="btn btn-secondary text-white">
    VOLVER
</a>
</form>

@endsection