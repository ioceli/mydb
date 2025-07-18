@extends('layouts.master')
@section('title','Nuevo Programa')
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
<h2 class="text-xl font-bold mb-4">Registrar nuevo Programa </h2>
    <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
        {{--FORMULAIO PARA LA CREACION DE PROGRAMA--}}
            <form action="{{ route ('programa.store')}} "method="POST" class="space-y-4">
                 @csrf
                    <div class="mb-4">
                        <label class="w-full max-w-xl mb-2 font-bold">ENTIDAD</label>
                            <select name="idEntidad" class="w-full max-w-xl mb-2 border rounded p-2" required>
                                @foreach ($entidad as $entidad)
                                    <option value="{{$entidad->idEntidad}}">{{$entidad->subSector}}
                                    </option>
                                @endforeach
                            </select>
                    </div>
                    <div>
                        <label class="w-full max-w-xl mb-2 font-bold">NOMBRE DEL PROGRAMA</label>
                        <input class="w-full max-w-xl mb-2 border rounded p-2" type="text" name="nombre" required>
                    </div>
                    <div class="mb-4">
                     <label class="w-full max-w-xl mb-2 font-bold" for="idObjetivoEstrategico">OBJETIVOS ESTRATEGICOS</label>
    
                        <div class="grid grid-cols-1 gap-2">
                            @foreach($objetivoEstrategico as $objetivo)
                             <label class="inline-flex items-center space-x-2">
                                <input type="checkbox" 
                                    name="idObjetivoEstrategico[]" 
                                    value="{{ $objetivo->idObjetivoEstrategico }}"
                                    class="form-checkbox text-blue-600">
                                <span>{{ $objetivo->descripcion }}</span>
                             </label>
                            @endforeach
                        </div>
                    </div>
                    <div>
                        <label class="w-full max-w-xl mb-2 font-bold">ESTADO</label>
                        <select name="estado" class="w-full max-w-xl mb-2 border rounded p-2" required>
                            <option value="">Seleccione un estado</option>
                                @foreach (EstadoEnum::cases() as $estado)
                                    <option value="{{ $estado->value }}" {{ old('estado') === $estado->value ? 'selected' : '' }}>
                                        {{ $estado->value }}
                                    </option>
                                @endforeach
                        </select>
                    </div>
                        <button type="submit" class="font-bold btn btn-success">GUARDAR</button>
                            <a href="{{route('programa.index')}}"  class="font-bold btn btn-secondary text-white">VOLVER</a>
            </form>

@endsection