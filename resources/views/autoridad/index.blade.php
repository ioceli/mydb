@extends('layouts.master')
@section('content')
@php
    use App\Enums\EstadoAutoridadEnum;
@endphp
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-extrabold mb-6 text-gray-800 border-b pb-2">
        Panel de Autorización 
    </h1>
    {{-- Mensaje de éxito --}}
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-sm" role="alert">
            <p class="font-bold">¡Éxito!</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif
    {{-- FORMULARIO DE FILTROS --}}
    <div class="bg-white p-6 rounded-xl shadow-lg mb-8 border border-blue-200">
        <h2 class="text-xl font-semibold mb-4 text-gray-700">1. Seleccionar Tipo y Filtros</h2>
        <form method="GET" action="{{ route('autoridad.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
            {{-- 1. Tipo --}}
            <div>
                <label for="tipo_autorizacion" class="block text-sm font-medium text-gray-700">¿Qué desea autorizar?</label>
                <select id="tipo_autorizacion" name="tipo_autorizacion" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 bg-blue-50 font-bold">
                    <option value="" disabled {{ !request('tipo_autorizacion') ? 'selected' : '' }}>-- Seleccione Tipo --</option>
                    @foreach(['planes', 'programas', 'proyectos'] as $type)
                        <option value="{{ $type }}" {{ request('tipo_autorizacion') == $type ? 'selected' : '' }}>
                            {{ ucfirst($type) }}
                        </option>
                    @endforeach
                </select>
            </div>
            {{-- 2. Filtro Subsector --}}
            <div>
                <label for="subsector" class="block text-sm font-medium text-gray-700">Filtrar por Subsector</label>
                <select id="subsector" name="subsector"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2">
                    <option value="">Todos los Subsectores</option>
                    @foreach($subsectores as $subsector)
                        <option value="{{ $subsector }}" {{ request('subsector') == $subsector ? 'selected' : '' }}>
                            {{ $subsector }}
                        </option>
                    @endforeach
                </select>
            </div>
            {{-- 3. Filtro Estado --}}
            <div>
                <label for="estado_autoridad" class="block text-sm font-medium text-gray-700">Filtrar por Estado</label>
                <select id="estado_autoridad" name="estado_autoridad"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2">
                    <option value="">Todos los Estados</option>
                    @foreach($estadosAutoridad as $estado)
                        @php $estadoValue = $estado instanceof \App\Enums\EstadoAutoridadEnum ? $estado->value : $estado; @endphp
                        <option value="{{ $estadoValue }}" {{ request('estado_autoridad') == $estadoValue ? 'selected' : '' }}>
                            {{ ucfirst($estadoValue) }}
                        </option>
                    @endforeach
                </select>
            </div>
            {{-- 4. Registros por página --}}
            <div>
                <label for="per_page" class="block text-sm font-medium text-gray-700">Registros por página</label>
                <select id="per_page" name="per_page"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2">
                    @foreach([10, 50, 100] as $num)
                        <option value="{{ $num }}" {{ request('per_page', $perPage) == $num ? 'selected' : '' }}>
                            {{ $num }}
                        </option>
                    @endforeach
                </select>
            </div>
            {{-- 5. Botones --}}
            <div class="flex space-x-2">
                <button type="submit"
                    class="w-full px-4 py-2 bg-blue-600 text-white rounded-md font-bold hover:bg-blue-700 transition duration-150 shadow-md">
                    <i class="fas fa-search mr-1"></i> Buscar
                </button>
                <a href="{{ route('autoridad.index') }}"
                    class="w-full px-4 py-2 bg-gray-300 text-gray-800 rounded-md font-bold hover:bg-gray-400 transition duration-150 text-center shadow-md">
                    <i class="fas fa-eraser mr-1"></i> Limpiar
                </a>
            </div>
        </form>
    </div>
    {{-- CONTENEDOR PRINCIPAL --}}
    <div class="flex flex-col gap-6">
        @php
            $dataCollections = [
                'planes' => $planes,
                'programas' => $programas,
                'proyectos' => $proyectos,
            ];
        @endphp
        @foreach ($dataCollections as $tipo => $items)
            @if (!empty($items) && request('tipo_autorizacion') === $tipo)
                <div class="mb-10 p-4 border rounded-xl shadow-lg bg-gray-50">
                    <h2 class="text-2xl font-bold mb-4 text-blue-800">
                        2. Resultados: {{ ucfirst($tipo) }}
                        <span class="text-gray-600 text-base font-normal">({{ $items->total() }} encontrados)</span>
                    </h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden border">
                            <thead class="bg-blue-600 text-white">
                                <tr>
                                    <th class="px-4 py-3 text-left">ID</th>
                                    <th class="px-4 py-3 text-left">Entidad</th>
                                    <th class="px-4 py-3 text-left">Subsector</th>
                                    <th class="px-4 py-3 text-left">Nombre</th>
                                    <th class="px-4 py-3 text-left">Estado Autoridad</th>
                                    <th class="px-4 py-3 text-center">Previsualizar</th>
                                    <th class="px-4 py-3 text-center">Actualizar Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    @php
                                        $primaryKey = $tipo === 'planes' ? 'idPlan' : ($tipo === 'programas' ? 'idPrograma' : 'idProyecto');
                                        $entidadCodigo = $item->entidad->codigo ?? '-'; 
                                        $entidadSubsector = $item->entidad->subSector ?? '-';
                                        $currentStatus = $item->estado_autoridad instanceof \App\Enums\EstadoAutoridadEnum
                                            ? $item->estado_autoridad->value
                                            : $item->estado_autoridad;
                                    @endphp
                                    <tr class="border-b hover:bg-blue-50 transition duration-100" id="item-{{ $tipo }}-{{ $item->$primaryKey }}">
                                        <td class="border p-3 font-semibold">{{ $item->$primaryKey }}</td>
                                        <td class="border p-3">{{ $entidadCodigo }}</td>
                                        <td class="border p-3">{{ $entidadSubsector }}</td>
                                        <td class="border p-3 max-w-xs truncate">{{ $item->nombre ?? '-' }}</td>
                                        <td class="border p-3">
                                            <span class="px-3 py-1 text-sm rounded-full font-bold
                                                {{ $currentStatus == 'Aprobado' ? 'bg-green-200 text-green-800' :
                                                    ($currentStatus == 'Devuelto' ? 'bg-red-200 text-red-800' : 'bg-yellow-200 text-yellow-800') }}">
                                                {{ ucfirst($currentStatus) }}
                                            </span>
                                        </td>
                                        {{-- BOTÓN DE DETALLE QUE ABRIRÁ EL MODAL --}}
                                            <td class="border p-3 text-center">
                                                <button 
                                                    type="button" 
                                                    onclick="showPreview('{{ $tipo }}', {{ $item->$primaryKey }}, '{{ $item->nombre ?? 'Documento sin nombre' }}')"
                                                    class="text-sm bg-indigo-500 text-white px-3 py-1 rounded hover:bg-indigo-600 transition duration-150 font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                                    <i class="fas fa-eye mr-1"></i> Previsualizar
                                                </button>
                                            </td>
                                        {{-- COLUMNA DE ACTUALIZAR ESTADO (MANTENER IGUAL) --}}
                                            <td class="border p-3 text-center">
                                                <form action="{{ route('autoridad.estado', ['tipo' => $tipo, 'id' => $item->$primaryKey]) }}" method="POST" class="flex flex-col items-center space-y-1">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="tipo_autorizacion" value="{{ request('tipo_autorizacion') }}">
                                                    <input type="hidden" name="subsector" value="{{ request('subsector') }}">
                                                    <input type="hidden" name="estado_autoridad_filtro" value="{{ request('estado_autoridad') }}">
                                                    <input type="hidden" name="page" value="{{ $items->currentPage() }}">
                                                    <input type="hidden" name="per_page" value="{{ request('per_page', $perPage) }}">
                                                    <select name="estado_autoridad" class="border rounded px-2 py-1 text-sm w-full focus:ring-blue-500">
                                                            @foreach($estadosAutoridad as $estadoUpdate)
                                                            @php $updateValue = $estadoUpdate instanceof \App\Enums\EstadoAutoridadEnum ? $estadoUpdate->value : $estadoUpdate; @endphp
                                                                <option value="{{ $updateValue }}" {{ $currentStatus == $updateValue ? 'selected' : '' }}>
                                                                    {{ ucfirst($updateValue) }}
                                                                </option>
                                                            @endforeach
                                                    </select>
                                                    <button type="submit"
                                                                class="w-full bg-green-500 text-white px-3 py-1 text-sm rounded hover:bg-green-600 font-semibold transition duration-150">
                                                                Guardar
                                                            </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{-- Paginación --}}
                        <div class="mt-6 flex justify-center">
                            {{ $items->appends(request()->query())->links() }}
                        </div>
                    </div>
                @endif
            @endforeach
            {{-- Mensaje inicial y VOLVER --}}
            @if (!request('tipo_autorizacion'))
                <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-6 rounded-lg shadow-md mt-8" role="alert">
                    <h3 class="font-bold text-lg mb-2"><i class="fas fa-info-circle mr-2"></i> Bienvenid@ al Módulo de Revisión</h3>
                    <p>Para empezar, <strong>seleccione un tipo de elemento</strong> (Plan, Programa o Proyecto) en el formulario de arriba y haga clic en <strong>Buscar</strong>. Los filtros de Subsector y Estado son opcionales.</p>
                </div>
            @endif
        </div>
    </div>
{{-- BOTÓN VOLVER --}}
<div class="p-4 bg-gray-100 mt-4 border-t">
    <a href="{{ route('dashboard.autoridad') }}" class="font-bold bg-gray-700 text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition duration-150 inline-flex items-center">
        <i class="fas fa-arrow-left mr-2"></i> VOLVER AL DASHBOARD
    </a>
</div>
{{-- MODAL PARA EL DETALLE DEL DOCUMENTO --}}
<div id="detail-modal" class="fixed inset-0 bg-gray-900 bg-opacity-75 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-hidden flex flex-col transform transition-all duration-300 scale-95" role="dialog" aria-modal="true" aria-labelledby="modal-title">
        {{-- Encabezado del Modal --}}
        <div class="p-5 border-b flex justify-between items-center bg-indigo-600 text-white">
            <h3 id="modal-title" class="text-xl font-bold flex items-center">
                <i class="fas fa-book-open mr-2"></i> 
                Detalle del Documento: <span id="modal-doc-title" class="ml-2 font-light"></span>
            </h3>
            <button type="button" onclick="closeModal()" class="text-white hover:text-gray-200 transition">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>
        {{-- Contenido del Modal (Scrollable) --}}
        <div class="p-6 overflow-y-auto flex-grow" id="modal-content-body">
            {{-- Contenido inyectado por JS --}}
        </div>
        {{-- Footer del Modal --}}
        <div class="p-4 border-t flex justify-end items-center bg-gray-50 space-x-3">
             <a id="download-pdf-btn" href="#" target="_blank" 
                    class="px-4 py-2 bg-red-600 text-white rounded-md font-bold hover:bg-red-700 transition duration-150 shadow-md inline-flex items-center">
                <i class="fas fa-file-pdf mr-2"></i> Descargar PDF
            </a>
            <button type="button" onclick="closeModal()" 
                    class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md font-bold hover:bg-gray-400 transition duration-150 shadow-md">
                Cerrar
            </button>
        </div>
    </div>
</div>

{{-- Íconos Font Awesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<script>
    const detailModal = document.getElementById('detail-modal');
    const modalContentBody = document.getElementById('modal-content-body');
    const modalDocTitle = document.getElementById('modal-doc-title');
    const downloadPdfBtn = document.getElementById('download-pdf-btn');
    let highlightedRow = null;
    // Función de formato de moneda (simplificada)
    const formatCurrency = (amount) => {
        // Asumiendo formato de USD, si el monto es un número
        if (typeof amount === 'number') {
             // toLocaleString para un formato más limpio y local
             return amount.toLocaleString('es-EC', { style: 'currency', currency: 'USD', minimumFractionDigits: 2 });
        }
        return amount || '-';
    };
    // Función para cerrar el modal
    function closeModal() {
        detailModal.classList.add('hidden');
        detailModal.classList.remove('flex');
    }
    // Evento para cerrar el modal al hacer clic fuera de él
    detailModal.addEventListener('click', (e) => {
        if (e.target === detailModal) {
            closeModal();
        }
    });
    function showPreview(tipo, id, nombre) {
        // 1. Mostrar título de carga
        modalDocTitle.textContent = nombre;
        modalContentBody.innerHTML = `
            <div class="flex flex-col items-center justify-center py-20">
                <i class="fas fa-spinner fa-spin text-4xl text-indigo-500 mb-4"></i>
                <p class="text-indigo-500">Cargando detalle de ${nombre}...</p>
            </div>`;
        // 2. Mostrar el modal
        detailModal.classList.remove('hidden');
        detailModal.classList.add('flex');
        // 3. Resaltar fila seleccionada (Opcional, pero bueno para UX)
        if (highlightedRow) {
            highlightedRow.classList.remove('bg-indigo-100', 'shadow-inner');
        }
        highlightedRow = document.getElementById(`item-${tipo}-${id}`);
        if (highlightedRow) {
            highlightedRow.classList.add('bg-indigo-100', 'shadow-inner');
        } 
        // 4. Petición AJAX (asumiendo que esta ruta devuelve el JSON con todos los datos)
        fetch(`{{ url('revision/detalle') }}/${tipo}/${id}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error al cargar el detalle: ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    renderDetail(data.data, data.tipo);
                    setupPdfDownload(data.data, data.tipo);
                } else {
                    modalContentBody.innerHTML = `<p class="text-red-500 p-4">Error: ${data.error || 'No se pudo obtener el detalle.'}</p>`;
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                modalContentBody.innerHTML = `<p class="text-red-500 p-4">Error al contactar el servidor. Revise la consola.</p>`;
            });
    }
    // 5. Renderizado del detalle DENTRO del modal - MODIFICADO para incluir TODOS los campos
    function renderDetail(item, tipo) {
        const primaryKey = tipo === 'planes' ? 'idPlan' : (tipo === 'programas' ? 'idPrograma' : 'idProyecto');
        const estadoRevision = item.estado_revision ? item.estado_revision.charAt(0).toUpperCase() + item.estado_revision.slice(1) : 'Pendiente';
        const estadoAutoridad = item.estado_autoridad ? item.estado_autoridad.charAt(0).toUpperCase() + item.estado_autoridad.slice(1) : 'N/A';
        // Helper para renderizar un campo (valor predeterminado a '-' si es nulo)
        const renderField = (label, value) => `
            <div>
                <p class="text-xs font-semibold uppercase text-gray-500">${label}</p>
                <p class="text-base text-gray-800 font-medium whitespace-pre-wrap">${value || '-'}</p>
            </div>
        `;
        // Helper para renderizar un campo de monto
        const renderMontoField = (label, amount) => `
            <div>
                <p class="text-xs font-semibold uppercase text-gray-500">${label}</p>
                <p class="text-base text-green-600 font-extrabold">${formatCurrency(amount)}</p>
            </div>
        `;
        // --- SECCIÓN DE COMPONENTES/ACTIVIDADES ---
        const componentesKey = tipo === 'programas' ? 'componentesPrograma' : (tipo === 'proyectos' ? 'componentesProyecto' : null);
        let componentesHtml = '';
        if (componentesKey && item[componentesKey] && item[componentesKey].length > 0) {
            // Renderizar Actividades anidadas
            const renderActividades = (actividades) => {
                if (!actividades || actividades.length === 0) return '';
                return `
                    <div class="mt-3 ml-4 border-l pl-4 space-y-2">
                        <h5 class="text-sm font-bold text-gray-700">Actividades:</h5>
                        ${actividades.map((act, idx) => `
                            <div class="p-2 border border-gray-200 rounded-md bg-gray-50 text-sm">
                                <p><span class="font-semibold text-gray-800">Actividad ${idx + 1}:</span> ${act.nombre || '-'}</p>
                                <p><span class="font-semibold text-gray-800">Monto:</span> <span class="text-green-600 font-bold">${formatCurrency(act.monto)}</span></p>
                            </div>
                        `).join('')}
                    </div>
                `;
            };
            // Renderizar Componentes
            componentesHtml = `
                <div class="p-5 border rounded-xl bg-white shadow-md">
                    <h3 class="font-bold text-xl text-gray-800 mb-4 border-b pb-2"><i class="fas fa-layer-group mr-2 text-indigo-500"></i> Componentes del ${tipo === 'programas' ? 'Programa' : 'Proyecto'} (${item[componentesKey].length})</h3>
                    <div class="space-y-4">
                        ${item[componentesKey].map((comp, index) => `
                            <div class="p-4 bg-indigo-50 rounded-lg shadow-inner border border-indigo-200">
                                <h4 class="font-extrabold text-lg text-indigo-700 mb-2">Componente ${index + 1}: ${comp.nombre || '-'}</h4>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
                                    ${renderMontoField('Monto del Componente', comp.monto)}
                                    ${renderField('Descripción', comp.descripcion)}
                                </div>
                                ${renderActividades(comp.actividadesPrograma || comp.actividadesProyecto)}
                            </div>
                        `).join('')}
                    </div>
                </div>
            `;
        }
        // --- ESTRUCTURA PRINCIPAL DEL MODAL ---
        let html = `
            <div class="space-y-8">
                {{-- 1. Información Clave y Estado --}}
                <div class="grid md:grid-cols-4 gap-4 p-4 bg-blue-50 rounded-xl border border-blue-200">
                    <div>
                        <p class="text-xs font-semibold uppercase text-blue-600">ID</p>
                        <p class="text-lg font-extrabold text-gray-900">${item[primaryKey]}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase text-blue-600">Entidad</p>
                        <p class="text-lg font-bold text-gray-800">${item.entidad?.codigo || '-'}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase text-blue-600">Subsector</p>
                        <p class="text-lg font-bold text-gray-800">${item.entidad?.subSector || '-'}</p>
                    </div>
                    <div class="flex flex-col">
                        <p class="text-xs font-semibold uppercase text-blue-600">Estado Autoridad</p>
                        <span class="font-extrabold text-lg px-2 py-0.5 rounded-full inline-block mt-1 self-start ${
                            estadoAutoridad === 'Aprobado' ? 'text-green-700 bg-green-100' : 
                            (estadoAutoridad === 'Devuelto' ? 'text-red-700 bg-red-100' : 'text-yellow-700 bg-yellow-100')
                        }">${estadoAutoridad}</span>
                    </div>
                </div>
                {{-- 2. Datos Generales --}}
                <div class="p-5 border rounded-xl bg-white shadow-md">
                    <h3 class="font-bold text-xl text-gray-800 mb-4 border-b pb-2"><i class="fas fa-info-circle mr-2 text-indigo-500"></i> Datos Generales del Documento</h3>
                    <div class="grid md:grid-cols-3 gap-6">
                        ${renderField('Nombre', item.nombre)}
                        ${renderField('CUP / Código', item.cup)}
                        ${renderField('Tipo de Dictamen', item.tipo_dictamen)}
                        ${renderField('Acción', item.accion)}
                        ${renderField('Objeto', item.objeto)}
                        ${renderField('Plazo de Ejecución', item.plazo_ejecucion)}
                        ${renderMontoField('Monto Total', item.monto_total)}
                        ${renderField('Estado Autoridad', estadoAutoridad)}
                    </div>
                </div>
                {{-- 3. Contexto y Ubicación --}}
                <div class="p-5 border rounded-xl bg-white shadow-md">
                    <h3 class="font-bold text-xl text-gray-800 mb-4 border-b pb-2"><i class="fas fa-map-marked-alt mr-2 text-indigo-500"></i> Contexto y Ubicación Geográfica</h3>
                    <div class="grid md:grid-cols-2 gap-6 mb-4">
                        ${renderField('Diagnóstico', item.diagnostico || 'N/A')}
                        ${renderField('Problema', item.problema || 'N/A')}
                    </div>
                    <div class="grid md:grid-cols-2 gap-6 pt-4 border-t border-gray-100">
                        ${renderField('Latitud', item.latitud)}
                        ${renderField('Longitud', item.longitud)}
                    </div>
                </div>
                {{-- 4. Componentes y Actividades (Solo para Programas/Proyectos) --}}
                ${componentesHtml}
                {{-- 5. Alineación Estratégica --}}
                <div class="p-5 border rounded-xl bg-white shadow-md">
                    <h3 class="font-bold text-xl text-gray-800 mb-4 border-b pb-2"><i class="fas fa-link mr-2 text-indigo-500"></i> Alineación Estratégica</h3>
                    <div>
                        <h4 class="font-semibold text-lg text-gray-700 mb-2">Objetivos Estratégicos (${item.objetivos_estrategicos ? item.objetivos_estrategicos.length : 0})</h4>
                        <ul class="list-disc list-outside ml-6 text-base space-y-1 text-gray-600">
                            ${(item.objetivos_estrategicos && item.objetivos_estrategicos.length > 0) ? 
                                item.objetivos_estrategicos.map(obj => `<li>${obj.descripcion || obj.nombre || 'Descripción no disponible'}</li>`).join('') 
                                : '<p class="text-gray-400 italic text-sm">Sin objetivos asociados.</p>'}
                        </ul>
                    </div>
                    <div class="mt-4 pt-4 border-t">
                        <h4 class="font-semibold text-lg text-gray-700 mb-2">Metas Estratégicas (${item.metas_estrategicas ? item.metas_estrategicas.length : 0})</h4>
                        <ul class="list-disc list-outside ml-6 text-base space-y-1 text-gray-600">
                            ${(item.metas_estrategicas && item.metas_estrategicas.length > 0) ? 
                                item.metas_estrategicas.map(meta => `<li>${meta.nombre || 'Nombre no disponible'}</li>`).join('') 
                                : '<p class="text-gray-400 italic text-sm">Sin metas asociadas.</p>'}
                        </ul>
                    </div>
                </div>
            </div>
        `;
        modalContentBody.innerHTML = html;
    }
    // 6. Configuración de la descarga de PDF
    function setupPdfDownload(item, tipo) {
        const primaryKey = tipo === 'planes' ? 'idPlan' : (tipo === 'programas' ? 'idPrograma' : 'idProyecto');
        const id = item[primaryKey];
        const downloadUrl = `{{ url('revision/pdf') }}/${tipo}/${id}`; 
        downloadPdfBtn.setAttribute('href', downloadUrl);
    }
</script>
@endsection