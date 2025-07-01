@extends('layouts.app')

@section('title','Editar Auditoria')

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

<h2 class="text-2x1 font-bold mb-4"> EDITAR AUDITORIA   </h2>

<form action="{{route ('auditoria.update', $auditoria->idAuditoria )}}"method="POST" class="space-y-4">
@csrf
@method('PUT')
<div>
    <label class="block">NOMBRE</label>
    <input type="text" name="nombre" required value="{{old('nombre', $auditoria->nombre)}}">
</div>
<button type="submit">ACTUALIZAR</button>

<a href="{{route('auditoria.index')}}">CANCELAR</a>
</form>

@endsection