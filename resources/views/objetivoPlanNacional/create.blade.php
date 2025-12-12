@extends('layouts.master')

@section('title','Nuevo Objetivo Plan Nacional')

@section('content')

@php
    use App\Enums\EjePndEnum;
@endphp 

<div class="bg-gray-50 min-h-screen">
    <div class="flex">
        {{-- Menú Lateral --}}
        <x-tecnico-sidebar />
        {{-- Contenido Principal --}}
        <div class="flex-1 p-6">
<h2 class="text-xl font-bold mb-4">Registrar nuevo Objetivo del Plan Nacional</h2>
    {{-- VALIDACION --}}
    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
        {{--FORMULARIO PARA LA CREACION DE OBJETIVO PLAN NACIONAL--}}
            <form action="{{ route ('objetivoPlanNacional.store')}} "method="POST" class="space-y-4">
                @csrf
                <div class="mb-4">
                    <label class="w-full max-w-xl mb-2 font-bold">CODIGO</label>
                    <input class="w-full max-w-xl mb-2 border rounded p-2" type="number" name="codigo" required>
                </div>
                <div>
                    <label class="w-full max-w-xl mb-2 font-bold">NOMBRE</label>
                    <input class="w-full max-w-xl mb-2 border rounded p-2" type="text" name="nombre" required>
                </div>
                <div>
                    <label class="w-full max-w-xl mb-2 font-bold">DESCRIPCION</label>
                    <input class="w-full max-w-xl mb-2 border rounded p-2" type="text" name="descripcion" required>
                </div>
                <div>
                    <label class="w-full max-w-xl mb-2 font-bold">EJE PLAN NACIONAL</label>
                        <select name="ejePnd" class="w-full max-w-xl mb-2 border rounded p-2" required>
                            <option value="">Seleccione un eje del plan nacional</option>
                                @foreach (EjePndEnum::cases() as $ejePnd)
                                    <option value="{{ $ejePnd->value }}" {{ old('ejePnd') === $ejePnd->value ? 'selected' : '' }}>
                                        {{ $ejePnd->value }}
                                    </option>
                                @endforeach
                        </select>
                </div>
                    <button type="submit" class="btn btn-success font-bold">GUARDAR</button>
                        <a href="{{route('objetivoPlanNacional.index')}}" class="btn btn-secondary text-white font-bold">VOLVER</a>
            </form>
</div>
    </div>
</div>

@endsection