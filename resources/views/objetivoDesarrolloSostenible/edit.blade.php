@extends('layouts.master')

@section('title','Editar Objetivo Desarrollo Sostenible')

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

<h2 class="text-2x1 font-bold mb-4"> EDITAR OBJETIVO DESARROLLO SOSTENIBLE   </h2>
    <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
        <form action="{{route ('objetivoDesarrolloSostenible.update', $objetivoDesarrolloSostenible->idObjetivoDesarrolloSostenible )}}"method="POST" class="space-y-4">
            @csrf
            @method('PUT')
             <div class="mb-4">
                <label class="font-bold block mb-1">NUMERO</label>
                <input type="number" name="numero" class="w-full border rounded p-2" required value="{{old('numero', $objetivoDesarrolloSostenible->numero)}}">
            </div>
            <div>
                <label class="font-bold block mb-1">NOMBRE</label>
                <input type="text" name="nombre" class="w-full border rounded p-2" required value="{{old('nombre', $objetivoDesarrolloSostenible->nombre)}}">
            </div>
            <div>
                <label class="font-bold block mb-1">DESCRIPCION</label>
                <input type="text" name="descripcion" class="w-full border rounded p-2" required value="{{old('descripcion', $objetivoDesarrolloSostenible->descripcion)}}">
            </div>
            <div class="flex gap-4">
                <button type="submit" class="font-bold bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">ACTUALIZAR</button>

                <a href="{{route('objetivoDesarrolloSostenible.index')}}" class="font-bold bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-700">CANCELAR</a>
            </div>
        </form>
</div>
@endsection