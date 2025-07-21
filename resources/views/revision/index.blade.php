@extends('layouts.master')
@section('content')
@php
    use App\Enums\EstadoRevisionEnum;
@endphp 
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Revisión de Planes, Programas y Proyectos</h1>

    @foreach (['planes', 'programas', 'proyectos'] as $tipo)
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-2">{{ ucfirst($tipo) }}</h2>
            <div class="overflow-x-auto">
                <table class="table-auto w-full bg-white shadow-md rounded-lg overflow-hidden">
                    <thead class="bg-gray-200 text-gray-700">
                        <tr>
                            <th class="px-4 py-2">ID</th>
                            <th class="px-4 py-2">Nombre</th>
                            <th class="px-4 py-2">Estado provisional</th>
                            <th class="px-4 py-2">Objetivos Estratégicos</th>
                            <th class="px-4 py-2">Metas Estratégicas</th>
                            <th class="px-4 py-2">Actualizar Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($$tipo as $item)
                            @php
                                $primaryKey = $tipo === 'planes' ? 'idPlan' : ($tipo === 'programas' ? 'idPrograma' : 'idProyecto');
                            @endphp
                            <tr class="border-b">
                                <td class="border p-2">{{ $item->$primaryKey }}</td>
                                <td class="border p-2">{{ $item->nombre ?? '-' }}</td>
                                <td class="border p-2">{{ $item->estado_revision }}</td>
                                <td class="border p-2">
                                    @forelse ($item->objetivosEstrategicos as $obj)
                                        <div>- {{ $obj->descripcion }}</div>
                                    @empty
                                        <span class="text-gray-400">Sin objetivos</span>
                                    @endforelse
                                </td>
                                <td class="border p-2">
                                    @forelse ($item->metasEstrategicas as $meta)
                                        <div>- {{ $meta->nombre }}</div>
                                    @empty
                                        <span class="text-gray-400">Sin metas</span>
                                    @endforelse
                                </td>
                                <td class="border p-2">
                                    <form action="{{ route('revision.estado', ['tipo' => $tipo, 'id' => $item->$primaryKey]) }}" method="POST" class="flex items-center space-x-2">
                                        @csrf
                                        @method('PUT')
                                        <select name="estado_revision" class="border rounded px-2 py-1">
                                            <option value="pendiente" {{ $item->estado_revision == 'pendiente' ? 'selected' : '' }}>pendiente</option>
                                            <option value="Aprobado" {{ $item->estado_revision == 'Aprobado' ? 'selected' : '' }}>Aprobado</option>
                                            <option value="Devuelto" {{ $item->estado_revision == 'Devuelto' ? 'selected' : '' }}>Devuelto</option>
                                        </select>
                                        <button type="submit" class="font-bold btn btn-success">
                                            Actualizar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
</div>
<a href="{{route('dashboard.revisor')}}" class="font-bold btn btn-secondary text-white">VOLVER</a>
@endsection