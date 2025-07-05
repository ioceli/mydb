@extends('layouts.master')

@section('title','Nueva Indicador')

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

{{--FORMULAIO PARA LA CREACION DE INDICADOR--}}
<form action="{{ route ('indicador.store')}} "method="POST" class="space-y-4">
    @csrf
<div>
    <label class="block">NOMBRE</label>
    <input type="text" name="nombre" required>
</div>
    <div>
    <label class="block">DESCRIPCION</label>
    <input type="text" name="descripcion" required>
</div>
<div>
    <label class="block">FECHA MEDICION</label>
    <input type="date" name="fechaMedicion" required>
</div>
<div>
    <label class="block">FORMULA</label>
    <input type="text" name="formula" required>
</div>
<div>
    <label class="block">TIPO</label>
    <input type="text" name="tipo" required>
</div>
<div>
    <label class="block">UNIDAD MEDIDA</label>
    <input type="text" name="unidadMedida" required>
</div>
<div>
    <label class="block">VALOR ACTUAL</label>
    <input type="number" name="valorActual" required>
</div>
<div>
    <label class="block">VALOR BASE</label>
    <input type="number" name="valorBase" required>
</div>
<div>
    <label class="block">VALOR META</label>
    <input type="number" name="valorMeta" required>
</div>
<button type="submit">GUARDAR</button>
<a href="{{route('indicador.index')}}">VOLVER</a>
</form>

@endsection