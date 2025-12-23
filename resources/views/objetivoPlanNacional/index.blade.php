@extends('layouts.master')
@section('title','Inicio')
@section('content')
@php
    use App\Enums\RolEnum;
    $role = Auth::check() ? Auth::user()->rol : null;
@endphp
<div class="bg-gray-50 min-h-screen">
    <div class="flex">
        {{-- Menú Lateral --}}
        <x-dynamic-sidebar />
        {{-- Contenido Principal --}}
        <div class="flex-1 p-6">
<h2 class="text-2x1 font-bold mb-4"> Listado de Objetivo Plan Nacional   </h2>
{{--VALIDACION--}}
 @if (session('success'))
    <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif
    {{--BOTON PARA LLAMAR AL FORMULARIO CREAR OBJETIVO PLAN NACIONAL--}}

<a href="{{route('objetivoPlanNacional.create')}}" class="font-bold mb-4 inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700"> Nuevo Objetivo Plan Nacional</a>
    {{--TABLA PARA LISTAR TODOS LOS OBJETIVO PLAN NACIONAL--}}
<div class="overflow-x-auto bg-white rounded shadow">
    <table class="min-w-full table-auto border-collapse">
        <thead class="bg-gray-200 text-gray-700 text-left">
            <tr>
                <th style="border: 1px solid #ccc; padding: 8px">ID</th>
                <th style="border: 1px solid #ccc; padding: 8px">CODIGO</th>
                <th style="border: 1px solid #ccc; padding: 8px">NOMBRE</th>
                <th style="border: 1px solid #ccc; padding: 8px">DESCRIPCION</th>
                <th style="border: 1px solid #ccc; padding: 8px">EJE PLAN NACIONAL</th>
                <th style="border: 1px solid #ccc; padding: 8px">ACCIONES</th>

            </tr>

        </thead>
        <tbody> 
            @foreach($objetivoPlanNacional as $objetivoPlanNacional)
                <tr class="border-b">
                <td style="border: 1px solid #ccc; padding: 8px">{{$objetivoPlanNacional->idObjetivoPlanNacional}}</td>
                <td style="border: 1px solid #ccc; padding: 8px">{{$objetivoPlanNacional->codigo}}</td>
                <td style="border: 1px solid #ccc; padding: 8px">{{$objetivoPlanNacional->nombre}}</td>
                <td style="border: 1px solid #ccc; padding: 8px">{{$objetivoPlanNacional->descripcion}}</td>
                <td style="border: 1px solid #ccc; padding: 8px">{{$objetivoPlanNacional->ejePnd}}</td>
                <td class="p-2 flex gap-2">

    {{-- Enlace para Editar --}}
    <a href="{{ route('objetivoPlanNacional.edit', $objetivoPlanNacional->idObjetivoPlanNacional) }}" 
    class="inline-flex items-center px-3 py-1.5 bg-yellow-500 text-white text-xs font-bold rounded hover:bg-yellow-600 transition duration-150 shadow-sm" title="Editar objetivo de plan nacional">
        <i class="fas fa-edit mr-1"></i>
        Editar
    </a>

    {{-- Enlace para Eliminar --}}
        <form method="POST" action="{{ route('objetivoPlanNacional.destroy', $objetivoPlanNacional->idObjetivoPlanNacional) }}" 
        class="inline"   
        onsubmit="return confirmDelete(event, '{{ addslashes($objetivoPlanNacional->nombre) }}')">
            @csrf
            @method('DELETE')
            <button type="submit"
            class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white text-xs font-bold rounded hover:bg-red-700 transition duration-150 shadow-sm" title="Eliminar objetivo de plan nacional">
                <i class="fas fa-trash-alt mr-1"></i>
                Eliminar
            </button>
        </form>

    </td>
</tr>

@endforeach
</tbody>
</table>
</div>
<div class="mt-6">
    @if ($role === RolEnum::admin->value)
        <a href="{{ route('dashboard.admin') }}" 
           class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition duration-150">
            REGRESAR
        </a>
    @elseif ($role === RolEnum::tecnico->value)
        <a href="{{ route('dashboard.tecnico') }}" 
           class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition duration-150">
            REGRESAR
        </a>
    @endif
</div>
    </div>
</div>

{{-- SweetAlert2 CDN --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- JavaScript para confirmación de eliminación --}}
<script>
    function confirmDelete(event, nombre) {
        event.preventDefault();
        const form = event.target;
        Swal.fire({
            title: '¿Está seguro?',
            html: `Esta acción eliminará permanentemente el objetivo:<br><strong>"${nombre}"</strong><br>y no podrá revertirse`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
        return false;
    }
</script>

{{-- Íconos Font Awesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
@endsection