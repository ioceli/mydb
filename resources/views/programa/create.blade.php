@extends('layouts.master')
@section('title','Nuevo Programa')
@section('content')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@if ($errors->any())
<div class="bg-red-100 text-red-700 p-4 rounded mb-4">
    <ul class="list-disc pl-5">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<h2 class="text-xl font-bold mb-4">Registrar nuevo Programa</h2>

<div class="max-w-5xl mx-auto bg-white p-6 rounded shadow">
    <form action="{{ route('programa.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Tabs -->
        <div>
            <ul class="flex flex-wrap border-b mb-4 font-bold"  id="tabs">
                @php $tabs = ['Datos Iniciales', 'Diagnóstico', 'Articulación', 'Financiamiento y Presupuesto','Cronograma']; @endphp
                @foreach($tabs as $i => $tab)
                <li>
                    <button type="button" class="px-4 py-2 text-sm font-semibold border-b-2 tab-button {{ $i === 0 ? 'border-blue-500' : 'border-transparent' }}" data-tab="tab{{ $i }}">{{ $tab }}</button>
                </li>
                @endforeach
            </ul>
        </div>

        <!-- Tab Contents -->
        <div id="tabContents">
            <!-- Tab 0: DATOS INICIALES -->
            <div class="tab-content" id="tab0">
                <div class="mb-4">
                    <label for="tipo_dictamen" class="block text-sm font-bold text-gray-700">1.1 Tipo de solicitud de dictamen</label>
                    <select name="tipo_dictamen" id="tipo_dictamen" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">-- Seleccione una opción --</option>
                        <option value="prioridad">Dictamen de prioridad</option>
                        <option value="aprobacion">Dictamen de aprobación</option>
                        <option value="actualizacion_prioridad">Actualización de prioridad</option>
                        <option value="actualizacion_aprobacion">Actualización de aprobación</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="accion" class="block text-sm font-bold text-gray-700">1.2 ¿Qué se va a hacer?</label>
                    <select name="accion" id="accion" class="w-full border rounded p-2" required>
                        <option value="">Seleccione una acción</option>
                            @foreach(['adquisición', 'construcción', 'adecuación', 'ampliación', 'dotación', 'habilitación', 'instalación', 'mejoramiento', 'implementación', 'recuperación', 'rehabilitación', 'renovación', 'reparación', 'reposicion', 'investigación', 'generación de información', 'saneamiento'] as $accion)
                                <option value="{{ $accion }}">{{ ucfirst($accion) }}</option>
                            @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="objeto" class="block text-sm font-bold text-gray-700">1.3 ¿Sobre qué se va a hacer?</label>
                    <input type="text" name="objeto" id="objeto" class="w-full border rounded p-2" placeholder="Ej: carretera, hospital, unidad educativa" required>
                </div>       
                <div class="mb-4">
                    <label class="font-bold">1.4 Subsector</label>
                    <select name="idEntidad" class="w-full border rounded p-2" required>
                        @foreach ($entidad as $e)
                            <option value="{{ $e->idEntidad }}">{{ $e->subSector }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="font-bold">1.5 Plazo de ejecución</label>
                    <input type="text" name="plazo_ejecucion" class="w-full border rounded p-2" required>
                </div>
                <div class="mb-4">
                    <label class="font-bold">1.6 Monto total</label>
                    <input type="text" name="monto_total" class="w-full border rounded p-2" required>
                </div>
            </div>
            <!-- Tab 1: DIAGNÓSTICO -->
            <div class="tab-content hidden" id="tab1">
                <label class="font-bold block mb-2">2.1 Descripción de la situación actual del sector</label>
                <textarea name="diagnostico" class="w-full border rounded p-2" rows="5"></textarea>
                <div class="mb-4">
                    <label class="font-bold block mb-2">2.2 Identificación, descripción y diagnóstico del problema</label>
                    <textarea name="problema" class="w-full border rounded p-2" rows="5"></textarea>
                </div>
                <div class="mb-4">
                    <label class="font-bold block mb-2">2.3 Ubicación geográfica e impacto territorial</label>
                    <div id="map" style="height: 400px;" class="rounded shadow border"></div>
                    <input type="text" name="latitud" id="latitud">
                    <input type="text" name="longitud" id="longitud">
                </div>
            </div>

            <!-- Tab 2: ARTICULACIÓN CON PLANIFICACIÓN -->
            <div class="tab-content hidden" id="tab2">
                <label class="font-bold block mb-2">Articulación con Planificación</label>
                <div class="mb-4">
                    <label class="font-bold">Objetivos Estratégicos</label>
                    <div class="grid grid-cols-1 gap-2">
                        @foreach($objetivoEstrategico as $objetivo)
                            <label class="inline-flex items-center space-x-2">
                                <input type="checkbox" name="idObjetivoEstrategico[]" value="{{ $objetivo->idObjetivoEstrategico }}" class="form-checkbox text-blue-600">
                                <span>{{ $objetivo->descripcion }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                <div class="mb-4">
                    <label class="font-bold">Alineación con Metas Estratégicas</label>
                    <div class="grid grid-cols-1 gap-2">
                        @foreach($metasEstrategicas as $meta)
                            <label class="inline-flex items-center space-x-2">
                                <input type="checkbox" name="idMetaEstrategica[]" value="{{ $meta->idMetaEstrategica }}" class="form-checkbox text-blue-600">
                                <span>{{ $meta->descripcion }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- Tab 3: FINANCIAMIENTO Y PRESUPUESTO -->
            <div class="tab-content hidden" id="tab3">
    <label class="font-bold block mb-2">Presupuesto por Componentes</label>
    <div id="componentesContainer" class="space-y-4">
        <div class="componente border p-4 rounded shadow">
            <div class="mb-2">
                <label class="block text-sm font-bold">Nombre del Componente</label>
                <input type="text" name="componentes[0][nombre]" class="w-full border rounded p-2" required>
            </div>
            <div class="mb-2">
                <label class="block text-sm font-bold">Descripción</label>
                <textarea name="componentes[0][descripcion]" class="w-full border rounded p-2" rows="3"></textarea>
            </div>
            <div class="mb-2">
                <label class="block text-sm font-bold">Monto asignado</label>
                <input type="number" step="0.01" name="componentes[0][monto]" class="w-full border rounded p-2" required>
            </div>
        </div>
    </div>
    <button type="button" id="addComponente" class="mt-2 px-3 py-1 bg-blue-600 text-white rounded">Agregar Componente</button>
</div>
            <!-- Tab 4: Cronograma -->
                <div class="tab-content hidden" id="tab4">
                    <label class="font-bold block mb-2">Cronograma General</label>
                        <textarea name="cronograma" class="w-full border rounded p-2" rows="5" placeholder="Ejemplo: Actividad - Fecha inicio - Fecha fin"></textarea>
                </div>

        </div>

        <!-- Botones -->
        <div class="flex justify-between pt-6">
            <button type="submit" class="btn btn-success font-bold">Guardar</button>
            <a href="{{ route('programa.index') }}" class="btn btn-secondary font-bold text-white">Volver</a>
        </div>
    </form>
</div>

<!-- Scripts -->
<script>
    const buttons = document.querySelectorAll('.tab-button');
    const contents = document.querySelectorAll('.tab-content');

    buttons.forEach((btn, i) => {
        btn.addEventListener('click', () => {
            buttons.forEach(b => b.classList.remove('border-blue-500'));
            contents.forEach(c => c.classList.add('hidden'));

            btn.classList.add('border-blue-500');
            document.getElementById('tab' + i).classList.remove('hidden');
        });
    });

    function actualizarNombre() {
        const accion = document.getElementById('accion').value.trim();
        const objeto = document.getElementById('objeto').value.trim();

        if (accion && objeto) {
            const nombre = `${accion.charAt(0).toUpperCase() + accion.slice(1)} de ${objeto}`;
            document.getElementById('nombre').value = nombre;
        }
    }

    document.getElementById('accion').addEventListener('change', actualizarNombre);
    document.getElementById('objeto').addEventListener('input', actualizarNombre);

    // Inicializar mapa Leaflet
    const map = L.map('map').setView([-17.7833, -63.1833], 5); // Coordenadas de Bolivia
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(map);

    // Manejar clic en el mapa
    map.on('click', function(e) {
        const lat = e.latlng.lat;
        const lng = e.latlng.lng;
        document.getElementById('latitud').value = lat;
        document.getElementById('longitud').value = lng;
    });
    // Manejar cambio de ubicación
    map.on('locationfound', function(e) {   
        const lat = e.latitude;
        const lng = e.longitude;
        document.getElementById('latitud').value = lat;
        document.getElementById('longitud').value = lng;
    });
    map.locate({setView: true, maxZoom: 16});

    // Manejar ubicación encontrada
    map.on('locationfound', function(e) {
        const lat = e.latitude;
        const lng = e.longitude;
        document.getElementById('latitud').value = lat;
        document.getElementById('longitud').value = lng;
    });
    map.locate({setView: true, maxZoom: 16});

    //AGREGAR COMPONENTES
      let componenteIndex = 1;
    document.getElementById('addComponente').addEventListener('click', () => {
        const container = document.getElementById('componentesContainer');
        const nuevo = document.createElement('div');
        nuevo.classList.add('componente', 'border', 'p-4', 'rounded', 'shadow');
        nuevo.innerHTML = `
            <div class="mb-2">
                <label class="block text-sm font-bold">Nombre del Componente</label>
                <input type="text" name="componentes[${componenteIndex}][nombre]" class="w-full border rounded p-2" required>
            </div>
            <div class="mb-2">
                <label class="block text-sm font-bold">Descripción</label>
                <textarea name="componentes[${componenteIndex}][descripcion]" class="w-full border rounded p-2" rows="3"></textarea>
            </div>
            <div class="mb-2">
                <label class="block text-sm font-bold">Monto asignado</label>
                <input type="number" step="0.01" name="componentes[${componenteIndex}][monto]" class="w-full border rounded p-2" required>
            </div>
        `;
        container.appendChild(nuevo);
        componenteIndex++;
    });
</script>
@endsection