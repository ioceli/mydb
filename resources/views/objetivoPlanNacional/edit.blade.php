@extends('layouts.master')

@section('title','Editar Objetivo Plan Nacional')

@php
    use App\Enums\EjePndEnum;
@endphp
@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="flex">
        {{-- Menú Lateral --}}
        <x-dynamic-sidebar />
        {{-- Contenido Principal --}}
        <div class="flex-1 p-6">
<h2 class="text-2x1 font-bold mb-4"> EDITAR OBJETIVO PLAN NACIONAL   </h2>
            {{-- VALIDACION --}}
            @if (session('success'))
                <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <form action="{{route ('objetivoPlanNacional.update', $objetivoPlanNacional->idObjetivoPlanNacional )}}"method="POST" class="space-y-4">
        @csrf
        @method('PUT')
            <div class="mb-4">
                <label class="block mb-1 font-bold">CODIGO</label>
                <input type="number" name="codigo" class="w-full border rounded p-2" required value="{{old('codigo', $objetivoPlanNacional->codigo)}}">
            </div>
            <div>
                <label class="block mb-1 font-bold">NOMBRE</label>
                <input type="text" name="nombre" class="w-full border rounded p-2" required value="{{old('nombre', $objetivoPlanNacional->nombre)}}">
            </div>
            <div>
                <label class="block mb-1 font-bold">DESCRIPCION</label>
                <input type="text" name="descripcion" class="w-full border rounded p-2" required value="{{old('descripcion', $objetivoPlanNacional->descripcion)}}">
            </div>
            <div>
                <label class="block mb-1 font-bold">EJE PLAN NACIONAL</label>
                <select name="ejePnd" class="w-full border rounded p-2" required>
                    <option value="">Seleccione un eje del plan nacional</option>
                        @foreach (EjePndEnum::cases() as $ejePnd)
                            <option value="{{ $ejePnd->value }}" {{ old('ejePnd',  $objetivoPlanNacional->ejePnd ??'') === $ejePnd->value? 'selected' : '' }}>
                                {{ $ejePnd->value }}
                            </option>
                        @endforeach
                </select>
            </div>
            <div class="flex gap-4">
                <button type="submit" class="font-bold bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">ACTUALIZAR</button>

                    <a href="{{route('objetivoPlanNacional.index')}}" class="font-boldbg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-700">CANCELAR</a>
            </div>
    </form>
</div>
    </div>
</div>

@endsection