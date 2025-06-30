@extends('layouts.app')

@section('title','Editar Objetivo Plan Nacional')

@php
    use App\Enums\EjePndEnum;
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

<h2 class="text-2x1 font-bold mb-4"> EDITAR OBJETIVO PLAN NACIONAL   </h2>

<form action="{{route ('objetivoPlanNacional.update', $objetivoPlanNacional->idObjetivoPlanNacional )}}"method="POST" class="space-y-4">
@csrf
@method('PUT')
<div>
    <label class="block">CODIGO</label>
    <input type="number" name="codigo" required value="{{old('codigo', $objetivoPlanNacional->codigo)}}">
</div>
<div>
    <label class="block">NOMBRE</label>
    <input type="text" name="nombre" required value="{{old('nombre', $objetivoPlanNacional->nombre)}}">
</div>
<div>
    <label class="block">DESCRIPCION</label>
    <input type="text" name="descripcion" required value="{{old('descripcion', $objetivoPlanNacional->descripcion)}}">
</div>
<div>
    <label class="block font-semibold">EJE PLAN NACIONAL</label>
    <select name="ejePnd" required>
        <option value="">Seleccione un eje del plan nacional</option>
        @foreach (EjePndEnum::cases() as $ejePnd)
            <option value="{{ $ejePnd->value }}" {{ old('ejePnd',  $objetivoPlanNacional->ejePnd ??'') === $ejePnd->value? 'selected' : '' }}>
                {{ $ejePnd->value }}
            </option>
        @endforeach
    </select>
</div>

<button type="submit">ACTUALIZAR</button>

<a href="{{route('objetivoPlanNacional.index')}}">CANCELAR</a>
</form>

@endsection