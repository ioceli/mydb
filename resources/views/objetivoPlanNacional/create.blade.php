@extends('layouts.app')

@section('title','Nuevo Objetivo Plan Nacional')

@section('content')

@php
    use App\Enums\EjePndEnum;
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

{{--FORMULAIO PARA LA CREACION DE OBJETIVO PLAN NACIONAL--}}
<form action="{{ route ('objetivoPlanNacional.store')}} "method="POST" class="space-y-4">
    @csrf
<div>
    <label class="block">CODIGO</label>
    <input type="number" name="codigo" required>
</div>
    <div>
    <label class="block">NOMBRE</label>
    <input type="text" name="nombre" required>
</div>
    <div>
    <label class="block">DESCRIPCION</label>
    <input type="text" name="descripcion" required>
</div>
<div>
    <label class="block">EJE PLAN NACIONAL</label>
     <select name="ejePnd" required>
 <option value="">Seleccione un eje del plan nacional</option>
        @foreach (EjePndEnum::cases() as $ejePnd)
            <option value="{{ $ejePnd->value }}" {{ old('ejePnd') === $ejePnd->value ? 'selected' : '' }}>
                {{ $ejePnd->value }}
            </option>
        @endforeach
    </select>
</div>
<button type="submit">GUARDAR</button>
<a href="{{route('objetivoPlanNacional.index')}}">VOLVER</a>
</form>

@endsection