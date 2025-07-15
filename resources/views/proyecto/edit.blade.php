@extends('layouts.master')
@section('title','Editar Proyecto')
@php
    use App\Enums\EstadoEnum;
@endphp
@section('content')
<h2 class="text-2x1 font-bold mb-4"> EDITAR PROYECTO</h2>
@if ($errors->any())
    <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
        <ul>
            @foreach($errors->all() as $error )
                <li>- {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
        <form action="{{route ('proyecto.update', $proyecto->idProyecto )}}"method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block mb-1 font-bold">ENTIDAD</label>
                    <select name="idEntidad" class="w-full border rounded p-2"required>
                        @foreach ($entidad as $entidad)
                            <option value="{{$entidad->idEntidad}}">{{$entidad->subSector}}</option>
                        @endforeach
                    </select>
            </div>
            <div>
                <label class="block mb-1 font-bold">NOMBRE DEL PROYECTO</label>
                <input type="text" class="w-full border rounded p-2" name="nombre" required value="{{old('nombre', $proyecto->nombre)}}">
            </div>
            {{-- OBJETIVOS ESTRATEGICOS --}}
            <div class="mb-4">
                <label class="block font-bold mb-2">Objetivos Estratégicos</label>
                <div class="grid gap-2">
                    @foreach ($objetivoEstrategico as $objetivo)
                        <label class="inline-flex items-center">
                            <input
                                type="checkbox"
                                name="idObjetivoEstrategico[]"
                                value="{{ $objetivo->idObjetivoEstrategico }}"
                                {{ $proyecto->objetivosEstrategicos->contains('idObjetivoEstrategico', $objetivo->idObjetivoEstrategico) ? 'checked' : '' }}
                                class="mr-2"
                            >
                            {{ $objetivo->descripcion }}
                        </label>
                    @endforeach
                </div>
            </div>
            <div>
                <label class="block mb-1 font-bold">ESTADO</label>
                    <select name="estado" class="w-full border rounded p-2" required>
                        <option value="">Seleccione un estado</option>
                            @foreach (EstadoEnum::cases() as $estado)
                                <option value="{{ $estado->value }}" {{ old('estado',  $persona->estado ??'') === $estado->value? 'selected' : '' }}>
                                    {{ $estado->value }}
                                </option>
                            @endforeach
                    </select>
            </div>
            <div class="flex gap-4">
                <button type="submit" class="font-bold bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">ACTUALIZAR</button>
                <a href="{{route('proyecto.index')}}" class="font-bold bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-700">CANCELAR</a>
            </div>
        </form>
    </div>
@endsection