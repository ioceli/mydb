@extends('layouts.app')

@section('title','Nueva Persona')

@section('content')

@if ($errors->any())
<div class="bg-red-100 text-red-700 p-4 rounded mb-4">
    <ul>
        @foreach($errors->all() as $error )
        <li>-{{$error}}</li>
@endforeach
        
    </ul>
</div>
@endif

{{--FORMULARIO PARA LA CREACION DE PERSONA--}}
<form action="{{ route ('persona.store')}} "method="POST" class="space-y-4">
    @csrf
<div>
    <label class="block">CEDULA</label>
    <input type="text" name="cedula"  maxlength="10" pattern="[0-9]{10}" required>
</div>
<div>
    <label class="block">NOMBRES</label>
    <input type="text" name="nombres" required>
</div>
<div>
    <label class="block">APELLIDOS</label>
    <input type="text" name="apellidos" required>
</div>
<div>
    <label class="block">ROL</label>
     <select name="rol" required>
            <option value="">Seleccione un rol</option>
            <option value="Administrador del Sistema">Administrador del Sistema</option>
            <option value="Técnico de Planificación">Técnico de Planificación</option>
            <option value="Revisor Institucional">Revisor Institucional</option>
            <option value="Autoridad Validante">Autoridad Validante</option>
            <option value="Usuario Externo">Usuario Externo</option>
            <option value="Auditor">Auditor</option>
            <option value="Desarrollador">Desarrollador</option>
        </select>
</div>
<div>
    <label class="block">ESTADO</label>
     <select name="estado" required>
            <option value="">Seleccione un estado</option>
            <option value="Activo">Activo</option>
            <option value="Inactivo">Inactivo</option>
        </select>
</div>
<div>
    <label class="block">CORREO</label>
   <input type="email" name="correo" required>
</div>
<div>
    <label class="block">GENERO</label>
    <select name="genero" required>
            <option value="">Seleccione un género</option>
            <option value="Masculino">Masculino</option>
            <option value="Femenino">Femenino</option>
            <option value="Otro">Otro</option>
        </select>
</div>
<div>
    <label class="block">TELEFONO</label>
     <input type="text" name="telefono" value="{{ old('telefono') }}" pattern="[0-9]{9,15}" required>
</div>
<div>
    <label class="block">CONTRASEÑA</label>
    <input type="password" name="contraseña" required>
</div>


<button type="submit">GUARDAR</button>

<a href="{{route('persona.index')}}">VOLVER</a>
</form>

@endsection