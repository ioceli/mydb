{{-- Acceso a las propiedades del componente con $title, $userRole, etc. --}}
<aside {{ $attributes->merge(['class' => 'w-64 bg-blue-100 p-6 shadow-xl border-r border-gray-200']) }}>
    
    {{-- Título dinámico --}}
    <h3 class="text-xl font-extrabold text-blue-800 mb-6 border-b pb-2">
        {{ $title }}
    </h3>
    
    {{-- Menús dinámicos --}}
    <div class="mb-8">
        <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">
            Gestión de Autoridad
        </p>
        <nav class="space-y-2">
            @foreach($menus as $menu)
            <a href="{{ route($menu['route']) }}" 
               class="flex items-center p-3 text-blue-700 font-medium rounded-lg hover:bg-blue-50 transition duration-150 ease-in-out border border-transparent hover:border-blue-300 group
                      {{ $menu['active'] ? 'bg-blue-50 border-blue-300' : '' }}">
                
                {{-- Iconos dinámicos --}}
                @if($menu['icon'] == 'users')
                <svg class="w-5 h-5 mr-3 text-blue-500 group-hover:text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path d="M13 7a3 3 0 11-6 0 3 3 0 016 0zM18 14a4 4 0 00-8 0v1h8v-1zM6 14a4 4 0 00-8 0v1h8v-1z"/></svg>
                @elseif($menu['icon'] == 'file-alt')
                <svg class="w-5 h-5 mr-3 text-blue-500 group-hover:text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path d="M4 2a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V7.414A2 2 0 0016.414 6L12 1.586A2 2 0 0010.586 1H4zm8 2.5V6a1 1 0 001 1h2.5L12 4.5zM5 9h10v2H5V9zm0 4h10v2H5v-2z"/></svg>
                @endif
                
                
                <span>{{ $menu['label'] }}</span>
            </a>
            @endforeach
        </nav>
    </div>
    
    {{-- Sección de usuario (condicional) --}}
    @if($showUserSection)
    <div class="mt-8 pt-4 border-t border-gray-200">
        <p class="text-sm text-gray-500">Sesión iniciada como:</p>
        <p class="font-semibold text-gray-700">{{ Auth::user()->name }}</p>
        <p class="text-xs text-blue-600 font-medium mt-1">{{ $userRole }}</p>
    </div>
    @endif
</aside>