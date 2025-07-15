@extends('layouts.master')
@section('title','Inicio')
@section('content')
<h2 class="text-2x1 font-bold mb-4"> Listado de Meta Estrategica   </h2>
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
<a href="{{route('metaEstrategica.create')}}" class="font-bold mb-4 inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700"> Nueva Meta Estrategica</a>
        {{--TABLA PARA LISTAR TODOS LOS META ESTRATEGICA--}}
<div class="overflow-x-auto bg-white rounded shadow">
    <table class="min-w-full table-auto border-collapse">
        <thead class="bg-gray-200 text-gray-700 text-left">
            <tr>
                <th class="border border-gray-300 px-4 py-2">ID</th>
                <th class="border border-gray-300 px-4 py-2">NOMBRE</th>
                <th class="border border-gray-300 px-4 py-2">DESCRIPCION</th>
                <th class="border border-gray-300 px-4 py-2">FECHA INICIO</th>
                <th class="border border-gray-300 px-4 py-2">FECHA FIN</th>
                <th class="border border-gray-300 px-4 py-2">FORMULA INDICADOR</th>
                <th class="border border-gray-300 px-4 py-2">META ESPERADA</th>
                <th class="border border-gray-300 px-4 py-2">PROGRESO ACTUAL </th>
                <th class="border border-gray-300 px-4 py-2">TIPO INDICADOR </th>
                <th class="border border-gray-300 px-4 py-2">UNIDAD MEDIDA</th>
                <th class="border border-gray-300 px-4 py-2">ACCIONES</th>
            </tr>
        </thead>
        <tbody> 
            @forelse($metaEstrategica as $metaEstrategica)
                <tr>
                    <td class="border border-gray-300 px-4 py-2">{{$metaEstrategica->idMetaEstrategica}}</td>
                    <td class="border border-gray-300 px-4 py-2">{{$metaEstrategica->nombre}}</td>
                    <td class="border border-gray-300 px-4 py-2">{{$metaEstrategica->descripcion}}</td>
                    <td class="border border-gray-300 px-4 py-2">{{$metaEstrategica->fechaInicio}}</td>
                    <td class="border border-gray-300 px-4 py-2">{{$metaEstrategica->fechaFin}}</td>
                    <td class="border border-gray-300 px-4 py-2">{{$metaEstrategica->formulaIndicador}}</td>
                    <td class="border border-gray-300 px-4 py-2">{{$metaEstrategica->metaEsperada}}</td>
                    <td class="border border-gray-300 px-4 py-2">{{$metaEstrategica->progresoActual}}</td>
                    <td class="border border-gray-300 px-4 py-2">{{$metaEstrategica->tipoIndicador}}</td>
                    <td class="border border-gray-300 px-4 py-2">{{$metaEstrategica->unidadMedida}}</td>
                    <td class="p-2 flex gap-2">
                    {{-- Enlace para Editar --}}   
                    <a href="{{ route('metaEstrategica.edit', $metaEstrategica->idMetaEstrategica) }}" class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600">Editar</a>
                        {{-- Enlace para Eliminar --}}
                        <form method="POST" action="{{ route('metaEstrategica.destroy', $metaEstrategica->idMetaEstrategica) }}" onsubmit="return confirm('¿Está seguro de eliminar esta Meta Estratégico?')">
                            @csrf
                            @method('DELETE')
                             <button class="bg-red-600 text-white px-2 py-1 rounded hover:bg-red-700">Eliminar</button>
                        </form>
                    </td>
                </tr>
                    @empty
                    <tr>
                    <td colspan="7" class="text-center py-4 text-gray-600">No hay metas estratégicas registradas.</td>    
            </tr>
        @endforelse
    </tbody>
</table>
    </div>
    <div class="mt-4">
        <a href="{{ route('dashboard.tecnico') }}" class="font-bold bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">REGRESAR</a>
    </div>
@endsection