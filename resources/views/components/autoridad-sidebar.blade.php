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
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z" />
                </svg>
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