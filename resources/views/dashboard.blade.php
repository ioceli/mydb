<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel de Usuario - SIPeIP') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Bienvenido, {{ Auth::user()->name }}</h3>
                <p class="text-gray-600 mb-2">Rol asignado: <strong>{{ Auth::user()->rol }}</strong></p>

                <ul class="list-disc ml-6 text-blue-700 space-y-2 mt-4">
                    @if(Auth::user()->rol === 'Administrador del Sistema')
                        <li><a href="{{ route('persona.index') }}">Gestión de Usuarios</a></li>
                    @endif

                    @if(Auth::user()->rol === 'Técnico de Planificación')
                        <li><a href="{{ route('programa.index') }}">Gestión de Programas</a></li>
                        <li><a href="{{ route('proyecto.index') }}">Gestión de Proyectos</a></li>
                        <li><a href="{{ route('plan.index') }}">Gestión de Planes</a></li>
                    @endif

                    @if(Auth::user()->rol === 'Revisor Institucional')
                        <li><a href="{{ route('revision.index') }}">Revisión de Proyectos</a></li>
                    @endif

                    @if(Auth::user()->rol === 'Autoridad Validante')
                        <li><a href="{{ route('plan.index') }}">Validación de Proyectos</a></li>
                    @endif

                    @if(Auth::user()->rol === 'Usuario Externo')
                        <li><a href="{{ route('persona.index') }}">Consulta de Información Pública</a></li>
                    @endif

                    @if(Auth::user()->rol === 'Auditor')
                        <li><a href="{{ route('auditoria.index') }}">Auditoría y Seguimiento</a></li>
                    @endif

                    @if(Auth::user()->rol === 'Desarrollador')
                        <li><a href="{{ route('api.docs') }}">Documentación de la API</a></li>
                        <li><a href="{{ route('logs.index') }}">Ver Logs del Sistema</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>