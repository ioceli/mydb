@extends('layouts.master')

@section('title','Nueva Persona')

@section('content')

@php
    use App\Enums\RolEnum;
    use App\Enums\EstadoEnum;
    use App\Enums\GeneroEnum;
@endphp

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
    <label class="block">ENTIDAD</label>
    <select name="idEntidad" required>
        @foreach ($entidad as $entidad)
        <option value="{{$entidad->idEntidad}}">{{$entidad->subSector}}

        </option>
        @endforeach
    </select>
 </div>
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
        @foreach (RolEnum::cases() as $rol)
            <option value="{{ $rol->value }}" {{ old('rol') === $rol->value ? 'selected' : '' }}>
                {{ $rol->value }}
            </option>
        @endforeach
    </select>
</div>
<div>
    <label class="block">ESTADO</label>
     <select name="estado" required>
 <option value="">Seleccione un estado</option>
        @foreach (EstadoEnum::cases() as $estado)
            <option value="{{ $estado->value }}" {{ old('estado') === $estado->value ? 'selected' : '' }}>
                {{ $estado->value }}
            </option>
        @endforeach
    </select>
</div>
<div>
    <label class="block">CORREO</label>
   <input type="email" name="correo" required>
</div>
<div>
    <label class="block">GENERO</label>
    <select name="genero" required>
            <option value="">Seleccione un genero</option>
        @foreach (GeneroEnum::cases() as $genero)
            <option value="{{ $genero->value }}" {{ old('genero') === $genero->value ? 'selected' : '' }}>
                {{ $genero->value }}
            </option>
        @endforeach
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