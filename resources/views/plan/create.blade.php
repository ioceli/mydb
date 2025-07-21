@extends('layouts.master')
@section('title','Nuevo Plan')
@section('content')
@php
    use App\Enums\EstadoRevisionEnum;
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
<h2 class="text-xl font-bold mb-4">Registrar nuevo Plan </h2>
    <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
        {{--FORMULARIO PARA LA CREACION DE PLANES--}}
            <form action="{{ route ('plan.store')}} "method="POST" class="space-y-4">
                @csrf
                <div class="mb-4">
                    <label class="w-full max-w-xl mb-2 font-bold">ENTIDAD</label>
                    <select name="idEntidad" class="w-full max-w-xl mb-2 border rounded p-2">
                        <option value="">Seleccione su entidad</option>
                        @foreach ($entidad as $entidad)
                            <option value="{{$entidad->idEntidad}}">{{$entidad->subSector}}

                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="w-full max-w-xl mb-2 font-bold">NOMBRE DEL PLAN</label>
                    <input class="w-full max-w-xl mb-2 border rounded p-2" type="text" name="nombre" required>
                </div>
                <div class="mb-4">
                   <label class="w-full max-w-xl mb-2 font-bold" for="idObjetivoEstrategico">Alineación con Objetivos Estratégicos</label>
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
                <div class="mb-4">
                    <label class="w-full max-w-xl mb-2 font-bold" for="idMetaEstrategica">Alineación con Metas Estratégicas</label>
                    <div class="grid grid-cols-1 gap-2">
                        @foreach($metasEstrategicas as $meta)
                            <label class="inline-flex items-center space-x-2">
                                <input type="checkbox"
                                       name="idMetaEstrategica[]"
                                       value="{{ $meta->idMetaEstrategica }}"
                                       class="form-checkbox text-blue-600">
                                <span>{{ $meta->descripcion }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            <button type="submit" class="font-bold btn btn-success">GUARDAR</button>
<a href="{{ route('plan.index') }}" class="font-bold btn btn-secondary text-white">VOLVER</a>
</form>

@endsection