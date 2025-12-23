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

                    <div x-data="{ open: {{ $parentActive ? 'true' : 'false' }} }" class="border border-transparent rounded-lg ">
                        {{-- Botón para expandir/colapsar --}}
                        <button @click="open = !open"
                                class="w-full flex items-center justify-between p-3 text-blue-700 font-medium rounded-lg hover:bg-blue-50 transition duration-150 ease-in-out
                                       {{ $parentActive ? 'bg-blue-50 border-blue-300' : '' }}">
                            <div class="flex items-center">
                                {{-- Icono padre (si no hay icono específico, se mantiene el svg por defecto) --}}
                                @if(!empty($menu['icon']))
                                    {{-- Aquí se mapea iconos según nombre --}}
                                    <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                    </svg>
                                @endif
                                <span class="text-left">{{ $menu['label'] }}</span>
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
            
            {{-- Icono hijo según su nombre --}}
            @if(!empty($child['icon']))
                @switch($child['icon'])
                    @case('earth-americas')
                        <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        @break

                    @case('flag')
                        <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"/>
                        </svg>
                        @break

                    @case('bullseye')
                        <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        @break

                    @case('chart-line')
                        <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
                        </svg>
                        @break

                    @case('chart-bar')
                        <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        @break

                    @case('chart-pie')
                        <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/>
                        </svg>
                        @break
                        @case('file-alt')
                        <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        @break
                        @case('folder-open')
                        <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                        </svg>
                        </svg>
                        @break
                        @case('project-diagram')
                        <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        @break
                    @default
                        {{-- Icono por defecto si no hay match --}}
                        <svg class="w-5 h-5 mr-3 text-blue-500 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14" />
                        </svg>
                @endswitch
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
                        <svg class="mr-3" width="24" height="27" viewBox="0 0 24 27" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M22.8962 19.6857C22.9937 18.9422 22.9937 18.1828 22.8962 17.4393L23.8638 16.6535C23.9763 16.5639 24.025 16.3793 23.9875 16.2053C23.7363 15.0662 23.305 14.0326 22.7424 13.1783C22.6561 13.0465 22.5174 13.0148 22.4049 13.1045L21.4373 13.8902C21.0285 13.3998 20.5597 13.0201 20.0534 12.767V11.1955C20.0534 11.0162 19.9634 10.858 19.8396 10.8211C19.0033 10.5574 18.1519 10.568 17.3568 10.8211C17.2331 10.858 17.1431 11.0162 17.1431 11.1955V12.767C16.6368 13.0201 16.168 13.3998 15.7592 13.8902L14.7916 13.1045C14.6828 13.0148 14.5403 13.0465 14.454 13.1783C13.8915 14.0326 13.4602 15.0662 13.2089 16.2053C13.1714 16.3793 13.2239 16.5639 13.3327 16.6535L14.3003 17.4393C14.2027 18.1828 14.2027 18.9422 14.3003 19.6857L13.3327 20.4715C13.2201 20.5611 13.1714 20.7457 13.2089 20.9197C13.4602 22.0588 13.8915 23.0871 14.454 23.9467C14.5403 24.0785 14.679 24.1102 14.7916 24.0205L15.7592 23.2348C16.168 23.7252 16.6368 24.1049 17.1431 24.358V25.9295C17.1431 26.1088 17.2331 26.267 17.3568 26.3039C18.1932 26.5676 19.0445 26.557 19.8396 26.3039C19.9634 26.267 20.0534 26.1088 20.0534 25.9295V24.358C20.5597 24.1049 21.0285 23.7252 21.4373 23.2348L22.4049 24.0205C22.5136 24.1102 22.6561 24.0785 22.7424 23.9467C23.305 23.0924 23.7363 22.0588 23.9875 20.9197C24.025 20.7457 23.9725 20.5611 23.8638 20.4715L22.8962 19.6857ZM18.602 21.1201C17.5969 21.1201 16.783 19.9705 16.783 18.5625C16.783 17.1545 17.6006 16.0049 18.602 16.0049C19.6033 16.0049 20.4209 17.1545 20.4209 18.5625C20.4209 19.9705 19.6071 21.1201 18.602 21.1201ZM8.40089 13.5C11.0524 13.5 13.2014 10.4783 13.2014 6.75C13.2014 3.02168 11.0524 0 8.40089 0C5.74936 0 3.60038 3.02168 3.60038 6.75C3.60038 10.4783 5.74936 13.5 8.40089 13.5ZM15.9467 25.4443C15.8604 25.3811 15.7742 25.3072 15.6917 25.2387L15.3954 25.4813C15.1703 25.6605 14.9153 25.7607 14.6603 25.7607C14.2515 25.7607 13.8577 25.5182 13.5764 25.0963C12.8901 24.0521 12.3651 22.7812 12.0688 21.426C11.8625 20.4926 12.14 19.5064 12.7401 19.016L13.0364 18.7734C13.0326 18.6363 13.0326 18.4992 13.0364 18.3621L12.7401 18.1195C12.14 17.6344 11.8625 16.643 12.0688 15.7096C12.1025 15.5566 12.1513 15.4037 12.1888 15.2508C12.0463 15.235 11.9075 15.1875 11.7612 15.1875H11.1349C10.3023 15.7254 9.37599 16.0312 8.40089 16.0312C7.42578 16.0312 6.50319 15.7254 5.66685 15.1875H5.04053C2.25774 15.1875 0 18.3621 0 22.275V24.4688C0 25.8662 0.806335 27 1.80019 27H15.0016C15.3804 27 15.7329 26.8313 16.0217 26.5518C15.9767 26.3514 15.9467 26.1457 15.9467 25.9295V25.4443Z" fill="#1D4ED8"/>
</svg>


                        @elseif(isset($menu['icon']) && $menu['icon'] == 'building')
                        <svg class="mr-3" width="24" height="27" viewBox="0 0 24 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M24 2.7C24 1.98392 23.6839 1.29716 23.1213 0.790812C22.5587 0.284463 21.7956 0 21 0H9L0 8.1V24.3C0 25.0161 0.31607 25.7028 0.87868 26.2092C1.44129 26.7155 2.20435 27 3 27H21C21.7956 27 22.5587 26.7155 23.1213 26.2092C23.6839 25.7028 24 25.0161 24 24.3V2.7ZM7.5 22.95H4.5V20.25H7.5V22.95ZM19.5 22.95H16.5V20.25H19.5V22.95ZM7.5 17.55H4.5V12.15H7.5V17.55ZM13.5 22.95H10.5V17.55H13.5V22.95ZM13.5 14.85H10.5V12.15H13.5V14.85ZM19.5 17.55H16.5V12.15H19.5V17.55Z" fill="#1D4ED8"/>
                        </svg>
                        @elseif(isset($menu['icon']) && $menu['icon'] == 'userss')
                        <svg class="mr-3" width="24" height="27" viewBox="0 0 24 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5.14286 6.75C5.14286 8.54021 5.8653 10.2571 7.15127 11.523C8.43723 12.7888 10.1814 13.5 12 13.5C13.8186 13.5 15.5628 12.7888 16.8487 11.523C18.1347 10.2571 18.8571 8.54021 18.8571 6.75C18.8571 4.95979 18.1347 3.2429 16.8487 1.97703C15.5628 0.711159 13.8186 0 12 0C10.1814 0 8.43723 0.711159 7.15127 1.97703C5.8653 3.2429 5.14286 4.95979 5.14286 6.75ZM10.2054 17.3074L11.2018 18.9422L9.41786 25.476L7.48929 17.7293C7.38214 17.3021 6.96429 17.0227 6.53036 17.1334C2.78036 18.0562 0 21.3996 0 25.3811C0 26.2775 0.739286 27 1.64464 27H22.3554C23.2661 27 24 26.2723 24 25.3811C24 21.3996 21.2196 18.0562 17.4696 17.1334C17.0357 17.0279 16.6179 17.3074 16.5107 17.7293L14.5821 25.476L12.7982 18.9422L13.7946 17.3074C14.1375 16.7432 13.725 16.0312 13.0607 16.0312H10.9446C10.2804 16.0312 9.86786 16.7484 10.2107 17.3074H10.2054Z" fill="#1D4ED8"/>
                        </svg>

                        @elseif(isset($menu['icon']) && $menu['icon'] == 'usersss')
                        <svg class="mr-3" width="48" height="49" viewBox="0 0 48 49" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18.3175 0C16.6229 0 15.1353 0.91875 14.0849 2.10496C13.0345 3.29321 12.2781 4.7775 11.6068 6.38021C10.5796 8.85063 9.84645 11.5967 9.18873 14.1651C7.0879 14.8103 5.30432 15.6147 3.86894 16.5885C2.19175 17.7298 0.785395 19.308 0.785395 21.4375C0.785395 23.2873 1.85903 24.7715 3.20348 25.8393C4.35256 26.7499 5.76472 27.5074 7.4361 28.1362C7.53283 28.6058 7.67791 29.0856 7.85782 29.5409C6.22706 30.5127 3.64067 32.3951 1.14908 35.9844L0 37.7075L1.63269 38.9183L7.97775 43.512L5.38169 49H42.6202L40.0203 43.512L46.3692 38.9183L48 37.7075L46.8529 35.9844C44.3574 32.3951 41.7749 30.5127 40.1402 29.5409C40.322 29.0872 40.4644 28.617 40.5658 28.1362C42.2353 27.5074 43.6474 26.7479 44.7965 25.8393C46.141 24.7715 47.2146 23.2873 47.2146 21.4375C47.2146 19.308 45.8082 17.7298 44.1311 16.5885C42.6957 15.6147 40.9121 14.8103 38.8113 14.163C38.0858 11.5007 37.285 8.70975 36.2732 6.25363C35.6155 4.66521 34.8901 3.20542 33.8552 2.04167C32.8202 0.877917 31.3461 0 29.6825 0C28.5566 0 27.7035 0.326667 26.7808 0.573709C25.86 0.82075 24.9295 1.02083 24.001 1.02083C22.1439 1.02083 20.5847 0 18.3175 0ZM18.3175 4.08333C18.7179 4.08333 21.0973 5.10417 23.999 5.10417C25.4499 5.10417 26.7421 4.79383 27.748 4.53046C28.752 4.26504 29.5161 4.08333 29.6825 4.08333C30.1274 4.08333 30.4602 4.23442 31.0115 4.84896C31.5628 5.46146 32.2128 6.57213 32.7641 7.91146C33.8145 10.4472 34.6154 13.9099 35.4859 17.099C35.4859 17.0908 35.5904 17.003 35.3041 17.1623C34.8205 17.442 33.8068 17.8013 32.5823 17.9912C30.1274 18.3832 26.7789 18.375 23.999 18.375C21.2327 18.375 17.8784 18.3342 15.4139 17.9279C14.1835 17.7298 13.1853 17.3766 12.694 17.099C12.5431 17.0112 12.4909 17.0438 12.4522 17.0357V16.9724C12.4599 16.956 12.4444 16.9234 12.4522 16.907L12.5122 16.8438C12.6575 16.5694 12.7409 16.2634 12.7559 15.9495V15.8882C13.4504 13.1749 14.228 10.3043 15.174 8.03804C15.7388 6.67625 16.3521 5.56763 16.9266 4.91429C17.5011 4.26096 17.8938 4.08333 18.3175 4.08333ZM8.88502 18.5669C9.32415 19.5245 10.096 20.2901 10.8814 20.7352C12.0614 21.3967 13.4117 21.709 14.8703 21.9479C17.7875 22.4257 21.2037 22.4583 23.999 22.4583C26.7808 22.4583 30.2029 22.4747 33.1278 22.0112C34.5941 21.7805 35.9308 21.4783 37.1167 20.7985C37.9098 20.3452 38.6817 19.5388 39.113 18.5669C40.3066 19.014 41.3106 19.4918 42.0147 19.9695C43.1406 20.7352 43.3437 21.3028 43.3437 21.4375C43.3437 21.558 43.247 21.9479 42.4365 22.587C41.6279 23.224 40.2389 23.9651 38.4476 24.5633C34.8649 25.7679 29.7115 26.5417 23.999 26.5417C18.2865 26.5417 13.1331 25.7679 9.55048 24.5633C7.75916 23.9651 6.37021 23.224 5.5616 22.587C4.75106 21.9479 4.65433 21.558 4.65433 21.4375C4.65433 21.3028 4.80522 20.7923 5.92335 20.0328C6.62749 19.5551 7.6605 19.0365 8.88502 18.5669ZM13.903 29.7328C14.5375 29.843 15.1662 30.0268 15.8375 30.1146C16.089 31.9092 17.4102 33.4874 19.5246 33.6242C21.1573 33.7263 22.9931 32.9137 23.1537 30.625H24.8463C25.005 32.9137 26.8388 33.7283 28.4735 33.6242C30.5878 33.4874 31.911 31.9092 32.1606 30.1146C32.8318 30.0268 33.4605 29.843 34.095 29.7308L33.9132 31.0068C33.3154 34.3653 31.8955 37.4748 30.1042 39.6226C28.3129 41.7643 26.214 42.9056 23.999 42.875C21.7241 42.8423 19.6697 41.6868 17.8938 39.5573C16.118 37.4278 14.7213 34.3817 14.0849 31.0068L13.903 29.7328ZM37.5403 32.6667C38.258 33.1138 40.148 34.4225 42.3165 36.9419L36.4512 41.2151L35.0623 42.1747L35.7877 43.7672L36.3313 44.9167H30.2261C31.254 44.1728 32.1881 43.2939 33.0059 42.3013C35.1377 39.7492 36.5653 36.407 37.3585 32.7933C37.4262 32.7545 37.4804 32.7075 37.5403 32.6667ZM10.3978 32.73C10.4732 32.779 10.5641 32.8116 10.6396 32.8586C11.4714 36.4233 12.8913 39.7247 14.9921 42.236C15.8607 43.2813 16.8724 44.1755 17.9538 44.9167H11.6668L12.2104 43.7672L12.9358 42.1747L11.5449 41.2151L5.68347 36.9419C7.73014 34.5573 9.5969 33.2404 10.3978 32.73Z" fill="#1D4ED8"/>
                        </svg>
                        @elseif(isset($menu['icon']) && $menu['icon'] == 'audit')
                        <svg class="mr-3" width="24" height="27" viewBox="0 0 24 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12.8895 26.3119L12.873 26.3143L12.7665 26.3577L12.7365 26.3626L12.7155 26.3577L12.609 26.3143C12.593 26.3102 12.581 26.3123 12.573 26.3205L12.567 26.3329L12.5415 26.8627L12.549 26.8874L12.564 26.9035L12.72 26.9951L12.7425 27.0001L12.7605 26.9951L12.9165 26.9035L12.9345 26.8837L12.9405 26.8627L12.915 26.3341C12.911 26.3209 12.9025 26.3135 12.8895 26.3119ZM13.287 26.172L13.2675 26.1745L12.99 26.2896L12.975 26.302L12.9705 26.3156L12.9975 26.8478L13.005 26.8627L13.017 26.8713L13.3185 26.9864C13.3375 26.9906 13.352 26.9873 13.362 26.9765L13.368 26.9592L13.317 26.1992C13.312 26.1844 13.302 26.1753 13.287 26.172ZM12.2145 26.1745C12.2079 26.1712 12.2 26.1701 12.1924 26.1715C12.1849 26.1729 12.1783 26.1766 12.174 26.1819L12.165 26.1992L12.114 26.9592C12.115 26.9741 12.1235 26.984 12.1395 26.9889L12.162 26.9864L12.4635 26.8713L12.4785 26.8614L12.4845 26.8478L12.51 26.3156L12.5055 26.3007L12.4905 26.2884L12.2145 26.1745Z" fill="#1D4ED8"/>
                        <path d="M12 0V8.04531C12 8.53772 12.2371 9.00996 12.659 9.35814C13.081 9.70632 13.6533 9.90193 14.25 9.90193H24V22.2793C24 22.9359 23.6839 23.5655 23.1213 24.0298C22.5587 24.494 21.7956 24.7548 21 24.7548H3C2.20435 24.7548 1.44129 24.494 0.87868 24.0298C0.31607 23.5655 0 22.9359 0 22.2793V2.47548C0 1.81894 0.31607 1.18929 0.87868 0.725052C1.44129 0.260809 2.20435 0 3 0H12ZM12 12.3774C11.3248 12.3778 10.6584 12.5035 10.0501 12.7453C9.44186 12.987 8.90731 13.3387 8.4861 13.7741C8.06488 14.2095 7.7678 14.7175 7.61686 15.2605C7.46592 15.8035 7.465 16.3676 7.61416 16.911C7.76333 17.4543 8.05875 17.963 8.47854 18.3994C8.89833 18.8357 9.43173 19.1885 10.0392 19.4316C10.6467 19.6748 11.3127 19.802 11.9879 19.8038C12.663 19.8057 13.3301 19.6822 13.9395 19.4424L15 20.3163C15.2829 20.5417 15.6618 20.6665 16.0551 20.6637C16.4484 20.6609 16.8246 20.5307 17.1027 20.3012C17.3808 20.0717 17.5386 19.7613 17.542 19.4367C17.5454 19.1122 17.3942 18.7996 17.121 18.5661L16.062 17.691C16.3897 17.1249 16.5382 16.4995 16.4937 15.8732C16.4492 15.247 16.2131 14.6402 15.8075 14.1096C15.4018 13.5789 14.8399 13.1418 14.1741 12.8389C13.5083 12.536 12.7603 12.3772 12 12.3774ZM12 14.8529C12.3978 14.8529 12.7794 14.9833 13.0607 15.2154C13.342 15.4475 13.5 15.7624 13.5 16.0906C13.5 16.4189 13.342 16.7337 13.0607 16.9658C12.7794 17.198 12.3978 17.3284 12 17.3284C11.6022 17.3284 11.2206 17.198 10.9393 16.9658C10.658 16.7337 10.5 16.4189 10.5 16.0906C10.5 15.7624 10.658 15.4475 10.9393 15.2154C11.2206 14.9833 11.6022 14.8529 12 14.8529ZM15 0.0532228C15.5683 0.152682 16.0894 0.386165 16.5 0.725316L23.121 6.1887C23.532 6.5275 23.815 6.95749 23.9355 7.42644H15V0.0532228Z" fill="#1D4ED8"/>
                        </svg>

                        @elseif($menu['icon'] == 'file-alt')
                        <svg class="w-5 h-5 mr-3 text-blue-500 group-hover:text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path d="M4 2a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V7.414A2 2 0 0016.414 6L12 1.586A2 2 0 0010.586 1H4zm8 2.5V6a1 1 0 001 1h2.5L12 4.5zM5 9h10v2H5V9zm0 4h10v2H5v-2z"/></svg>
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