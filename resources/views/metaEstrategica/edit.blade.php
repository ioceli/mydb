@extends('layouts.master')
@section('title','Editar Meta Estrategica')
@section('content')
<h2 class="text-xl font-bold mb-4"> EDITAR META ESTRATEGICA   </h2>
@if ($errors->any())
    <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
        <ul>
            @foreach($errors->all() as $error )
                <li>- {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <form action="{{route ('metaEstrategica.update', $meta->idMetaEstrategica )}}"method="POST" class="space-y-4">
@csrf
@method('PUT')
{{-- Plan --}}
            <div>
                <label for="idPlan" class="block font-bold mb-1">Plan</label>
                <select name="idPlan" id="idPlan" class="w-full border rounded p-2" required>
                    <option value="">Seleccione un plan</option>
                    @foreach ($planes as $plan)
                        <option value="{{ $plan->idPlan }}" {{ $meta->idPlan == $plan->idPlan ? 'selected' : '' }}>
                            {{ $plan->nombre }} - {{ $plan->entidad->subSector ?? 'Sin entidad' }}
                        </option>
                    @endforeach
                </select>
            </div>
            {{-- Metas del PND --}}
            <div>
                <label class="block font-bold mb-2">Metas del Plan Nacional de Desarrollo</label>
                <div class="space-y-2">
                    @foreach ($metaPlanNacional as $m)
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="metaPlanNacional[]" value="{{ $m->idMetaPlanNacional }}"
                                {{ $meta->metasPlanNacional->contains('idMetaPlanNacional', $m->idMetaPlanNacional) ? 'checked' : '' }}>
                            <span>{{ $m->descripcion }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
<div>
    <label class="block font-bold mb-2">NOMBRE</label>
    <input type="text" class="w-full border rounded p-2" name="nombre" required value="{{old('nombre', $meta->nombre)}}">
</div>
<div>
    <label class="block font-bold mb-2">DESCRIPCION</label>
    <input type="text" class="w-full border rounded p-2" name="descripcion" required value="{{old('descripcion', $meta->descripcion)}}">
</div>
<div>
    <label class="block font-bold mb-2">FECHA INICIO</label>
    <input type="date" class="w-full border rounded p-2" name="fechaInicio" required value="{{old('fechaInicio', $meta->fechaInicio)}}">
</div>
<div>
    <label class="block font-bold mb-2">FECHA FIN</label>
    <input type="date" class="w-full border rounded p-2" name="fechaFin" required value="{{old('fechaFin', $meta->fechaFin)}}">
</div>
<div>
    <label class="block font-bold mb-2">FORMULA INDICADOR</label>
    <input type="string" class="w-full border rounded p-2" name="formulaIndicador" required value="{{old('formulaIndicador', $meta->formulaIndicador)}}">
</div>
<div>
    <label class="block font-bold mb-2">META ESPERADA</label>
    <input type="number" class="w-full border rounded p-2" name="metaEsperada" required value="{{old('metaEsperada', $meta->metaEsperada)}}">
</div>
<div>
    <label class="block font-bold mb-2">PROGRESO ACTUAL</label>
    <input type="number" class="w-full border rounded p-2" name="progresoActual" required value="{{old('progresoActual', $meta->progresoActual)}}">
</div>
<div>
    <label class="block font-bold mb-2">TIPO INDICADOR</label>
    <input type="number" class="w-full border rounded p-2" name="tipoIndicador" required value="{{old('tipoIndicador', $meta->tipoIndicador)}}">
</div>
<div>
    <label class="block font-bold mb-2">UNIDAD MEDIDA</label>
    <input type="string" class="w-full border rounded p-2" name="unidadMedida" required value="{{old('unidadMedida', $meta->unidadMedida)}}">
</div>

<div class="flex gap-4">
<button type="submit" class="bg-green-500 text-white rounded px-4 py-2">ACTUALIZAR</button>
<a href="{{route('metaEstrategica.index')}}" class="bg-gray-500 text-white rounded px-4 py-2">CANCELAR</a>
</div>
</form>
</div>
@endsection