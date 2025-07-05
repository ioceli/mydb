@extends('layouts.app')

@section('title','Editar Objetivo Estrategico')

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

<h2 class="text-2x1 font-bold mb-4"> EDITAR OBJETIVO ESTRATEGICO   </h2>

<form action="{{route ('objetivoEstrategico.update', $objetivoEstrategico->idObjetivoEstrategico )}}"method="POST" class="space-y-4">
@csrf
@method('PUT')
<div>
    <label class="block">DESCRIPCION</label>
    <input type="text" name="descripcion" required value="{{old('descripcion', $objetivoEstrategico->descripcion)}}">
</div>
<div>
    <label class="block">FECHA REGISTRO</label>AA
    <input type="date" name="fechaRegistro" required value="{{old('fechaRegistro', $objetivoEstrategico->fechaRegistro)}}">>
</div>
<div>
    <label class="block font-semibold">ESTADO</label>
    <select name="estado" required>
        <option value="">Seleccione un estado</option>
        @foreach (EstadoEnum::cases() as $estado)
            <option value="{{ $estado->value }}" {{ old('estado',  $objetivoEstrategico->estado ??'') === $estado->value? 'selected' : '' }}>
                {{ $estado->value }}
            </option>
        @endforeach
    </select>
</div>

<button type="submit">ACTUALIZAR</button>

<a href="{{route('objetivoEstrategico.index')}}">CANCELAR</a>
</form>

@endsection