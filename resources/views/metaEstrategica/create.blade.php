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
        <div>
    <label class="w-full max-w-xl mb-2 font-bold">NOMBRE</label>
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