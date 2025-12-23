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
                {{-- Si el menú tiene children, renderizamos un panel colapsable --}}
                @if(isset($menu['children']) && is_array($menu['children']))
                    @php
                        // Determinar si alguno de los hijos está activo para marcar el padre
                        $parentActive = false;
                        foreach ($menu['children'] as $child) {
                            if (!empty($child['active'])) { $parentActive = true; break;}
                        }
                        // Generar un identificador único para controlar el estado con Alpine
                        $panelId = 'panel-' . md5($menu['label']);
                    @endphp

                    <div x-data="{ open: {{ $parentActive ? 'true' : 'false' }} }" class="border border-transparent rounded-lg">
                        <button @click="open = !open"
                                class="w-full flex items-center justify-between p-3 text-blue-700 font-medium rounded-lg hover:bg-blue-50 transition duration-150 ease-in-out
                                       {{ $parentActive ? 'bg-blue-50 border-blue-300' : '' }}">
                            <div class="flex items-center">
                                {{-- Icono padre (si no hay icono específico, se mantiene el svg por defecto) --}}
                                @if(!empty($menu['icon']))
                                    {{-- Aquí podrías mapear iconos según nombre --}}
                                    <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                    </svg>
                                @endif
                                <span>{{ $menu['label'] }}</span>
                            </div>

                            <svg x-bind:class="{ 'transform rotate-90': open }" class="w-4 h-4 text-gray-500 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>

                        {{-- Submenú --}}
                        <div x-show="open" x-collapse class="mt-2 space-y-1 ps-6">
                            @foreach($menu['children'] as $child)
                                <a href="{{ route($child['route']) }}"
                                   class="flex items-center p-2 text-sm text-blue-700 rounded-md hover:bg-blue-50 transition duration-150 ease-in-out border border-transparent hover:border-blue-200
                                          {{ !empty($child['active']) ? 'bg-blue-50 border-blue-300 font-semibold' : '' }}">
                                    {{-- icono hijo opcional --}}
                                    @if(!empty($child['icon']))
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14" />
                                    </svg>
                                    @endif
                                    <span>{{ $child['label'] }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                @else
                    {{-- Menú normal (sin children) --}}
                    <a href="{{ route($menu['route']) }}" 
                       class="flex items-center p-3 text-blue-700 font-medium rounded-lg hover:bg-blue-50 transition duration-150 ease-in-out border border-transparent hover:border-blue-300 group
                              {{ !empty($menu['active']) ? 'bg-blue-50 border-blue-300' : '' }}">
                        
                        {{-- Iconos dinámicos --}}
                        @if(isset($menu['icon']) && $menu['icon'] == 'users')
                        <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5 0a9 9 0 11-18 0 9 9"/>
                        </svg>
                        @elseif(isset($menu['icon']) && $menu['icon'] == 'building')
                        <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1"/>
                        </svg>
                        @else
                        <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"/>
                        </svg>
                        @endif
                        
                        <span>{{ $menu['label'] }}</span>
                    </a>
                @endif
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