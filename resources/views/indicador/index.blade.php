@extends('layouts.master')
@section('title','Inicio')
@section('content')
<h2 class="text-2xl font-bold mb-4"> Listado de Indicador   </h2>
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
    {{--BOTON PARA LLAMAR AL FORMULARIO CREAR INDICADOR--}}
<a href="{{route('indicador.create')}}" class="font-bold mb-4 inline-block bg-green-500 text-white rounded hover:bg-green-700 py-2 px-4">Nuevo Indicador</a>
    {{--TABLA PARA LISTAR TODOS LOS INDICADOR--}}
<div class="overflow-x-auto bg-white rounded shadow">
    <table class="min-w-full table-auto border-collapse">
        <thead class="bg-gray-200 text-gray-700 text-left">
            <tr>
                <th class="border border-gray-300 px-4 py-2">ID</th>
                <th class="border border-gray-300 px-4 py-2">NOMBRE</th>
                <th class="border border-gray-300 px-4 py-2">DESCRIPCION</th>
                <th class="border border-gray-300 px-4 py-2">FECHA MEDICION</th>
                <th class="border border-gray-300 px-4 py-2">FORMULA</th>
                <th class="border border-gray-300 px-4 py-2">TIPO</th>
                <th class="border border-gray-300 px-4 py-2">UNIDAD MEDIDA</th>
                <th class="border border-gray-300 px-4 py-2">VALOR ACTUAL </th>
                <th class="border border-gray-300 px-4 py-2">VALOR BASE </th>
                <th class="border border-gray-300 px-4 py-2">VALOR META</th>
                <th class="border border-gray-300 px-4 py-2">ACCIONES</th>
            </tr>
</thead>
<tbody> 
    @forelse($indicador as $indicador)
    <tr>
        <td class="border border-gray-300 px-4 py-2">{{$indicador->idIndicador}}</td>
<td class="border border-gray-300 px-4 py-2">{{$indicador->nombre}}</td>
<td class="border border-gray-300 px-4 py-2">{{$indicador->descripcion}}</td>
<td class="border border-gray-300 px-4 py-2">{{$indicador->fechaMedicion}}</td>
<td class="border border-gray-300 px-4 py-2">{{$indicador->formula}}</td>
<td class="border border-gray-300 px-4 py-2">{{$indicador->tipo}}</td>
<td class="border border-gray-300 px-4 py-2">{{$indicador->unidadMedida}}</td>
<td class="border border-gray-300 px-4 py-2">{{$indicador->valorActual}}</td>
<td class="border border-gray-300 px-4 py-2">{{$indicador->valorBase}}</td>
<td class="border border-gray-300 px-4 py-2">{{$indicador->valorMeta}}</td>
<td class="p-2 flex gap-2">
    {{-- Enlace para Editar --}}
    <a href="{{ route('indicador.edit', $indicador->idIndicador) }}" class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600"> Editar</a>
    {{-- Enlace para Eliminar --}}
   <form method="POST" action="{{ route('indicador.destroy', $indicador->idIndicador) }}" onsubmit="return confirm('¿Está seguro de eliminar este Indicador?')">
        @csrf
        @method('DELETE')
        <button class="bg-red-600 px-2 py-1 text-white rounded hover:bg-red-700">Eliminar</button>
    </form>
</td>
</tr>
@empty
<tr>
    <td colspan="11" class="border border-gray-300 px-4 py-2 text-center">No hay indicadores disponibles</td>
</tr>
@endforelse
</tbody>
</table>
</div>
<div class="mt-4">
    <a href="{{ route('dashboard.tecnico') }}" class="font-bold bg-gray-500 text-white rounded hover:bg-gray-600 py-2 px-4">REGRESAR</a>
</div>
@endsection