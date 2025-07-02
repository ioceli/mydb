@extends('layouts.app')

@section('title','Editar Persona')

@php
    use App\Enums\RolEnum;
    use App\Enums\EstadoEnum;
    use App\Enums\GeneroEnum;
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

<h2 class="text-2x1 font-bold mb-4"> EDITAR PERSONA   </h2>

<form action="{{route ('persona.update', $persona->idPersona )}}"method="POST" class="space-y-4">
@csrf
@method('PUT')
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
        <label class="block font-semibold">CÉDULA</label>
        <input type="text" name="cedula" value="{{ old('cedula', $persona->cedula) }}" maxlength="10" pattern="[0-9]{10}" required>
    </div>

    <div>
        <label class="block font-semibold">NOMBRES</label>
        <input type="text" name="nombres" value="{{ old('nombres', $persona->nombres) }}" required>
    </div>

    <div>
        <label class="block font-semibold">APELLIDOS</label>
        <input type="text" name="apellidos" value="{{ old('apellidos', $persona->apellidos) }}" required>
    </div>

    <div>
    <label class="block">ROL</label>
    <select name="rol" required>
        <option value="">Seleccione un rol</option>
        @foreach (RolEnum::cases() as $rol)
            <option value="{{ $rol->value }}" {{ old('rol', $persona->rol ?? '') === $rol->value ? 'selected' : '' }}>
                {{ $rol->value }}
            </option>
        @endforeach
    </select>
</div>
    <div>
    <label class="block font-semibold">ESTADO</label>
    <select name="estado" required>
        <option value="">Seleccione un estado</option>
        @foreach (EstadoEnum::cases() as $estado)
            <option value="{{ $estado->value }}" {{ old('estado',  $persona->estado ??'') === $estado->value? 'selected' : '' }}>
                {{ $estado->value }}
            </option>
        @endforeach
    </select>
</div>

    <div>
        <label class="block font-semibold">CORREO</label>
        <input type="email" name="correo" value="{{ old('correo', $persona->correo) }}" required>
    </div>

   <div>
    <label class="block font-semibold">GÉNERO</label>
    <select name="genero" required>
        <option value="">Seleccione un genero</option>
        @foreach (GeneroEnum::cases() as $genero)
            <option value="{{ $genero->value }}" {{ old('genero', $persona->genero ??'') === $genero->value? 'selected' : '' }}>
                {{ $genero->value }}
            </option>
        @endforeach
    </select>
</div>

    <div>
        <label class="block font-semibold">TELÉFONO</label>
        <input type="text" name="telefono" value="{{ old('telefono', $persona->telefono) }}" pattern="[0-9]{9,15}" required>
    </div>

    <div>
        <label class="block font-semibold">CONTRASEÑA</label>
        <input type="password" name="contraseña" value="{{ old('contraseña', $persona->contraseña) }}" required>
    </div>

<button type="submit">ACTUALIZAR</button>

<a href="{{route('persona.index')}}">CANCELAR</a>
</form>


@endsection