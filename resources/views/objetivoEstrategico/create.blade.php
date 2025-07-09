@extends('layouts.master')

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
<h2 class="text-xl font-bold mb-4">Registrar nuevo Objetivo Estrategico</h2>
    <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
{{--FORMULARIO PARA LA CREACION DE OBJETIVO ESTRATEGICO--}}
<form action="{{ route ('objetivoEstrategico.store')}} "method="POST" class="space-y-4">
    @csrf

        <div>
            <label class="w-full max-w-xl mb-2 font-bold">DESCRIPCION</label>
            <input class="w-full max-w-xl mb-2 border rounded p-2" type="text" name="descripcion" required>
        </div>
        <div>
            <label class="w-full max-w-xl mb-2 font-bold">FECHA REGISTRO</label>
            <input class="w-full max-w-xl mb-2 border rounded p-2" type="date" name="fechaRegistro" required>
        </div>
        <div>
            <label class="w-full max-w-xl mb-2 font-bold">ESTADO</label>
                <select class="w-full max-w-xl mb-2 border rounded p-2" name="estado" required>
                    <option value="">Seleccione un estado</option>
                        @foreach (EstadoEnum::cases() as $estado)
                            <option value="{{ $estado->value }}" {{ old('estado') === $estado->value ? 'selected' : '' }}>
                                {{ $estado->value }}
                            </option>
                        @endforeach
                </select>
        </div>
            <button type="submit" class="btn btn-success font-bold">GUARDAR</button>
            <a href="{{route('objetivoEstrategico.index')}}"class="btn btn-secondary text-white font-bold">VOLVER</a>
</form>

@endsection