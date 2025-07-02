@extends('layouts.app')

@section('title','Inicio')

@section('content')
<h2 class="text-2x1 font-bold mb-4"> Listado de plan   </h2>

{{--VALIDACION--}}
    @if (session ('success'))
        <div>
            {{session('success')}}
        </div>
    @endif
    {{--BOTON PARA LLAMAR AL FORMULARIO CREAR PLAN--}}

<a href="{{route('plan.create')}}"> + Nuevo Plan</a>
    {{--TABLA PARA LISTAR TODOS LOS PLANES--}}

<table style="background-color: #f8f8fa;">
<thead>
<tr>
<th style="border: 1px solid #ccc; padding: 8px">ID</th>
<th style="border: 1px solid #ccc; padding: 8px">ENTIDAD</th>
<th style="border: 1px solid #ccc; padding: 8px">NOMBRE</th>
<th style="border: 1px solid #ccc; padding: 8px">ESTADO</th>
<th style="border: 1px solid #ccc; padding: 8px">ACCIONES</th>

</tr>

</thead>
<tbody> 
    @foreach($plan as $plan)
    <tr>
        <td style="border: 1px solid #ccc; padding: 8px">{{$plan->idPlan}}</td>
                <td style="border: 1px solid #ccc; padding: 8px">{{$plan->entidad->subSector}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$plan->nombre}}</td>
<td style="border: 1px solid #ccc; padding: 8px">{{$plan->estado}}</td>
<td style="border: 1px solid #ccc; padding: 8px">

    {{-- Enlace para Editar --}}
    <a href="{{ route('plan.edit', $plan->idPlan) }}" style="margin-right: 10px;">✏️Editar</a>

    {{-- Enlace para Eliminar --}}
    <a href="{{ route('plan.edit', $plan->idPlan) }}" onclick="event.preventDefault(); if(confirm('¿Estás seguro de eliminar este Plan?')) { document.getElementById('form-eliminar-{{ $plan->idPlan }}').submit(); }" style="color: red;">🗑️ Eliminar</a>

    {{-- Formulario oculto --}}
    <form id="form-eliminar-{{ $plan->idPlan }}" action="{{ route('plan.destroy', $plan->idPlan) }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

</td>
</tr>

@endforeach
</tbody>
</table>
@endsection