@php
    use Illuminate\Support\Facades\Auth;
    // Puedes comparar con los nombres de rol exactos que usas en la BD/enum
    $role = Auth::check() ? Auth::user()->rol : null;
@endphp

@if ($role === 'Técnico de Planificación')
    <x-tecnico-sidebar />
@elseif ($role === 'Administrador del Sistema')
    <x-admin-sidebar />
@elseif ($role === 'Revisor Institucional')
    <x-revisor-sidebar />
@elseif ($role === 'Autoridad Validante')
    <x-autoridad-sidebar />
@elseif ($role === 'Usuario Externo')
    <x-externo-sidebar />
@elseif ($role === 'Auditor')
    <x-auditor-sidebar />
@else
    {{-- Fallback: si no hay rol conocido mostramos el sidebar del administrador por defecto --}}
    <x-admin-sidebar />
@endif