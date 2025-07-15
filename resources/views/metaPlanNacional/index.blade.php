@extends('layouts.master')
@section('title','Inicio')
@section('content')
<h2 class="text-2xl font-bold mb-4"> Listado de Meta Plan Nacional   </h2>
{{--VALIDACION--}}
    @if (session ('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    @if(isset($message))
        <div class="bg-yellow-100 text-yellow-700 p-4 rounded mb-4">
            {{ $message }}
        </div>
    @endif
    {{--BOTON PARA LLAMAR AL FORMULARIO CREAR META PLAN NACIONAL--}}
<a href="{{route('metaPlanNacional.create')}}" class="bg-green-500 text-white rounded px-4 py-2">Nueva Meta Plan Nacional</a>
    {{--TABLA PARA LISTAR TODOS LOS META PLAN NACIONAL--}}
<div class="overflow-x-auto bg-white rounded shadow mt-4">
    <table class="min-w-full table-auto border-collapse">
        <thead class="bg-gray-200 text-gray-700 text-left">
            <tr>
                <th class="border border-gray-300 px-4 py-2">ID</th>
                <th class="border border-gray-300 px-4 py-2">NOMBRE</th>
                <th class="border border-gray-300 px-4 py-2">DESCRIPCION</th>
                <th class="border border-gray-300 px-4 py-2">PORCENTAJE ALINEACION</th>
                <th class="border border-gray-300 px-4 py-2">ACCIONES</th>
            </tr>
        </thead>
        <tbody> 
            @forelse($metaPlanNacional as $metaPlanNacional)
                <tr>
                    <td class="border border-gray-300 px-4 py-2">{{$metaPlanNacional->idMetaPlanNacional}}</td>
                    <td class="border border-gray-300 px-4 py-2">{{$metaPlanNacional->nombre}}</td>
                    <td class="border border-gray-300 px-4 py-2">{{$metaPlanNacional->descripcion}}</td>
                    <td class="border border-gray-300 px-4 py-2">{{$metaPlanNacional->porcentajeAlineacion}}</td>
                    <td class="p-2 flex gap-2">
                        {{-- Enlace para Editar --}}
                        <a href="{{ route('metaPlanNacional.edit', $metaPlanNacional->idMetaPlanNacional) }}" class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600">Editar</a>
                        {{-- Enlace para Eliminar --}}
                        <form method="POST" action="{{ route('metaPlanNacional.destroy', $metaPlanNacional->idMetaPlanNacional) }}" onsubmit="return confirm('¿Está seguro de eliminar esta Meta del Plan Nacional?')">
                          @csrf
                          @method('DELETE')
                            <button class="bg-red-600 text-white px-2 py-1 rounded hover:bg-red-700">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-gray-600">No hay metas del plan nacional registradas.</td>
                    </tr>
            @endforelse
</tbody>
</table>
</div>
<div class="mt-4">
    <a href="{{ route('dashboard.tecnico') }}" class="font-bold bg-gray-500 text-white rounded px-4 py-2">REGRESAR</a>
</div>
@endsection