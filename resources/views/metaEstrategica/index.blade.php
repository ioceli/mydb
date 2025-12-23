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
                <th class="p-2 border">ID</th>
                <th class="p-2 border">NOMBRE META ESTRATEGICA</th>
                <th class="p-2 border">ALINEACION CON META PLAN NACIONAL</th>
                <th class="p-2 border">ALINEACION CON INDICADOR</th>
                <th class="p-2 border">DESCRIPCION</th>
                <th class="p-2 border">FECHA INICIO</th>
                <th class="p-2 border">FECHA FIN</th>
                <th class="p-2 border">FORMULA INDICADOR</th>
                <th class="p-2 border">META ESPERADA</th>
                <th class="p-2 border">PROGRESO ACTUAL </th>
                <th class="p-2 border">TIPO INDICADOR </th>
                <th class="p-2 border">UNIDAD MEDIDA</th>
                <th class="p-2 border">ACCIONES</th>
            </tr>
        </thead>
        <tbody> 
            @forelse($metas as $index => $meta)
                <tr>
                    <td class="border p-2 text-center">{{ $index + 1 }}</td>
                    <td class="border p-2">{{ $meta->nombre }}</td>
                    <td class="border p-2">
                        @if($meta->metasPlanNacional->count())
                            <ul class="list-disc list-inside">
                                @foreach($meta->metasPlanNacional as $m)
                                    <li>{{ $m->descripcion }}</li>
                                @endforeach
                            </ul>
                        @else
                            <span class="text-gray-500">Sin metas PND asociadas</span>
                        @endif
                    </td>
                    <td class="border p-2">
                        @if($meta->indicadores->count())
                            <ul class="list-disc list-inside">
                                @foreach($meta->indicadores as $i)
                                    <li>{{ $i->descripcion }}</li>
                                @endforeach
                            </ul>
                        @else
                            <span class="text-gray-500">Sin indicadores asociados</span>
                        @endif
                    </td>
                    <td class="border p-2">{{ $meta->descripcion }}</td>
                    <td class="border p-2">{{ $meta->fechaInicio }}</td>
                    <td class="border p-2">{{ $meta->fechaFin }}</td>
                    <td class="border p-2">{{ $meta->formulaIndicador }}</td>
                    <td class="border p-2">{{ $meta->metaEsperada }}</td>
                    <td class="border p-2">{{ $meta->progresoActual }}</td>
                    <td class="border p-2">{{ $meta->tipoIndicador }}</td>
                    <td class="border p-2">{{ $meta->unidadMedida }}</td>
                    <td class="p-2 flex gap-2">
                    {{-- Enlace para Editar --}}   
                    <a href="{{ route('metaEstrategica.edit', $meta->idMetaEstrategica) }}" 
                    class="inline-flex items-center px-3 py-1.5 bg-yellow-500 text-white text-xs font-bold rounded hover:bg-yellow-600 transition duration-150 shadow-sm" title="Editar meta estratégica">
                        <i class="fas fa-edit mr-1"></i>
                        Editar
                    </a>
                        {{-- Enlace para Eliminar --}}
                        <form method="POST" action="{{ route('metaEstrategica.destroy', $meta->idMetaEstrategica) }}"
                        class="inline"
                        onsubmit="return confirmDelete(event, '{{ addslashes($meta->nombre) }}')">
                           @csrf
                            @method('DELETE')
                             <button type="submit"
                             class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white text-xs font-bold rounded hover:bg-red-700 transition duration-150 shadow-sm" title="Eliminar meta estratégica">
                                <i class="fas fa-trash-alt mr-1"></i>
                                Eliminar
                                </button>
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
                html: `Esta acción eliminará permanentemente la meta estratégica:<br><strong>"${nombre}"</strong><br>y no podrá revertirse`,
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