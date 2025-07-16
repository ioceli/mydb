@extends('layouts.master')
@section('title','Nueva Meta Estrategica')
@section('content')

@if ($errors->any())
<div>
    <ul>
        @foreach($errors->all() as $error )
        <li>-{{$error}}
@endforeach
        </li>
    </ul>
</div>
@endif
<h2 class="text-xl font-bold mb-4">Registrar nueva Meta Estrategica</h2>
    <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
        {{--FORMULARIO PARA LA CREACION DE META ESTRATEGICA--}}
            <form action="{{ route ('metaEstrategica.store')}} "method="POST" class="space-y-4">
                @csrf
{{-- Plan --}}
        <div>
            <label class="block font-bold mb-1">Plan Asociado</label>
            <select name="idPlan" class="w-full border rounded p-2" required>
                <option value="">Seleccione un plan</option>
                @foreach($planes as $plan)
                    <option value="{{ $plan->idPlan }}">{{ $plan->nombre }} ({{ $plan->entidad->subSector ?? 'Sin entidad' }})</option>
                @endforeach
            </select>
        </div>
{{-- Metas del Plan Nacional (Checkboxes) --}}
        <div>
            <label class="block font-bold mb-2">Seleccione Metas del Plan Nacional de Desarrollo</label>
            @if($metaPlanNacional->count())
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                    @foreach($metaPlanNacional as $meta)
                        <label class="flex items-start space-x-2">
                            <input type="checkbox" name="idMetaPlanNacional[]" value="{{ $meta->idMetaPlanNacional }}" class="mt-1">
                            <span>{{ $meta->descripcion }}</span>
                        </label>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">No hay metas del PND registradas.</p>
            @endif
        </div>
         <div>
    <label class="w-full max-w-xl mb-2 font-bold">NOMBRE META ESTRATEGICA</label>
    <input class="w-full max-w-xl mb-2 border rounded p-2" type="text" name="nombre" required>
</div>
    <div>
    <label class="w-full max-w-xl mb-2 font-bold">DESCRIPCION</label>
    <input class="w-full max-w-xl mb-2 border rounded p-2" type="text" name="descripcion" required>
</div>
<div>
    <label class="w-full max-w-xl mb-2 font-bold">FECHA INICIO</label>
    <input class="w-full max-w-xl mb-2 border rounded p-2" type="date" name="fechaInicio" required>
</div>
<div>
    <label class="w-full max-w-xl mb-2 font-bold">FECHA FIN</label>
    <input class="w-full max-w-xl mb-2 border rounded p-2" type="date" name="fechaFin" required>
</div>
<div>
    <label class="w-full max-w-xl mb-2 font-bold">FORMULA INDICADOR</label>
    <input class="w-full max-w-xl mb-2 border rounded p-2" type="text" name="formulaIndicador" required>
</div>
<div>
    <label class="w-full max-w-xl mb-2 font-bold">META ESPERADA</label>
    <input class="w-full max-w-xl mb-2 border rounded p-2" type="number" name="metaEsperada" required>
</div>
<div>
    <label class="w-full max-w-xl mb-2 font-bold">PROGRESO ACTUAL</label>
    <input class="w-full max-w-xl mb-2 border rounded p-2"  type="number" name="progresoActual" required>
</div>
<div>
    <label class="w-full max-w-xl mb-2 font-bold">TIPO INDICADOR</label>
    <input class="w-full max-w-xl mb-2 border rounded p-2" type="number" name="tipoIndicador" required>
</div>
<div>
    <label class="w-full max-w-xl mb-2 font-bold">UNIDAD MEDIDA</label>
    <input class="w-full max-w-xl mb-2 border rounded p-2" type="text" name="unidadMedida" required>
</div>
<button type="submit" class="btn btn-success font-bold">GUARDAR</button>
<a href="{{route('metaEstrategica.index')}}" class="btn btn-secondary text-white font-bold">VOLVER</a>
</form>
@endsection