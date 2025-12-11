{{-- Acceso a las propiedades del componente con $title, $userRole, etc. --}}
<aside {{ $attributes->merge(['class' => 'w-64 bg-blue-100 p-6 shadow-xl border-r border-gray-200']) }}>
    
    {{-- Título dinámico --}}
    <h3 class="text-xl font-extrabold text-blue-800 mb-6 border-b pb-2">
        {{ $title }}
    </h3>
    
    {{-- Menús dinámicos --}}
    <div class="mb-8">
        <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">
            Gestión del Sistema
        </p>
        <nav class="space-y-2">
            @foreach($menus as $menu)
            <a href="{{ route($menu['route']) }}" 
               class="flex items-center p-3 text-blue-700 font-medium rounded-lg hover:bg-blue-50 transition duration-150 ease-in-out border border-transparent hover:border-blue-300 group
                      {{ $menu['active'] ? 'bg-blue-50 border-blue-300' : '' }}">
                
                {{-- Iconos dinámicos --}}
                @if($menu['icon'] == 'users')
                <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                @elseif($menu['icon'] == 'building')
                <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                @else
                <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
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