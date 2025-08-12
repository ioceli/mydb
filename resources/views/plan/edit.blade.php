@extends('layouts.master')
@section('title','Editar Plan')
@section('content')
<h2 class="text-2x1 font-bold mb-4"> EDITAR PLAN   </h2>
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
        <form action="{{route ('plan.update', $plan->idPlan )}}"method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block mb-1 font-bold">ENTIDAD</label>
                    <select name="idEntidad" class="w-full border rounded p-2" required>
                        @foreach ($entidad as $entidad)
                            <option value="{{$entidad->idEntidad}}" {{ old('idEntidad', $plan->idEntidad) == $entidad->idEntidad ? 'selected' : '' }}>{{$entidad->subSector}}</option>
                        @endforeach
                    </select>
            </div>
            <div>
                <label class="block mb-1 font-bold">NOMBRE DEL PLAN</label>
                <input type="text" name="nombre" class="w-full border rounded p-2" required value="{{old('nombre', $plan->nombre)}}">
            </div>
            {{-- OBJETIVOS ESTRATEGICOS --}}
        <div class="mb-4">
            <label class="block font-bold mb-2">Alineación con Objetivos Estratégicos</label>
            <div class="grid gap-2">
                @foreach ($objetivoEstrategico as $objetivo)
                    <label class="inline-flex items-center">
                        <input
                            type="checkbox"
                            name="idObjetivoEstrategico[]"
                            value="{{ $objetivo->idObjetivoEstrategico }}"
                            {{ $plan->objetivosEstrategicos->contains('idObjetivoEstrategico', $objetivo->idObjetivoEstrategico) ? 'checked' : '' }}
                            class="mr-2"
                        >
                        {{ $objetivo->descripcion }}
                    </label>
                @endforeach
            </div>
        </div>
            {{-- METAS ESTRATEGICAS --}}
            <div class="mb-4">
                <label class="block font-bold mb-2">Alineación con Metas Estratégicas</label>
                <div class="grid gap-2">
                    @foreach ($metasEstrategicas as $meta)
                        <label class="inline-flex items-center">
                            <input
                                type="checkbox"
                                name="idMetaEstrategica[]"
                                value="{{ $meta->idMetaEstrategica }}"
                                {{ $plan->metasEstrategicas->contains('idMetaEstrategica', $meta->idMetaEstrategica) ? 'checked' : '' }}
                                class="mr-2"
                            >
                            {{ $meta->descripcion }}
                        </label>
                    @endforeach
                </div>
            </div>
            <div class="flex gap-4">
                <button type="submit " class="font-bold bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">ACTUALIZAR</button>
                    <a href="{{route('plan.index')}}" class="font-bold bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-700">CANCELAR</a>
            </div>
        </form>
    </div>
@endsection