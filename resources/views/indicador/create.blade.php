@extends('layouts.master')
@section('title','Nuevo Indicador')
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
<h2 class="text-xl font-bold mb-4">Registrar nuevo Indicador</h2>
    <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
        {{--FORMULARIO PARA LA CREACION DE INDICADOR--}}
            <form action="{{ route ('indicador.store')}} "method="POST" class="space-y-4">
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
    <label class="w-full max-w-xl mb-2 font-bold">FECHA MEDICION</label>
    <input class="w-full max-w-xl mb-2 border rounded p-2" type="date" name="fechaMedicion" required>
</div>
<div>
    <label class="w-full max-w-xl mb-2 font-bold">FORMULA</label>
    <input class="w-full max-w-xl mb-2 border rounded p-2" type="text" name="formula" required>
</div>
<div>
    <label class="w-full max-w-xl mb-2 font-bold">TIPO</label>
    <input class="w-full max-w-xl mb-2 border rounded p-2" type="text" name="tipo" required>
</div>
<div>
    <label class="w-full max-w-xl mb-2 font-bold">UNIDAD MEDIDA</label>
    <input class="w-full max-w-xl mb-2 border rounded p-2" type="text" name="unidadMedida" required>
</div>
<div>
    <label class="w-full max-w-xl mb-2 font-bold">VALOR ACTUAL</label>
    <input class="w-full max-w-xl mb-2 border rounded p-2" type="number" name="valorActual" required>
</div>
<div>
    <label class="w-full max-w-xl mb-2 font-bold">VALOR BASE</label>
    <input class="w-full max-w-xl mb-2 border rounded p-2" type="number" name="valorBase" required>
</div>
<div>
    <label class="w-full max-w-xl mb-2 font-bold">VALOR META</label>
    <input class="w-full max-w-xl mb-2 border rounded p-2" type="number" name="valorMeta" required>
</div>
<button type="submit" class="btn btn-success font-bold">GUARDAR</button>
<a href="{{route('indicador.index')}}" class="btn btn-secondary text-white font-bold">VOLVER</a>
</form>

@endsection