@extends('layouts.app')

@section('title','Editar Persona')

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
    <label class="block font-semibold">ROL</label>
    <select name="rol" required>
        <option value="">Seleccione un rol</option>
        <option value="Administrador del Sistema" {{ old('rol', $persona->rol ?? '') == 'Administrador del Sistema' ? 'selected' : '' }}>Administrador del Sistema</option>
        <option value="Técnico de Planificación" {{ old('rol', $persona->rol ?? '') == 'Técnico de Planificación' ? 'selected' : '' }}>Técnico de Planificación</option>
        <option value="Revisor Institucional" {{ old('rol', $persona->rol ?? '') == 'Revisor Institucional' ? 'selected' : '' }}>Revisor Institucional</option>
        <option value="Autoridad Validante" {{ old('rol', $persona->rol ?? '') == 'Autoridad Validante' ? 'selected' : '' }}>Autoridad Validante</option>
        <option value="Usuario Externo" {{ old('rol', $persona->rol ?? '') == 'Usuario Externo' ? 'selected' : '' }}>Usuario Externo</option>
        <option value="Auditor" {{ old('rol', $persona->rol ?? '') == 'Auditor' ? 'selected' : '' }}>Auditor</option>
        <option value="Desarrollador" {{ old('rol', $persona->rol ?? '') == 'Desarrollador' ? 'selected' : '' }}>Desarrollador</option>
    </select>
</div>

    <div>
    <label class="block font-semibold">ESTADO</label>
    <select name="estado" required>
        <option value="">Seleccione un estado</option>
        <option value="Activo" {{ old('estado', $persona->estado ?? '') == 'Activo' ? 'selected' : '' }}>Activo</option>
        <option value="Inactivo" {{ old('estado', $persona->estado ?? '') == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
    </select>
</div>

    <div>
        <label class="block font-semibold">CORREO</label>
        <input type="email" name="correo" value="{{ old('correo', $persona->correo) }}" required>
    </div>

   <div>
    <label class="block font-semibold">GÉNERO</label>
    <select name="genero" required>
        <option value="">Seleccione un género</option>
        <option value="Masculino" {{ old('genero', $persona->genero ?? '') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
        <option value="Femenino" {{ old('genero', $persona->genero ?? '') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
        <option value="Otro" {{ old('genero', $persona->genero ?? '') == 'Otro' ? 'selected' : '' }}>Otro</option>
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