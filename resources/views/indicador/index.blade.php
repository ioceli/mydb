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
    <a href="{{ route('indicador.edit', $indicador->idIndicador) }}" 
    class="inline-flex items-center px-3 py-1.5 bg-yellow-500 text-white text-xs font-bold rounded hover:bg-yellow-600 transition duration-150 shadow-sm" title="Editar indicador">
        <i class="fas fa-edit mr-1"></i>
        Editar
    </a>
    {{-- Enlace para Eliminar --}}
   <form method="POST" action="{{ route('indicador.destroy', $indicador->idIndicador) }}"
    class="inline"
    onsubmit="return confirmDelete(event, '{{ addslashes($indicador->nombre) }}')">
        @csrf
        @method('DELETE')
        <button type="submit"
        class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white text-xs font-bold rounded hover:bg-red-700 transition duration-150 shadow-sm" title="Eliminar indicador">
            <i class="fas fa-trash-alt mr-1"></i>
            Eliminar
        </button>
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
<script>
    function confirmDelete(event, nombre) {
        event.preventDefault(); // Evita el envío del formulario por defecto

        Swal.fire({
            title: '¿Estás seguro?',
            html: `¿Deseas eliminar el indicador: <br><strong>"${nombre}"</strong> <br> Esta acción no se puede deshacer.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                event.target.submit(); // Envía el formulario si se confirma
            }
        });
    }
</script>   
{{-- Íconos Font Awesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
@endsection