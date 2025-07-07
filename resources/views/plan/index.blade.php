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

<a href="{{route('plan.create')}}"  class="mb-4 inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Nuevo Plan</a>
    {{--TABLA PARA LISTAR TODOS LOS PLANES--}}
<div class="overflow-x-auto bg-white rounded shadow">
    <table class="min-w-full table-auto border-collapse">
        <thead class="bg-gray-200 text-gray-700 text-left">
            <tr>
                <th class="p-2">ID</th>
                <th class="p-2">ENTIDAD</th>
                <th class="p-2">NOMBRE</th>
                <th class="p-2">ESTADO</th>
                <th class="p-2">ACCIONES</th>

            </tr>
        </thead>
        <tbody> 
            @foreach($plan as $plan)
                <tr class="border-b">
                    <td style="border: 1px solid #ccc; padding: 8px">{{$plan->idPlan}}</td>
                    <td style="border: 1px solid #ccc; padding: 8px">{{$plan->entidad->subSector}}</td>
                    <td style="border: 1px solid #ccc; padding: 8px">{{$plan->nombre}}</td>
                    <td style="border: 1px solid #ccc; padding: 8px">{{$plan->estado}}</td>
                    <td class="p-2 flex gap-2">

                         {{-- Enlace para Editar --}}
                        <a href="{{ route('plan.edit', $plan->idPlan) }}" class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600">Editar</a>

                         {{-- Enlace para Eliminar --}}
                        <form method="POST" action="{{ route('plan.destroy', $plan->idPlan) }}" onsubmit="return confirm('¿Está seguro de eliminar este plan?')">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-600 text-white px-2 py-1 rounded hover:bg-red-700">Eliminar</button>
                        </form>

                    </td>
                </tr>

             @endforeach
        </tbody>
    </table>
</div>
<div class="mt-4">
<a href="{{ route('dashboard.externo') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">REGRESAR</a> 
</div>
@endsection