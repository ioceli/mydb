@extends('layouts.master')

@section('title','Editar Plan')

@php
    use App\Enums\EstadoEnum;
@endphp

@section('content')
@if ($errors->any())
    <div>
        <ul>
            @foreach($errors->all() as $error )
                <li>- {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<h2 class="text-2x1 font-bold mb-4"> EDITAR PLANES   </h2>
    <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
        <form action="{{route ('plan.update', $plan->idPlan )}}"method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block mb-1 font-bold">ENTIDAD</label>
                    <select name="idEntidad" class="w-full border rounded p-2" required>
                        @foreach ($entidad as $entidad)
                            <option value="{{$entidad->idEntidad}}">{{$entidad->subSector}}
                            </option>
                        @endforeach
                    </select>
            </div>
            <div>
                <label class="block mb-1 font-bold">NOMBRE</label>
                <input type="text" name="nombre" class="w-full border rounded p-2" required value="{{old('nombre', $plan->nombre)}}">
            </div>
            <div>
                <label class="block mb-1 font-bold">ESTADO</label>
                    <select name="estado"  class="w-full border rounded p-2" required>
                        <option value="">Seleccione un estado</option>
                        @foreach (EstadoEnum::cases() as $estado)
                            <option value="{{ $estado->value }}" {{ old('estado',  $persona->estado ??'') === $estado->value? 'selected' : '' }}>
                                {{ $estado->value }}
                            </option>
                        @endforeach
                    </select>
            </div>
            <div class="flex gap-4">
                <button type="submit " class="font-bold bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">ACTUALIZAR</button>

                    <a href="{{route('plan.index')}}" class="font-bold bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-700">CANCELAR</a>
        </div>
                </form>
</div>
@endsection