@extends('layouts.app')

@section('title','Nuevo Objetivo Estrategico')

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

{{--FORMULAIO PARA LA CREACION DE OBJETIVO ESTRATEGICO--}}
<form action="{{ route ('objetivoEstrategico.store')}} "method="POST" class="space-y-4">
    @csrf
<div>
    <label class="block">DESCRIPCION</label>
    <input type="text" name="descripcion" required>
</div>
<div>
    <label class="block">FECHA REGISTRO</label>
    <input type="date" name="fechaRegistro" required>
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
<button type="submit">GUARDAR</button>
<a href="{{route('objetivoEstrategico.index')}}">VOLVER</a>
</form>

@endsection