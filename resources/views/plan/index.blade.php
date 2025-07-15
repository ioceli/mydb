@extends('layouts.master')
@section('title','Inicio')
@section('content')
<h2 class="text-2x1 font-bold mb-4"> Listado de plan   </h2>
{{--VALIDACION--}}
    @if (session ('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{session('success')}}
        </div>
    @endif
    {{--BOTON PARA LLAMAR AL FORMULARIO CREAR PLAN--}}
<a href="{{route('plan.create')}}"  class="font-bold mb-4 inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Nuevo Plan</a>
    {{--TABLA PARA LISTAR TODOS LOS PLANES--}}
<div class="overflow-x-auto bg-white rounded shadow">
    <table class="min-w-full table-auto border-collapse">
        <thead class="bg-gray-200 text-gray-700 text-left">
            <tr>
                <th class="p-2">ID</th>
                <th class="p-2">ENTIDAD</th>
                <th class="p-2">NOMBRE DEL PLAN</th>
                <th class="p-2">OBJETIVO ESTRATEGICO</th>
                <th class="p-2">ESTADO</th>
                <th class="p-2">ACCIONES</th>
            </tr>
        </thead>
        <tbody> 
               @forelse ($plan as $index => $p)
        <tr>
            <td class="border p-2 text-center">{{ $loop->iteration }}</td>
            <td class="border p-2">{{ $p->entidad->subSector ?? 'Sin entidad' }}</td>
            <td class="border p-2">{{ $p->nombre }}</td>
            <td class="border p-2">
                @if ($p->objetivosEstrategicos->count())
                    <ul class="list-disc list-inside">
                        @foreach ($p->objetivosEstrategicos as $objetivo)
                            <li>{{ $objetivo->descripcion }}</li>
                        @endforeach
                    </ul>
                @else
                    <span class="text-gray-500">Sin objetivos</span>
                @endif
            </td>
            <td class="border p-2">{{ $p->estado }}</td>
                    <td class="border p-2">
                        {{-- Enlace para Editar --}}
                        <a href="{{ route('plan.edit', $p->idPlan) }}" class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600">Editar</a>
                        <form action="{{ route('plan.destroy', $p->idPlan) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Deseas eliminar este plan?')">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-600 text-white px-2 py-1 rounded hover:bg-red-700">Eliminar</button>
                        </form>
                       </td>
        </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center p-4 text-gray-500">No hay planes registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">
<a href="{{ route('dashboard.externo') }}" class="font-bold bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">REGRESAR</a> 
</div>
@endsection