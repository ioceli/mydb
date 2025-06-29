@extends('layouts.app')

@section('title','Editar Plan')

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

<h2 class="text-2x1 font-bold mb-4"> EDITAR PLANES   </h2>

<form action="{{route ('plan.update', $plan->idPlan )}}"method="POST" class="space-y-4">
@csrf
@method('PUT')

<div>
    <label class="block">nombre</label>
    <input type="text" name="nombre" required value="{{old('nombre', $plan->nombre)}}">
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

<a href="{{route('plan.index')}}">CANCELAR</a>
</form>

@endsection