@extends('layouts.master')

@section('title','Nuevo Objetivo Desarrollo Sostenible')

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
<h2 class="text-xl font-bold mb-4">Registrar nuevo Objetivo de Desarrollo Sostenible</h2>
<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    {{--FORMULARIO PARA LA CREACION DE OBJETIVO DESARROLLO SOSTENIBLE--}}
        <form action="{{ route ('objetivoDesarrolloSostenible.store')}} "method="POST" class="space-y-4">
            @csrf

                <div class="mb-4">
                    <label class="w-full max-w-xl mb-2 font-bold">NUMERO</label>
                    <input  class="w-full max-w-xl mb-2 border rounded p-2" type="number" name="numero"  required>
                </div>
                <div>
                    <label class="w-full max-w-xl mb-2 font-bold">NOMBRE</label>
                    <input class="w-full max-w-xl mb-2 border rounded p-2" type="text" name="nombre" required>
                </div>
                <div>
                    <label class="w-full max-w-xl mb-2 font-bold">DESCRIPCION</label>
                    <input class="w-full max-w-xl mb-2 border rounded p-2" type="text" name="descripcion" required>
                </div>
                <div>
                    <button type="submit" class="btn btn-success font-bold">GUARDAR</button>
                    <a href="{{route('objetivoDesarrolloSostenible.index')}}" class="btn btn-secondary text-white font-bold">VOLVER</a>
                </div>    
            </form>
</div>
@endsection