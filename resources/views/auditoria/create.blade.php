@extends('layouts.master')

@section('title','Nueva Auditoria')

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

{{--FORMULAIO PARA LA CREACION DE AUDITORIA--}}
<form action="{{ route ('auditoria.store')}} "method="POST" class="space-y-4">
    @csrf
<div>
    <label class="block">NOMBRE</label>
    <input type="text" name="nombre" required>
<button type="submit">GUARDAR</button>
<a href="{{route('auditoria.index')}}">VOLVER</a>
</form>

@endsection