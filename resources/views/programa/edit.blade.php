@extends('layouts.master')
@section('title', 'Editar Programa')
@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
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

<h2 class="text-xl font-bold mb-4">Editar Programa: {{ $programas->nombre }}</h2>
<div class="max-w-5xl mx-auto bg-white p-6 rounded shadow">
    <form action="{{ route('programa.update', $programas->idPrograma) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        <div>
            @php $tabs = ['Datos Iniciales', 'Diagnóstico', 'Alineación', 'Financiamiento y Presupuesto','Cronograma']; @endphp
            <ul class="flex flex-wrap border-b mb-4 font-bold" id="tabs">
                @foreach($tabs as $i => $tab)
                <li>
                    <button type="button" class="px-4 py-2 text-sm font-semibold border-b-2 tab-button {{ $i === 0 ? 'border-blue-500 text-blue-500' : 'border-transparent text-gray-600' }}" data-tab="tab{{ $i }}">{{ $tab }}</button>
                </li>
                @endforeach
            </ul>
        </div>

        <div id="tabContents">
            <div class="tab-content" id="tab0">
                <div class="mb-4">
                    <label for="tipo_dictamen" class="block text-sm font-bold text-gray-700">1.1 Tipo de solicitud de dictamen</label>
                    <select name="tipo_dictamen" id="tipo_dictamen" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">-- Seleccione una opción --</option>
                        <option value="prioridad" @if($programas->tipo_dictamen == 'prioridad') selected @endif>Dictamen de prioridad</option>
                        <option value="aprobacion" @if($programas->tipo_dictamen == 'aprobacion') selected @endif>Dictamen de aprobación</option>
                        <option value="actualizacion_prioridad" @if($programas->tipo_dictamen == 'actualizacion_prioridad') selected @endif>Actualización de prioridad</option>
                        <option value="actualizacion_aprobacion" @if($programas->tipo_dictamen == 'actualizacion_aprobacion') selected @endif>Actualización de aprobación</option>
                    </select>
                </div>
                <div class="mb-4">
                    <input type="hidden" name="nombre" id="nombre" value="{{ $programas->nombre }}">
                    <label for="accion" class="block text-sm font-bold text-gray-700">1.2 ¿Qué se va a hacer?</label>
                    <select name="accion" id="accion" class="w-full border rounded p-2" required>
                        <option value="">Seleccione una acción</option>
                        @foreach(['adquisición', 'construcción', 'adecuación', 'ampliación', 'dotación', 'habilitación', 'instalación', 'mejoramiento', 'implementación', 'recuperación', 'rehabilitación', 'renovación', 'reparación', 'reposicion', 'investigación', 'generación de información', 'saneamiento'] as $accion)
                            <option value="{{ $accion }}" @if($programas->accion == $accion) selected @endif>{{ ucfirst($accion) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="objeto" class="block text-sm font-bold text-gray-700">1.3 ¿Sobre qué se va a hacer?</label>
                    <input type="text" name="objeto" id="objeto" class="w-full border rounded p-2" placeholder="Ej: carretera, hospital, unidad educativa" value="{{ $programas->objeto }}" required>
                </div>
                <div class="mb-4">
                    <label class="font-bold">1.4 Subsector</label>
                    <select name="idEntidad" class="w-full border rounded p-2" required>
                    <option value="">Seleccione una Entidad</option>
                        @foreach ($entidades as $e)
                            <option value="{{ $e->idEntidad }}" @if($programas->idEntidad == $e->idEntidad) selected @endif>{{ $e->subSector }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="font-bold">1.5 Plazo de ejecución</label>
                    <input type="text" name="plazo_ejecucion" class="w-full border rounded p-2" value="{{ $programas->plazo_ejecucion }}" required>
                </div>
                <div class="mb-4">
                    <label class="font-bold">1.6 Monto total</label>
                    <input type="text" name="monto_total" class="w-full border rounded p-2" value="{{ $programas->monto_total }}" required>
                </div>
            </div>

            <div class="tab-content hidden" id="tab1">
                <label class="font-bold block mb-2">2.1 Descripción de la situación actual del sector</label>
                <textarea name="diagnostico" class="w-full border rounded p-2" rows="5">{{ $programas->diagnostico }}</textarea>
                <div class="mb-4">
                    <label class="font-bold block mb-2">2.2 Identificación, descripción y diagnóstico del problema</label>
                    <textarea name="problema" class="w-full border rounded p-2" rows="5">{{ $programas->problema }}</textarea>
                </div>
                <div class="mb-4">
                    <label class="font-bold block mb-2">2.3 Ubicación geográfica e impacto territorial</label>
                    <div id="map" style="height: 400px;" class="rounded shadow border"></div>
                </div>
                <div class="mb-4">
                    <label>Latitud</label>
                    <input type="text" name="latitud" id="latitud" value="{{ $programas->latitud }}">
                    <label >Longitud</label>
                    <input type="text" name="longitud" id="longitud" value="{{ $programas->longitud }}">
                </div>
            </div>

            <div class="tab-content hidden" id="tab2">
                <div class="mb-4">
                    <label class="font-bold">Objetivos Estratégicos</label>
                    <div class="grid grid-cols-1 gap-2">
                       @foreach($objetivosEstrategicos as $objetivo)
                            <label class="inline-flex items-center space-x-2">
                                <input type="checkbox" name="idObjetivoEstrategico[]" value="{{ $objetivo->idObjetivoEstrategico }}" class="form-checkbox text-blue-600"
                                    {{ in_array($objetivo->idObjetivoEstrategico, old('idObjetivoEstrategico', $programas->objetivosEstrategicos->pluck('idObjetivoEstrategico')->toArray())) ? 'checked' : '' }}>
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
                                <input type="checkbox" name="idMetaEstrategica[]" value="{{ $meta->idMetaEstrategica }}" class="form-checkbox text-blue-600"
                                    @if(in_array($meta->idMetaEstrategica, $programa->metas->pluck('idMetaEstrategica')->toArray())) checked @endif>
                                <span>{{ $meta->descripcion }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="tab-content hidden" id="tab3">
                <div class="mb-4">
                    <span class="text-sm font-bold">Monto total disponible: </span>
                    <span id="montoTotalDisplay" class="text-blue-600 font-bold">$0.00</span>
                </div>
                <div class="mb-4">
                    <span class="text-sm font-bold">Saldo restante: </span>
                    <span id="saldoRestanteDisplay" class="text-green-600 font-bold">$0.00</span>
                </div>
                <div id="componentesContainer" class="space-y-4">
                </div>
                <button type="button" id="addComponente" class="mt-2 px-3 py-1 bg-blue-600 text-white rounded">Agregar Componente</button>
                <div id="mensajeSinSaldo" class="mt-2 text-red-600 font-semibold hidden">
                    No hay saldo disponible para agregar más componentes.
                </div>
            </div>

            <div class="tab-content hidden" id="tab4">
                <label class="font-bold block mb-2">Cronograma General</label>
                <div id="cronogramaContainer" class="space-y-4">
                </div>
                <div id="matrizResumen" class="space-y-4">
                    <h3 class="font-bold text-lg mb-4">Resumen Estructurado del Programa</h3>
                    <table class="w-full table-auto border border-gray-300 text-sm">
                        <thead class="bg-gray-100 text-left">
                            <tr>
                                <th class="border px-2 py-1">Nombre</th>
                                <th class="border px-2 py-1 text-right">Valor Componente</th>
                                <th class="border px-2 py-1 text-right">Valor Actividad</th>
                                <th class="border px-2 py-1 text-right">Valor Tarea</th>
                            </tr>
                        </thead>
                        <tbody id="tablaResumen"></tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="flex justify-between pt-6">
            <button type="submit" class="btn btn-success font-bold">Actualizar</button>
            <a href="{{ route('programa.index') }}" class="btn btn-secondary font-bold text-white">Volver</a>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const buttons = document.querySelectorAll('.tab-button');
        const contents = document.querySelectorAll('#tabContents > div');
        buttons.forEach(btn => {
            btn.addEventListener('click', function () {
                buttons.forEach(b => {
                    b.classList.remove('border-blue-500', 'text-blue-500');
                    b.classList.add('border-transparent', 'text-gray-600');
                });
                contents.forEach(c => c.classList.add('hidden'));
                this.classList.remove('border-transparent', 'text-gray-600');
                this.classList.add('border-blue-500', 'text-blue-500');
                const tabId = this.getAttribute('data-tab');
                const activeContent = document.getElementById(tabId);
                if (activeContent) {
                    activeContent.classList.remove('hidden');
                }
            });
        });
    });

    // Actualizar nombre del programa automáticamente
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
    const latitudInicial = "{{ $programa->latitud ?? -0.1807 }}";
    const longitudInicial = "{{ $programa->longitud ?? -78.4678 }}";
    const map = L.map('map').setView([latitudInicial, longitudInicial], 10);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(map);

    // Marcador con las coordenadas guardadas
    const marker = L.marker([latitudInicial, longitudInicial]).addTo(map);

    // Manejar clic en el mapa
    map.on('click', function(e) {
        const lat = e.latlng.lat;
        const lng = e.latlng.lng;
        document.getElementById('latitud').value = lat;
        document.getElementById('longitud').value = lng;
        marker.setLatLng([lat, lng]); // Mueve el marcador a la nueva ubicación
    });

    // DISTRIBUCIÓN DE MONTOS
    let componenteIndex = 0;


    const programa = @json($programas);
    const componentesGuardados = @json($programas->componentes ?? []); // Asegúrate de que el modelo Programa tenga una relación con Componentes

    function actualizarSaldo() {
        const montoTotal = parseFloat(document.querySelector('input[name="monto_total"]').value) || 0;
        const inputsMonto = document.querySelectorAll('.componente-monto');
        let sumaAsignada = 0;
        inputsMonto.forEach(input => {
            const val = parseFloat(input.value);
            if (!isNaN(val)) sumaAsignada += val;
        });
        const saldo = (montoTotal - sumaAsignada).toFixed(2);
        document.getElementById('montoTotalDisplay').textContent = `$${montoTotal.toFixed(2)}`;
        document.getElementById('saldoRestanteDisplay').textContent = `$${saldo}`;
        const saldoLabel = document.getElementById('saldoRestanteDisplay');
        const btnAgregar = document.getElementById('addComponente');
        const mensaje = document.getElementById('mensajeSinSaldo');

        if (saldo <= 0) {
            saldoLabel.classList.remove('text-green-600');
            saldoLabel.classList.add('text-red-600');
            btnAgregar.disabled = true;
            btnAgregar.classList.add('opacity-50', 'cursor-not-allowed');
            mensaje.classList.remove('hidden');
        } else {
            saldoLabel.classList.add('text-green-600');
            saldoLabel.classList.remove('text-red-600');
            btnAgregar.disabled = false;
            btnAgregar.classList.remove('opacity-50', 'cursor-not-allowed');
            mensaje.classList.add('hidden');
        }
    }

    // Llenar el formulario con los componentes existentes
    function cargarComponentes() {
        const container = document.getElementById('componentesContainer');
        container.innerHTML = '';
        componentesGuardados.forEach(comp => {
            const nuevo = document.createElement('div');
            nuevo.classList.add('componente', 'border', 'p-4', 'rounded', 'shadow');
            nuevo.innerHTML = `
                <div class="mb-2">
                    <label class="block text-sm font-bold">Nombre del Componente</label>
                    <input type="text" name="componentes[${componenteIndex}][nombre]" class="w-full border rounded p-2" value="${comp.nombre}" required>
                </div>
                <div class="mb-2">
                    <label class="block text-sm font-bold">Descripción</label>
                    <textarea name="componentes[${componenteIndex}][descripcion]" class="w-full border rounded p-2" rows="3">${comp.descripcion}</textarea>
                </div>
                <div class="mb-2">
                    <label class="block text-sm font-bold">Monto asignado</label>
                    <input type="number" step="0.01" name="componentes[${componenteIndex}][monto]" class="w-full border rounded p-2 componente-monto" value="${comp.monto}" required>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" class="btn-eliminar-componente bg-red-600 px-2 py-1 rounded font-bold text-white text-sm">Eliminar</button>
                </div>
            `;
            container.appendChild(nuevo);
            nuevo.querySelector('.componente-monto').addEventListener('input', actualizarSaldo);
            componenteIndex++;
        });
        actualizarSaldo();
    }
    
    // Agregar nuevo componente
    document.getElementById('addComponente').addEventListener('click', () => {
        // ... (Tu lógica existente para agregar un componente nuevo)
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
                <input type="number" step="0.01" name="componentes[${componenteIndex}][monto]" class="w-full border rounded p-2 componente-monto" required>
            </div>
            <div class="flex justify-end space-x-2">
                <button type="button" class="btn-eliminar-componente bg-red-600 px-2 py-1 rounded font-bold text-white text-sm">Eliminar</button>
            </div>
        `;
        container.appendChild(nuevo);
        nuevo.querySelector('.componente-monto').addEventListener('input', actualizarSaldo);
        componenteIndex++;
        actualizarSaldo();
        generarCronogramaDesdeComponentes();
    });

    // Eventos sobre contenedor de componentes
    document.getElementById('componentesContainer').addEventListener('click', function (e) {
        if (e.target.classList.contains('btn-eliminar-componente')) {
            e.target.closest('.componente').remove();
            actualizarSaldo();
            generarCronogramaDesdeComponentes();
        }
    });

    // Llenar y generar el cronograma
    function generarCronogramaDesdeComponentes() {
        const container = document.getElementById('cronogramaContainer');
        container.innerHTML = '';

        const componentes = document.querySelectorAll('.componente');
        componentes.forEach((componenteEl, i) => {
            const inputNombre = componenteEl.querySelector('input[name^="componentes"][name$="[nombre]"]');
            const inputMonto = componenteEl.querySelector('input[name^="componentes"][name$="[monto]"]');
            const nombreComponente = inputNombre?.value || `Componente ${i + 1}`;
            const montoComponente = parseFloat(inputMonto?.value) || 0;
            const bloque = document.createElement('div');
            bloque.classList.add('border', 'p-4', 'rounded', 'shadow');
            bloque.innerHTML = `
                <h3 class="font-bold text-blue-700 mb-2">${nombreComponente} - Monto: $${montoComponente.toFixed(2)}</h3>
                <div class="actividades space-y-2" data-componente-index="${i}"></div>
                <button type="button" class="btn-actividad bg-blue-600 text-white px-3 py-1 rounded" data-componente-index="${i}">Agregar Actividad</button>
            `;
            container.appendChild(bloque);
                 const actividadesContainer = bloque.querySelector('.actividades');
            // Cargar actividades existentes si las hay
            const compData = componentesGuardados[i] || { actividades: [] };
            if (compData.actividades) {
                compData.actividades.forEach((act, actIdx) => {
                    const nuevaActividad = document.createElement('div');
                    nuevaActividad.classList.add('actividad', 'border', 'p-3', 'rounded', 'bg-gray-50');
                    nuevaActividad.innerHTML = `
                        <label class="font-semibold block mb-1">Actividad ${actIdx + 1}</label>
                        <input type="text" name="componentes[${i}][actividades][${actIdx}][nombre]" class="border p-2 w-full my-1" placeholder="Nombre de la actividad" value="${act.nombre}" required>
                        <input type="number" step="0.01" name="componentes[${i}][actividades][${actIdx}][monto]" class="border p-2 w-full mb-2 actividad-monto" placeholder="Monto de la actividad" value="${act.monto}" required>
                        <div class="tareas space-y-1" data-comp="${i}" data-act="${actIdx}"></div>
                        <button type="button" class="btn-tarea bg-blue-500 text-white px-2 py-1 rounded" data-comp="${i}" data-act="${actIdx}">Agregar Tarea</button>
                    `;
                    actividadesContainer.appendChild(nuevaActividad);

                    const tareasContainer = nuevaActividad.querySelector('.tareas');
                    // Cargar tareas existentes si las hay
                    if (act.tareas) {
                        act.tareas.forEach((tar, tIdx) => {
                            const nuevaTarea = document.createElement('div');
                            nuevaTarea.classList.add('tarea', 'ml-4', 'border-l', 'pl-2');
                            nuevaTarea.innerHTML = `
                                <input type="text" name="componentes[${i}][actividades][${actIdx}][tareas][${tIdx}][nombre]"
                                    class="border p-1 w-full mb-1" placeholder="Nombre de la tarea" value="${tar.nombre}" required>
                                <input type="number" step="0.01" name="componentes[${i}][actividades][${actIdx}][tareas][${tIdx}][monto]"
                                    class="border p-1 w-full mb-2" placeholder="Monto de la tarea" value="${tar.monto}" required>
                            `;
                            tareasContainer.appendChild(nuevaTarea);
                        });
                    }
                });
            }
        });
        activarBotonesActividad();
        activarBotonesTarea();
        generarTablaResumen(); // Llama a la función para actualizar la tabla de resumen
    }
    
    function activarBotonesActividad() {
        document.querySelectorAll('.btn-actividad').forEach(btn => {
            btn.onclick = () => {
                const idx = btn.dataset.componenteIndex;
                const actividadContainer = btn.previousElementSibling;
                const actividades = actividadContainer.querySelectorAll('.actividad');
                const componenteEl = document.querySelectorAll('.componente')[idx];
                const montoComponente = parseFloat(componenteEl.querySelector('input[name^="componentes"][name$="[monto]"]').value) || 0;
                let totalAsignado = 0;
                actividades.forEach(a => {
                    const monto = parseFloat(a.querySelector('input[name$="[monto]"]').value) || 0;
                    totalAsignado += monto;
                });
                const saldoComponente = montoComponente - totalAsignado;
                if (saldoComponente <= 0) {
                    alert('No hay saldo disponible para agregar más actividades en este componente.');
                    return;
                }
                const nuevaActividad = document.createElement('div');
                nuevaActividad.classList.add('actividad', 'border', 'p-3', 'rounded', 'bg-gray-50');
                nuevaActividad.innerHTML = `
                    <label class="font-semibold block mb-1">Actividad ${actividades.length + 1}</label>
                    <label class="text-sm text-gray-600">Saldo de la actividad: $${saldoComponente.toFixed(2)}</label>
                    <input type="text" name="componentes[${idx}][actividades][${actividades.length}][nombre]" class="border p-2 w-full my-1" placeholder="Nombre de la actividad" required>
                    <input type="number" step="0.01" name="componentes[${idx}][actividades][${actividades.length}][monto]" class="border p-2 w-full mb-2 actividad-monto" placeholder="Monto de la actividad" required>
                    <div class="tareas space-y-1"></div>
                    <button type="button" class="btn-tarea bg-blue-500 text-white px-2 py-1 rounded" data-comp="${idx}" data-act="${actividades.length}">Agregar Tarea</button>
                `;
                actividadContainer.appendChild(nuevaActividad);
                activarBotonesTarea();
                generarTablaResumen(); // Actualiza la tabla al agregar
            };
        });
    }

    function activarBotonesTarea() {
        document.querySelectorAll('.btn-tarea').forEach(btn => {
            btn.onclick = () => {
                const compIdx = btn.dataset.comp;
                const actIdx = btn.dataset.act;
                const tareaContainer = btn.previousElementSibling;
                const tareas = tareaContainer.querySelectorAll('.tarea');
                const actividadEl = tareaContainer.closest('.actividad');
                const montoActividad = parseFloat(actividadEl.querySelector('input[name$="[monto]"]').value) || 0;
                let totalAsignado = 0;
                tareas.forEach(t => {
                    const monto = parseFloat(t.querySelector('input[name$="[monto]"]').value) || 0;
                    totalAsignado += monto;
                });
                const saldoActividad = montoActividad - totalAsignado;
                if (saldoActividad <= 0) {
                    alert('No hay saldo disponible para agregar más tareas en esta actividad.');
                    return;
                }
                const nuevaTarea = document.createElement('div');
                nuevaTarea.classList.add('tarea', 'ml-4', 'border-l', 'pl-2');
                nuevaTarea.innerHTML = `
                    <label class="text-sm text-gray-600">Saldo de la tarea: $${saldoActividad.toFixed(2)}</label>
                    <input type="text" name="componentes[${compIdx}][actividades][${actIdx}][tareas][${tareas.length}][nombre]"
                        class="border p-1 w-full mb-1" placeholder="Nombre de la tarea" required>
                    <input type="number" step="0.01" name="componentes[${compIdx}][actividades][${actIdx}][tareas][${tareas.length}][monto]"
                        class="border p-1 w-full mb-2" placeholder="Monto de la tarea" required>
                `;
                tareaContainer.appendChild(nuevaTarea);
                generarTablaResumen(); // Actualiza la tabla al agregar
            };
        });
    }

    function generarTablaResumen() {
        const tbody = document.getElementById('tablaResumen');
        tbody.innerHTML = '';
        const componentes = document.querySelectorAll('.componente');
        componentes.forEach((componenteEl, i) => {
            const inputNombre = componenteEl.querySelector('input[name^="componentes"][name$="[nombre]"]');
            const inputMonto = componenteEl.querySelector('input[name^="componentes"][name$="[monto]"]');
            const nombreComponente = inputNombre?.value || `Componente ${i + 1}`;
            const montoComponente = parseFloat(inputMonto?.value) || 0;

            tbody.innerHTML += `
                <tr>
                    <td class="border px-2 py-1 font-semibold text-gray-900">${nombreComponente}</td>
                    <td class="border px-2 py-1 text-right font-bold text-blue-600">$${montoComponente.toFixed(2)}</td>
                    <td class="border px-2 py-1"></td>
                    <td class="border px-2 py-1"></td>
                </tr>
            `;

            const actividades = document.querySelectorAll(`.actividades[data-componente-index="${i}"] .actividad`);
            actividades.forEach((actividadEl, actIdx) => {
                const nombreAct = actividadEl.querySelector(`input[name="componentes[${i}][actividades][${actIdx}][nombre]"]`)?.value || `Actividad ${actIdx + 1}`;
                const montoAct = parseFloat(actividadEl.querySelector(`input[name="componentes[${i}][actividades][${actIdx}][monto]"]`)?.value || 0).toFixed(2);

                tbody.innerHTML += `
                    <tr>
                        <td class="border px-2 py-1 pl-6 text-gray-800">== ${nombreAct}</td>
                        <td class="border px-2 py-1"></td>
                        <td class="border px-2 py-1 text-right text-green-600">$${montoAct}</td>
                        <td class="border px-2 py-1"></td>
                    </tr>
                `;

                const tareas = actividadEl.querySelectorAll('.tarea');
                tareas.forEach((tareaEl, tIdx) => {
                    const nombreTar = tareaEl.querySelector(`input[name="componentes[${i}][actividades][${actIdx}][tareas][${tIdx}][nombre]"]`)?.value || `Tarea ${tIdx + 1}`;
                    const montoTar = parseFloat(tareaEl.querySelector(`input[name="componentes[${i}][actividades][${actIdx}][tareas][${tIdx}][monto]"]`)?.value || 0).toFixed(2);

                    tbody.innerHTML += `
                        <tr>
                            <td class="border px-2 py-1 pl-12 text-gray-700">==== ${nombreTar}</td>
                            <td class="border px-2 py-1"></td>
                            <td class="border px-2 py-1"></td>
                            <td class="border px-2 py-1 text-right text-purple-600">$${montoTar}</td>
                        </tr>
                    `;
                });
            });
        });
    }

    // Inicializar el formulario y las tablas al cargar la página
    window.addEventListener('DOMContentLoaded', () => {
        actualizarNombre();
        cargarComponentes();
        generarCronogramaDesdeComponentes();
    });

    document.querySelector('input[name="monto_total"]').addEventListener('input', () => {
        actualizarSaldo();
        generarCronogramaDesdeComponentes();
    });
    document.getElementById('componentesContainer').addEventListener('change', () => {
        generarCronogramaDesdeComponentes();
        generarTablaResumen();
    });
    document.getElementById('cronogramaContainer').addEventListener('change', generarTablaResumen);
</script>
@endsection