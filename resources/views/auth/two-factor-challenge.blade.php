@extends('layouts.master')

@section('title', 'Autenticación Multifactor')

@section('content')
<h2 class="text-xl font-bold mb-4">Ingrese el código de autenticación multifactor</h2>

@if ($errors->any())
    <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
        {{ $errors->first() }}
    </div>
@endif

<form method="POST" action="{{ route('two-factor.verify') }}">
    @csrf
    <div>
        <label for="two_factor_code" class="block mb-2 font-bold">Código MFA</label>
        <input type="text" id="two_factor_code" name="two_factor_code" class="border p-2 rounded w-full" required autofocus>
    </div>
    <button type="submit" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded">Verificar Código</button>
</form>
@endsection