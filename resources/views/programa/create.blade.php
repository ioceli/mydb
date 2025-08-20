@extends('layouts.master')
@section('title','Nuevo Programa')
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
<h2 class="text-xl font-bold mb-4">Registrar nuevo Programa</h2>
<div class="max-w-5xl mx-auto bg-white p-6 rounded shadow">
    <form action="{{ route('programa.store') }}" method="POST" class="space-y-6">
        @csrf
        <div>
            @php $tabs = ['Datos Iniciales', 'Diagnóstico', 'Alineación', 'Financiamiento y Cronograma']; @endphp
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
                        <option value="prioridad">Dictamen de prioridad</option>
                        <option value="aprobacion">Dictamen de aprobación</option>
                        <option value="actualizacion_prioridad">Actualización de prioridad</option>
                        <option value="actualizacion_aprobacion">Actualización de aprobación</option>
                    </select>
                </div>
                <div class="mb-4">
                    <input type="hidden" name="nombre" id="nombre">
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
                    <option value="">Seleccione una Entidad</option>
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
                </div>
                <div class="mb-4">
                    <label>Latitud</label>
                    <input type="text" name="latitud" id="latitud">
                    <label >Longitud</label>
                    <input type="text" name="longitud" id="longitud">
                </div>
            </div>
            <div class="tab-content hidden" id="tab2">
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
            <div class="tab-content hidden" id="tab3">
                <h3 class="font-bold text-lg mb-4">Financiamiento y Presupuesto</h3>
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
                <hr class="my-6">
                <h3 class="font-bold text-lg mb-4">Cronograma y Estructura</h3>
                <div id="cronogramaContainer" class="space-y-4">
                </div>
                <div id="matrizResumen" class="space-y-4">
                    <h4 class="font-bold text-lg mb-4">Resumen Estructurado del Programa</h4>
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
            <button type="submit" class="btn btn-success font-bold">Guardar</button>
            <a href="{{ route('programa.index') }}" class="btn btn-secondary font-bold text-white">Volver</a>
        </div>
    </form>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Tabs
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
            if (activeContent) activeContent.classList.remove('hidden');
        });
    });
    // Nombre programa
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
    // Leaflet map
    const map = L.map('map').setView([-0.1807, -78.4678], 10);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(map);
    const marker = L.marker([-0.1807, -78.4678]).addTo(map);
    map.on('click', function(e) {
        const lat = e.latlng.lat;
        const lng = e.latlng.lng;
        document.getElementById('latitud').value = lat;
        document.getElementById('longitud').value = lng;
        marker.setLatLng([lat, lng]);
    });
    map.on('locationfound', function(e) {
        const lat = e.latitude;
        const lng = e.longitude;
        document.getElementById('latitud').value = lat;
        document.getElementById('longitud').value = lng;
    });
    // Componentes
    let componenteIndex = 0;
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
        // Validación para habilitar/deshabilitar botón de agregar componente
        let puedeAgregar = false;
        // Verifica si los campos del último componente están llenos
        const componentes = document.querySelectorAll('.componente');
        if (saldo > 0) {
            if (componentes.length === 0) {
                puedeAgregar = true;
            } else {
                const ultimo = componentes[componentes.length - 1];
                const nombre = ultimo.querySelector('input[name^="componentesPrograma"][name$="[nombre]"]')?.value.trim();
                const descripcion = ultimo.querySelector('textarea[name^="componentesPrograma"][name$="[descripcion]"]')?.value.trim();
                const monto = ultimo.querySelector('input[name^="componentesPrograma"][name$="[monto]"]')?.value;
                if (nombre && descripcion && monto && parseFloat(monto) > 0) {
                    puedeAgregar = true;
                }
            }
        }
        if (!puedeAgregar) {
            btnAgregar.disabled = true;
            btnAgregar.classList.add('opacity-50', 'cursor-not-allowed');
        } else {
            btnAgregar.disabled = false;
            btnAgregar.classList.remove('opacity-50', 'cursor-not-allowed');
        }
        if (saldo <= 0) {
            saldoLabel.classList.remove('text-green-600');
            saldoLabel.classList.add('text-red-600');
            mensaje.classList.remove('hidden');
        } else {
            saldoLabel.classList.add('text-green-600');
            saldoLabel.classList.remove('text-red-600');
            mensaje.classList.add('hidden');
        }
    }
    document.querySelector('input[name="monto_total"]').addEventListener('input', () => {
        actualizarSaldo();
        generarCronogramaDesdeComponentes();
    });
    document.getElementById('addComponente').addEventListener('click', () => {
        const container = document.getElementById('componentesContainer');
        const nuevo = document.createElement('div');
        nuevo.classList.add('componente', 'border', 'p-4', 'rounded', 'shadow');
        nuevo.innerHTML = `
            <div class="mb-2">
                <label class="block text-sm font-bold">Nombre del Componente</label>
                <input type="text" name="componentesPrograma[${componenteIndex}][nombre]" class="w-full border rounded p-2 componente-nombre" required>
            </div>
            <div class="mb-2">
                <label class="block text-sm font-bold">Descripción</label>
                <textarea name="componentesPrograma[${componenteIndex}][descripcion]" class="w-full border rounded p-2" rows="3"></textarea>
            </div>
            <div class="mb-2">
                <label class="block text-sm font-bold">Monto asignado</label>
                <input type="number" step="0.01" name="componentesPrograma[${componenteIndex}][monto]" class="w-full border rounded p-2 componente-monto" required>
            </div>
        `;
        container.appendChild(nuevo);
        nuevo.querySelector('.componente-monto').addEventListener('input', actualizarSaldo);
        nuevo.querySelector('.componente-nombre').addEventListener('input', actualizarSaldo);
        nuevo.querySelector('textarea').addEventListener('input', actualizarSaldo);
        componenteIndex++;
        actualizarSaldo();
        generarCronogramaDesdeComponentes();
    });
    document.querySelectorAll('.componente-monto').forEach(input => {
        input.addEventListener('input', actualizarSaldo);
    });
    // También escucha cambios en nombre y descripción para la validación del botón
    document.querySelectorAll('.componente-nombre').forEach(input => {
        input.addEventListener('input', actualizarSaldo);
    });
    document.querySelectorAll('.componente textarea').forEach(input => {
        input.addEventListener('input', actualizarSaldo);
    });
    window.addEventListener('DOMContentLoaded', () => {
        actualizarSaldo();
        generarCronogramaDesdeComponentes();
    });
    document.getElementById('componentesContainer').addEventListener('change', generarCronogramaDesdeComponentes);
    function generarCronogramaDesdeComponentes() {
        const container = document.getElementById('cronogramaContainer');
        container.innerHTML = '';
        const componentes = document.querySelectorAll('.componente');
        componentes.forEach((componenteEl, i) => {
            const inputNombre = componenteEl.querySelector('input[name^="componentesPrograma"][name$="[nombre]"]');
            const inputMonto = componenteEl.querySelector('input[name^="componentesPrograma"][name$="[monto]"]');
            const nombreComponente = inputNombre?.value || `Componente ${i + 1}`;
            const montoComponente = parseFloat(inputMonto?.value) || 0;
            const bloque = document.createElement('div');
            bloque.classList.add('border', 'p-4', 'rounded', 'shadow');
            bloque.innerHTML = `
                <h3 class="font-bold text-blue-700 mb-2">
                    ${nombreComponente} - Monto: $${montoComponente.toFixed(2)}
                    <span class="text-xs font-normal text-gray-500 ml-2">(Saldo: <span class="saldo-componente text-green-600 font-bold">$${montoComponente.toFixed(2)}</span>)</span>
                </h3>
                <div class="actividades space-y-2 mb-4" data-componente-index="${i}"></div>
                <button type="button" class="add-actividad mt-2 px-3 py-1 bg-blue-500 text-white rounded text-sm" data-componente-index="${i}">Agregar Actividad</button>
                <div class="mensaje-sin-saldo-actividad text-red-600 font-semibold hidden">
                    No hay saldo disponible en este componente para agregar más actividades.
                </div>
            `;
            container.appendChild(bloque);
            // Validación para habilitar/deshabilitar botón de actividad
            function validarAgregarActividad() {
                const actividades = bloque.querySelectorAll('.actividad');
                let ultimoCompleto = true;
                if (actividades.length > 0) {
                    const ultima = actividades[actividades.length - 1];
                    const nombre = ultima.querySelector('input[name^="componentesPrograma"][name$="[nombre]"]')?.value.trim();
                    const monto = ultima.querySelector('input[name^="componentesPrograma"][name$="[monto]"]')?.value;
                    // Debe existir al menos una tarea y estar llena
                    const tareas = ultima.querySelectorAll('.tarea');
                    let tareaCompleta = false;
                    if (tareas.length > 0) {
                        const ultimaTarea = tareas[tareas.length - 1];
                        const nombreTarea = ultimaTarea.querySelector('input[name$="[nombre]"]')?.value.trim();
                        const montoTarea = ultimaTarea.querySelector('input[name$="[monto]"]')?.value;
                        tareaCompleta = !!(nombreTarea && montoTarea && parseFloat(montoTarea) > 0);
                    }
                    if (!nombre || !monto || parseFloat(monto) <= 0 || !tareaCompleta) {
                        ultimoCompleto = false;
                    }
                }
                // Saldo
                const actividadesInputs = bloque.querySelectorAll('.actividad-monto');
                let sumaActividades = 0;
                actividadesInputs.forEach(input => sumaActividades += parseFloat(input.value) || 0);
                const saldo = (montoComponente - sumaActividades).toFixed(2);
                const btnAgregar = bloque.querySelector('.add-actividad');
                const mensaje = bloque.querySelector('.mensaje-sin-saldo-actividad');
                if (saldo <= 0 || !ultimoCompleto) {
                    btnAgregar.disabled = true;
                    btnAgregar.classList.add('opacity-50', 'cursor-not-allowed');
                    mensaje.classList.remove('hidden');
                } else {
                    btnAgregar.disabled = false;
                    btnAgregar.classList.remove('opacity-50', 'cursor-not-allowed');
                    mensaje.classList.add('hidden');
                }
                bloque.querySelector('.saldo-componente').textContent = `$${saldo}`;
                if (saldo <= 0) {
                    bloque.querySelector('.saldo-componente').classList.add('text-red-600');
                    bloque.querySelector('.saldo-componente').classList.remove('text-green-600');
                } else {
                    bloque.querySelector('.saldo-componente').classList.remove('text-red-600');
                    bloque.querySelector('.saldo-componente').classList.add('text-green-600');
                }
            }
            bloque.querySelector('.add-actividad').addEventListener('click', () => generarActividadYTarea(i, validarAgregarActividad));
            bloque.addEventListener('input', validarAgregarActividad);
            bloque.addEventListener('change', validarAgregarActividad);
            validarAgregarActividad();
        });
        generarTablaResumen();
    }
    // Generar actividad y tarea
    function generarActividadYTarea(componenteIndex, validarAgregarActividad) {
        const actividadContainer = document.querySelector(`.actividades[data-componente-index="${componenteIndex}"]`);
        const actividadIndex = actividadContainer.querySelectorAll('.actividad').length;
        const nuevaActividad = document.createElement('div');
        nuevaActividad.classList.add('actividad', 'border', 'p-3', 'rounded', 'bg-gray-50');
        nuevaActividad.innerHTML = `
            <div class="flex justify-between items-center mb-1">
                <label class="font-semibold">Actividad ${actividadIndex + 1}</label>
                <span class="text-xs font-normal text-gray-500">(Saldo: <span class="saldo-actividad text-green-600 font-bold">$0.00</span>)</span>
            </div>
            <input type="text" name="componentesPrograma[${componenteIndex}][actividadesPrograma][${actividadIndex}][nombre]" class="border p-2 w-full my-1 actividad-nombre" placeholder="Nombre de la actividad" required>
            <input type="number" step="0.01" name="componentesPrograma[${componenteIndex}][actividadesPrograma][${actividadIndex}][monto]" class="border p-2 w-full mb-2 actividad-monto" placeholder="Monto de la actividad" required>
            <div class="tareas space-y-1" data-comp="${componenteIndex}" data-act="${actividadIndex}"></div>
            <button type="button" class="add-tarea mt-2 px-3 py-1 bg-blue-400 text-white rounded text-xs" data-comp="${componenteIndex}" data-act="${actividadIndex}">Agregar Tarea</button>
            <div class="mensaje-sin-saldo-tarea text-red-600 font-semibold hidden">
                No hay saldo disponible en esta actividad para agregar más tareas.
            </div>
        `;
        actividadContainer.appendChild(nuevaActividad);
        // Validación para habilitar/deshabilitar botón de tarea
        function validarAgregarTarea() {
            const tareas = nuevaActividad.querySelectorAll('.tarea');
            let ultimoCompleto = true;
            if (tareas.length > 0) {
                const ultima = tareas[tareas.length - 1];
                const nombre = ultima.querySelector('input[name$="[nombre]"]')?.value.trim();
                const monto = ultima.querySelector('input[name$="[monto]"]')?.value;
                if (!nombre || !monto || parseFloat(monto) <= 0) {
                    ultimoCompleto = false;
                }
            }
            // Saldo
            const montoActividadInput = nuevaActividad.querySelector('.actividad-monto');
            const montoActividad = parseFloat(montoActividadInput.value) || 0;
            const tareasInputs = nuevaActividad.querySelectorAll('.tarea-monto');
            let sumaTareas = 0;
            tareasInputs.forEach(input => sumaTareas += parseFloat(input.value) || 0);
            const saldoActividad = (montoActividad - sumaTareas).toFixed(2);
            const btnAgregarTarea = nuevaActividad.querySelector('.add-tarea');
            const mensajeSinSaldoTarea = nuevaActividad.querySelector('.mensaje-sin-saldo-tarea');
            nuevaActividad.querySelector('.saldo-actividad').textContent = `$${saldoActividad}`;
            if (saldoActividad <= 0 || !ultimoCompleto) {
                btnAgregarTarea.disabled = true;
                btnAgregarTarea.classList.add('opacity-50', 'cursor-not-allowed');
                mensajeSinSaldoTarea.classList.remove('hidden');
            } else {
                btnAgregarTarea.disabled = false;
                btnAgregarTarea.classList.remove('opacity-50', 'cursor-not-allowed');
                mensajeSinSaldoTarea.classList.add('hidden');
            }
            if (saldoActividad <= 0) {
                nuevaActividad.querySelector('.saldo-actividad').classList.add('text-red-600');
                nuevaActividad.querySelector('.saldo-actividad').classList.remove('text-green-600');
            } else {
                nuevaActividad.querySelector('.saldo-actividad').classList.remove('text-red-600');
                nuevaActividad.querySelector('.saldo-actividad').classList.add('text-green-600');
            }
        }
        nuevaActividad.querySelector('.add-tarea').addEventListener('click', () => generarTarea(componenteIndex, actividadIndex, validarAgregarTarea));
        nuevaActividad.addEventListener('input', validarAgregarTarea);
        nuevaActividad.addEventListener('change', validarAgregarTarea);
        // Mostrar saldo disponible del componente mientras se llena actividad
        nuevaActividad.querySelector('.actividad-monto').addEventListener('input', () => {
            const componenteEl = nuevaActividad.closest('.componente');
            const montoComponenteInput = componenteEl.querySelector('.componente-monto');
            const montoComponente = parseFloat(montoComponenteInput.value) || 0;
            const actividadesInputs = componenteEl.querySelectorAll('.actividad-monto');
            let sumaActividades = 0;
            actividadesInputs.forEach(input => sumaActividades += parseFloat(input.value) || 0);
            const saldoComponente = (montoComponente - sumaActividades).toFixed(2);
            componenteEl.querySelector('.saldo-componente').textContent = `$${saldoComponente}`;
        });
        // Generar una tarea por defecto
        generarTarea(componenteIndex, actividadIndex, validarAgregarTarea);
        validarAgregarTarea();
        if (typeof validarAgregarActividad === 'function') validarAgregarActividad();
    }
    function generarTarea(compIdx, actIdx, validarAgregarTarea) {
        const tareaContainer = document.querySelector(`.tareas[data-comp="${compIdx}"][data-act="${actIdx}"]`);
        const tareaIndex = tareaContainer.querySelectorAll('.tarea').length;
        const nuevaTarea = document.createElement('div');
        nuevaTarea.classList.add('tarea', 'ml-4', 'border-l', 'pl-2');
        nuevaTarea.innerHTML = `
            <div class="flex justify-between items-center">
                <label class="text-sm text-gray-600">Tarea ${tareaIndex + 1}</label>
            </div>
            <input type="text" name="componentesPrograma[${compIdx}][actividadesPrograma][${actIdx}][tareasPrograma][${tareaIndex}][nombre]"
                class="border p-1 w-full mb-1 tarea-nombre" placeholder="Nombre de la tarea" required>
            <input type="number" step="0.01" name="componentesPrograma[${compIdx}][actividadesPrograma][${actIdx}][tareasPrograma][${tareaIndex}][monto]" 
                class="border p-1 w-full mb-2 tarea-monto" placeholder="Monto de la tarea" required>
        `;
        tareaContainer.appendChild(nuevaTarea);
        // Mostrar saldo disponible de la actividad mientras se llena tarea
        nuevaTarea.querySelector('.tarea-monto').addEventListener('input', () => {
            const actividadEl = nuevaTarea.closest('.actividad');
            const montoActividadInput = actividadEl.querySelector('.actividad-monto');
            const montoActividad = parseFloat(montoActividadInput.value) || 0;
            const tareasInputs = actividadEl.querySelectorAll('.tarea-monto');
            let sumaTareas = 0;
            tareasInputs.forEach(input => sumaTareas += parseFloat(input.value) || 0);
            const saldoActividad = (montoActividad - sumaTareas).toFixed(2);
            actividadEl.querySelector('.saldo-actividad').textContent = `$${saldoActividad}`;
        });
        nuevaTarea.querySelector('.tarea-nombre').addEventListener('input', () => {
            if (typeof validarAgregarTarea === 'function') validarAgregarTarea();
        });
        nuevaTarea.querySelector('.tarea-monto').addEventListener('input', () => {
            if (typeof validarAgregarTarea === 'function') validarAgregarTarea();
        });

        if (typeof validarAgregarTarea === 'function') validarAgregarTarea();
    }
    function generarTablaResumen() {
        const tbody = document.getElementById('tablaResumen');
        tbody.innerHTML = '';
        const componentes = document.querySelectorAll('.componente');
        componentes.forEach((componenteEl, i) => {
            const inputNombre = componenteEl.querySelector('input[name^="componentesPrograma"][name$="[nombre]"]');
            const inputMonto = componenteEl.querySelector('input[name^="componentesPrograma"][name$="[monto]"]');
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
                const nombreAct = actividadEl.querySelector(`input[name="componentesPrograma[${i}][actividadesPrograma][${actIdx}][nombre]"]`)?.value || `Actividad ${actIdx + 1}`;
                const montoAct = parseFloat(actividadEl.querySelector(`input[name="componentesPrograma[${i}][actividadesPrograma][${actIdx}][monto]"]`)?.value || 0).toFixed(2);
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
                    const nombreTar = tareaEl.querySelector(`input[name="componentesPrograma[${i}][actividadesPrograma][${actIdx}][tareasPrograma][${tIdx}][nombre]"]`)?.value || `Tarea ${tIdx + 1}`;
                    const montoTar = parseFloat(tareaEl.querySelector(`input[name="componentesPrograma[${i}][actividadesPrograma][${actIdx}][tareasPrograma][${tIdx}][monto]"]`)?.value || 0).toFixed(2);
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
    document.getElementById('cronogramaContainer').addEventListener('change', generarTablaResumen);
    document.getElementById('componentesContainer').addEventListener('change', generarTablaResumen);
    window.addEventListener('DOMContentLoaded', generarTablaResumen);
});
</script>
@endsection