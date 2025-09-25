
@extends('layouts.master')
@section('title','Editar Programa')
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
<h2 class="text-xl font-bold mb-4">Editar Programa</h2>
<div class="max-w-5xl mx-auto bg-white p-6 rounded shadow">
    <form action="{{ route('programa.update', $programa->idPrograma) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
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
                        <option value="prioridad" {{ $programa->tipo_dictamen == 'prioridad' ? 'selected' : '' }}>Dictamen de prioridad</option>
                        <option value="aprobacion" {{ $programa->tipo_dictamen == 'aprobacion' ? 'selected' : '' }}>Dictamen de aprobación</option>
                        <option value="actualizacion_prioridad" {{ $programa->tipo_dictamen == 'actualizacion_prioridad' ? 'selected' : '' }}>Actualización de prioridad</option>
                        <option value="actualizacion_aprobacion" {{ $programa->tipo_dictamen == 'actualizacion_aprobacion' ? 'selected' : '' }}>Actualización de aprobación</option>
                    </select>
                </div>
                <div class="mb-4">
                    <input type="hidden" name="nombre" id="nombre" value="{{ $programa->nombre }}">
                    <label for="accion" class="block text-sm font-bold text-gray-700">1.2 ¿Qué se va a hacer?</label>
                    <select name="accion" id="accion" class="w-full border rounded p-2" required>
                        <option value="">Seleccione una acción</option>
                        @foreach(['adquisición', 'construcción', 'adecuación', 'ampliación', 'dotación', 'habilitación', 'instalación', 'mejoramiento', 'implementación', 'recuperación', 'rehabilitación', 'renovación', 'reparación', 'reposicion', 'investigación', 'generación de información', 'saneamiento'] as $accion)
                            <option value="{{ $accion }}" {{ $programa->accion == $accion ? 'selected' : '' }}>{{ ucfirst($accion) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="objeto" class="block text-sm font-bold text-gray-700">1.3 ¿Sobre qué se va a hacer?</label>
                    <input type="text" name="objeto" id="objeto" class="w-full border rounded p-2" placeholder="Ej: carretera, hospital, unidad educativa" required value="{{ $programa->objeto }}">
                </div>
                <div class="mb-4">
                    <label class="font-bold">1.4 Subsector</label>
                    <select name="idEntidad" class="w-full border rounded p-2" required>
                        <option value="">Seleccione una Entidad</option>
                        @foreach ($entidad as $e)
                            <option value="{{ $e->idEntidad }}" {{ $programa->idEntidad == $e->idEntidad ? 'selected' : '' }}>{{ $e->subSector }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="font-bold">1.5 Plazo de ejecución</label>
                    <input type="text" name="plazo_ejecucion" class="w-full border rounded p-2" required value="{{ $programa->plazo_ejecucion }}">
                </div>
                <div class="mb-4">
                    <label class="font-bold">1.6 Monto total</label>
                    <input type="text" name="monto_total" class="w-full border rounded p-2" required value="{{ $programa->monto_total }}">
                </div>
            </div>
            <div class="tab-content hidden" id="tab1">
                <label class="font-bold block mb-2">2.1 Descripción de la situación actual del sector</label>
                <textarea name="diagnostico" class="w-full border rounded p-2" rows="5">{{ $programa->diagnostico }}</textarea>
                <div class="mb-4">
                    <label class="font-bold block mb-2">2.2 Identificación, descripción y diagnóstico del problema</label>
                    <textarea name="problema" class="w-full border rounded p-2" rows="5">{{ $programa->problema }}</textarea>
                </div>
                <div class="mb-4">
                    <label class="font-bold block mb-2">2.3 Ubicación geográfica e impacto territorial</label>
                    <div id="map" style="height: 400px;" class="rounded shadow border"></div>
                </div>
                <div class="mb-4">
                    <label>Latitud</label>
                    <input type="text" name="latitud" id="latitud" value="{{ $programa->latitud }}">
                    <label>Longitud</label>
                    <input type="text" name="longitud" id="longitud" value="{{ $programa->longitud }}">
                </div>
            </div>
            <div class="tab-content hidden" id="tab2">
                <div class="mb-4">
                    <label class="font-bold">Objetivos Estratégicos</label>
                    <div class="grid grid-cols-1 gap-2">
                        @foreach($objetivosEstrategicos as $objetivo)
                            <label class="inline-flex items-center space-x-2">
                                <input type="checkbox" name="idObjetivoEstrategico[]" value="{{ $objetivo->idObjetivoEstrategico }}" class="form-checkbox text-blue-600"
                                {{ in_array($objetivo->idObjetivoEstrategico, $programa->objetivosEstrategicos->pluck('idObjetivoEstrategico')->toArray() ?? []) ? 'checked' : '' }}>
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
                                {{ in_array($meta->idMetaEstrategica, $programa->metasEstrategicas->pluck('idMetaEstrategica')->toArray() ?? []) ? 'checked' : '' }}>
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
                    <span id="montoTotalDisplay" class="text-blue-600 font-bold">${{ number_format($programa->monto_total, 2) }}</span>
                </div>
                <div class="mb-4">
                    <span class="text-sm font-bold">Saldo restante: </span>
                    <span id="saldoRestanteDisplay" class="text-green-600 font-bold">$0.00</span>
                </div>
                <div id="componentesContainer" class="space-y-4">
                    @foreach($programa->componentesPrograma as $ci => $componente)
                    <div class="componente border p-4 rounded shadow">
                        <div class="mb-2">
                            <label class="block text-sm font-bold">Nombre del Componente</label>
                            <input type="text" name="componentesPrograma[{{ $ci }}][nombre]" class="w-full border rounded p-2 componente-nombre" required value="{{ $componente->nombre }}">
                        </div>
                        <div class="mb-2">
                            <label class="block text-sm font-bold">Descripción</label>
                            <textarea name="componentesPrograma[{{ $ci }}][descripcion]" class="w-full border rounded p-2" rows="3">{{ $componente->descripcion }}</textarea>
                        </div>
                        <div class="mb-2">
                            <label class="block text-sm font-bold">Monto asignado</label>
                            <input type="number" step="0.01" name="componentesPrograma[{{ $ci }}][monto]" class="w-full border rounded p-2 componente-monto" required value="{{ $componente->monto }}">
                        </div>
                    </div>
                    @endforeach
                     
                </div>
                <button type="button" id="addComponente" class="mt-2 px-3 py-1 bg-blue-600 text-white rounded">Agregar Componente</button>
                <button type="button" id="removeComponente" class="mt-2 px-3 py-1 bg-red-600 text-white rounded">Eliminar Componente</button>
                <div id="mensajeSinSaldo" class="mt-2 text-red-600 font-semibold hidden">
                    No hay saldo disponible para agregar más componentes.
                </div>
                <hr class="my-6">
                <h3 class="font-bold text-lg mb-4">Cronograma y Estructura</h3>
                <div id="cronogramaContainer" class="space-y-4">
                    @foreach($programa->componentesPrograma as $ci => $componente)
                    <div class="border p-4 rounded shadow">
                        <h3 class="font-bold text-blue-700 mb-2" data-monto="{{ $componente->monto }}">
                            {{ $componente->nombre }} - Monto: ${{ number_format($componente->monto, 2) }}
                            <span class="text-xs font-normal text-gray-500 ml-2">(Saldo: <span class="saldo-componente text-green-600 font-bold">${{ number_format($componente->monto, 2) }}</span>)</span>
                        </h3>
                        <div class="actividades space-y-2 mb-4" data-componente-index="{{ $ci }}">
                            @foreach($componente->actividadesPrograma as $ai => $actividad)
                            <div class="actividad border p-3 rounded bg-gray-50">
                                <div class="flex justify-between items-center mb-1">
                                    <label class="font-semibold">Actividad {{ $ai + 1 }}</label>
                                    <span class="text-xs font-normal text-gray-500">(Saldo: <span class="saldo-actividad text-green-600 font-bold">${{ number_format($actividad->monto, 2) }}</span>)</span>
                                    <button type="button" class="eliminar-actividad ml-2 px-2 py-1 bg-red-500 text-white rounded text-xs">Eliminar Actividad</button>
                                </div>
                                <input type="text" name="componentesPrograma[{{ $ci }}][actividadesPrograma][{{ $ai }}][nombre]" class="border p-2 w-full my-1 actividad-nombre" placeholder="Nombre de la actividad" required value="{{ $actividad->nombre }}">
                                <input type="number" step="0.01" name="componentesPrograma[{{ $ci }}][actividadesPrograma][{{ $ai }}][monto]" class="border p-2 w-full mb-2 actividad-monto" placeholder="Monto de la actividad" required value="{{ $actividad->monto }}">
                                <div class="tareas space-y-1" data-comp="{{ $ci }}" data-act="{{ $ai }}">
                                    @foreach($actividad->tareasPrograma as $ti => $tarea)
                                    <div class="tarea ml-4 border-l pl-2">
                                        <div class="flex justify-between items-center">
                                            <label class="text-sm text-gray-600">Tarea {{ $ti + 1 }}</label>
                                        </div>
                                        <input type="text" name="componentesPrograma[{{ $ci }}][actividadesPrograma][{{ $ai }}][tareasPrograma][{{ $ti }}][nombre]"
                                            class="border p-1 w-full mb-1 tarea-nombre" placeholder="Nombre de la tarea" required value="{{ $tarea->nombre }}">
                                        <input type="number" step="0.01" name="componentesPrograma[{{ $ci }}][actividadesPrograma][{{ $ai }}][tareasPrograma][{{ $ti }}][monto]"
                                            class="border p-1 w-full mb-2 tarea-monto" placeholder="Monto de la tarea" required value="{{ $tarea->monto }}">
                                    </div>
                                    @endforeach
                                </div>
                                <button type="button" class="add-tarea mt-2 px-3 py-1 bg-blue-400 text-white rounded text-xs" data-comp="{{ $ci }}" data-act="{{ $ai }}">Agregar Tarea</button>
                                <div class="mensaje-sin-saldo-tarea text-red-600 font-semibold hidden">
                                    No hay saldo disponible en esta actividad para agregar más tareas.
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <button type="button" class="add-actividad mt-2 px-3 py-1 bg-blue-500 text-white rounded text-sm" data-componente-index="{{ $ci }}">Agregar Actividad</button>
                        <div class="mensaje-sin-saldo-actividad text-red-600 font-semibold hidden">
                            No hay saldo disponible en este componente para agregar más actividades.
                        </div>
                    </div>
                    @endforeach
                </div>
                <div id="matrizResumen" class="space-y-4">
                    <h4 class="font-bold text-lg mb-4">Resumen Estructurado del Programa</h4>
                    <table class="w-full table-auto border border-gray-300 text-sm">
                        <thead class="bg-gray-100 text-left">
                            <tr>
                                <th class="border px-2 py-1">Nombre</th>
                                <th class="border px-2 py-1 text-right">Valor Componente</th>
                                <th class="border px-2 py-1 text-right">Valor Actividad</th>
                                
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
        // Sincronizar ediciones de componente (nombre/monto) con cronograma y evitar componente monto > total disponible
        document.addEventListener('DOMContentLoaded', function () {
            const componentesContainer = document.getElementById('componentesContainer');
            const cronogramaContainer = document.getElementById('cronogramaContainer');
            const montoTotalInput = document.querySelector('input[name="monto_total"]');

            function formatoMoneda(v) {
                return Number(v || 0).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            }

            function obtenerMontoTotal() {
                return parseFloat(montoTotalInput.value) || 0;
            }

            function sincronizarCronogramaBloqueParaIndex(i) {
                const componenteEls = Array.from(componentesContainer.querySelectorAll('.componente'));
                const componenteEl = componenteEls[i];
                if (!componenteEl) return;
                const nombre = componenteEl.querySelector('.componente-nombre')?.value || `Componente ${i + 1}`;
                const montoVal = parseFloat(componenteEl.querySelector('.componente-monto')?.value) || 0;

                //Asegurar que el cronograma tenga bloque en el índice i
                let cronBlocks = Array.from(cronogramaContainer.children).filter(n => n.classList && n.classList.contains('border'));
                let bloque = cronBlocks[i];
                if (!bloque) {
                    // crear estructura de bloque mínima para coincidir con el diseño esperado
                    bloque = document.createElement('div');
                    bloque.className = 'border p-4 rounded shadow';
                    bloque.innerHTML = `
                        <h3 class="font-bold text-blue-700 mb-2" data-monto="0">
                            ${nombre} - Monto: $${formatoMoneda(montoVal)}
                            <span class="text-xs font-normal text-gray-500 ml-2">(Saldo: <span class="saldo-componente text-green-600 font-bold">$${formatoMoneda(montoVal)}</span>)</span>
                        </h3>
                        <div class="actividades space-y-2 mb-4" data-componente-index="${i}"></div>
                        <button type="button" class="add-actividad mt-2 px-3 py-1 bg-blue-500 text-white rounded text-sm" data-componente-index="${i}">Agregar Actividad</button>
                        <div class="mensaje-sin-saldo-actividad text-red-600 font-semibold hidden">No hay saldo disponible en este componente para agregar más actividades.</div>
                    `;
                    cronogramaContainer.appendChild(bloque);
                }

                const h3 = bloque.querySelector('h3');
                // calcular sumaActividades dentro de este bloque
                const actividadesInputs = bloque.querySelectorAll('.actividad-monto');
                let sumaActividades = 0;
                actividadesInputs.forEach(input => sumaActividades += parseFloat(input.value) || 0);
                const saldo = (montoVal - sumaActividades);

                h3.dataset.monto = montoVal;
                // actualizar innerHTML manteniendo el saldo y las clases consistentes
                const saldoHtml = `<span class="text-xs font-normal text-gray-500 ml-2">(Saldo: <span class="saldo-componente ${saldo <= 0 ? 'text-red-600' : 'text-green-600'} font-bold">$${formatoMoneda(saldo)}</span>)</span>`;
                h3.innerHTML = `${escapeHtml(nombre)} - Monto: $${formatoMoneda(montoVal)} ${saldoHtml}`;
            }

            function escapeHtml(str) {
                return String(str).replace(/[&<>"'`=\/]/g, function (s) {
                    return ({
                        '&': '&amp;',
                        '<': '&lt;',
                        '>': '&gt;',
                        '"': '&quot;',
                        "'": '&#39;',
                        '/': '&#x2F;',
                        '`': '&#x60;',
                        '=': '&#x3D;'
                    })[s];
                });
            }

            function limiteComponenteMonto(input) {
                const inputs = Array.from(componentesContainer.querySelectorAll('.componente-monto'));
                const montoTotal = obtenerMontoTotal();
                const currentVal = parseFloat(input.value) || 0;
                // suma de otros componentes
                let sumaOtros = 0;
                inputs.forEach(inp => {
                    if (inp === input) return;
                    sumaOtros += parseFloat(inp.value) || 0;
                });
                const allowedMax = Math.max(0, montoTotal - sumaOtros);
                if (currentVal > allowedMax) {
                    // ajustar al máximo permitido
                    input.value = allowedMax.toFixed(2);
                    // mostrar notificación transitoria junto al input
                    mensajeTransitorio(input, `El monto no puede superar el saldo disponible: $${formatoMoneda(allowedMax)}. Se ajustó al máximo permitido.`, 4000);
                }
            }
            function mensajeTransitorio(targetEl, text, timeout = 3000) {
                // crear elemento de mensaje pequeño
                let msg = document.createElement('div');
                msg.className = 'transient-msg text-sm text-red-600 mt-1';
                msg.style.maxWidth = '400px';
                msg.textContent = text;
                targetEl.parentNode.appendChild(msg);
                setTimeout(() => {
                    if (msg && msg.parentNode) msg.parentNode.removeChild(msg);
                }, timeout);
            }
            // Escucha de entrada delegada para sincronizar cambios en componentes
            componentesContainer.addEventListener('input', function (e) {
                const target = e.target;
                const componenteEls = Array.from(componentesContainer.querySelectorAll('.componente'));
                const parent = target.closest('.componente');
                const index = componenteEls.indexOf(parent);
                if (index === -1) return;

                if (target.classList.contains('componente-monto')) {
                    limiteComponenteMonto(target);
                    sincronizarCronogramaBloqueParaIndex(index);
                    // recalcular saldo y resumen
                    if (typeof actualizarSaldo === 'function') actualizarSaldo();
                    if (typeof generarCronogramaDesdeComponentes === 'function') generarCronogramaDesdeComponentes();
                    if (typeof generarTablaResumen === 'function') generarTablaResumen();
                } else if (target.classList.contains('componente-nombre') || target.tagName === 'TEXTAREA') {
                    // nombre o descripción cambiada -> actualizar encabezado del cronograma
                    sincronizarCronogramaBloqueParaIndex(index);
                    if (typeof generarTablaResumen === 'function') generarTablaResumen();
                }
            });
            // Observar adiciones/eliminaciones en componentesContainer para mantener cronograma en sincronía
            const mo = new MutationObserver(function (mutationsList) {
                let rebuild = false;
                for (const m of mutationsList) {
                    if (m.type === 'childList') rebuild = true;
                }
                if (!rebuild) return;
                // Asegúrese de que el cronograma tenga el mismo número de bloques que componentes.
                const componentes = Array.from(componentesContainer.querySelectorAll('.componente'));
                const cronBlocks = Array.from(cronogramaContainer.children).filter(n => n.classList && n.classList.contains('border'));
                // agregar los faltantes
                for (let i = 0; i < componentes.length; i++) {
                    if (!cronBlocks[i]) {
                        // crear bloque para este índice
                        const compNombre = componentes[i].querySelector('.componente-nombre')?.value || `Componente ${i + 1}`;
                        const compMonto = parseFloat(componentes[i].querySelector('.componente-monto')?.value) || 0;
                        const bloque = document.createElement('div');
                        bloque.className = 'border p-4 rounded shadow';
                        bloque.innerHTML = `
                            <h3 class="font-bold text-blue-700 mb-2" data-monto="${compMonto}">
                                ${escapeHtml(compNombre)} - Monto: $${formatoMoneda(compMonto)}
                                <span class="text-xs font-normal text-gray-500 ml-2">(Saldo: <span class="saldo-componente text-green-600 font-bold">$${formatoMoneda(compMonto)}</span>)</span>
                            </h3>
                            <div class="actividades space-y-2 mb-4" data-componente-index="${i}"></div>
                            <button type="button" class="add-actividad mt-2 px-3 py-1 bg-blue-500 text-white rounded text-sm" data-componente-index="${i}">Agregar Actividad</button>
                            <div class="mensaje-sin-saldo-actividad text-red-600 font-semibold hidden">No hay saldo disponible en este componente para agregar más actividades.</div>
                        `;
                        cronogramaContainer.appendChild(bloque);
                    }
                }
                // remover extras
                const newCronBlocks = Array.from(cronogramaContainer.children).filter(n => n.classList && n.classList.contains('border'));
                if (newCronBlocks.length > componentes.length) {
                    for (let j = newCronBlocks.length - 1; j >= componentes.length; j--) {
                        newCronBlocks[j].remove();
                    }
                }
                // sincronizar datos de todos los bloques existentes
                componentes.forEach((c, i) => sincronizarCronogramaBloqueParaIndex(i));
                if (typeof actualizarSaldo === 'function') actualizarSaldo();
                if (typeof generarCronogramaDesdeComponentes === 'function') generarCronogramaDesdeComponentes();
                if (typeof generarTablaResumen === 'function') generarTablaResumen();
            });
            mo.observe(componentesContainer, { childList: true, subtree: false });
            // Al cargar la página, sincronizar todos los componentes iniciales con el cronograma
            (function initialSync() {
                const componentes = Array.from(componentesContainer.querySelectorAll('.componente'));
                componentes.forEach((c, i) => sincronizarCronogramaBloqueParaIndex(i));
                if (typeof generarTablaResumen === 'function') generarTablaResumen();
            })();
        });
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
        // Inicialización del mapa con valores existentes
        const lat = parseFloat(document.getElementById('latitud').value) || -0.1807;
        const lng = parseFloat(document.getElementById('longitud').value) || -78.4678;
        const map = L.map('map').setView([lat, lng], 10);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);
        const marker = L.marker([lat, lng]).addTo(map);
        map.on('click', function(e) {
            document.getElementById('latitud').value = e.latlng.lat;
            document.getElementById('longitud').value = e.latlng.lng;
            marker.setLatLng([e.latlng.lat, e.latlng.lng]);
        });
        // Componentes
        let componenteIndex = document.querySelectorAll('.componente').length;
        document.getElementById('removeComponente').addEventListener('click', function () {
            const container = document.getElementById('componentesContainer');
            const componentes = container.querySelectorAll('.componente');
            if (componentes.length > 0) {
                if (confirm('¿Está seguro de que desea eliminar el último componente?')) {
                    container.removeChild(componentes[componentes.length - 1]);
                    componenteIndex = Math.max(0, componenteIndex - 1);
                    actualizarSaldo();
                    generarCronogramaDesdeComponentes();
                }
            }
        });

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
        const bloques = container.querySelectorAll('.border.p-4.rounded.shadow');
        bloques.forEach(bloque => {
            const montoComponente = parseFloat(bloque.querySelector('h3').dataset.monto) || 0;
            const actividadesInputs = bloque.querySelectorAll('.actividad-monto');
            let sumaActividades = 0;
            actividadesInputs.forEach(input => sumaActividades += parseFloat(input.value) || 0);
            const saldo = (montoComponente - sumaActividades).toFixed(2);
            bloque.querySelector('.saldo-componente').textContent = `$${saldo}`;
        });
        generarTablaResumen();
    }
        function generarActividad(componenteIndex, validarAgregarActividad) {
            const actividadContainer = document.querySelector(`.actividades[data-componente-index="${componenteIndex}"]`);
            const actividadIndex = actividadContainer.querySelectorAll('.actividad').length;
            const nuevaActividad = document.createElement('div');
            nuevaActividad.classList.add('actividad', 'border', 'p-3', 'rounded', 'bg-gray-50');
            nuevaActividad.innerHTML = `
                <div class="flex justify-between items-center mb-1">
                    <label class="font-semibold">Actividad ${actividadIndex + 1}</label>
                    <span class="text-xs font-normal text-gray-500">(Saldo: <span class="saldo-actividad text-green-600 font-bold">$0.00</span>)</span>
                    <button type="button" class="eliminar-actividad ml-2 px-2 py-1 bg-red-500 text-white rounded text-xs">Eliminar</button>
                </div>
                <input type="text" name="componentesPrograma[${componenteIndex}][actividadesPrograma][${actividadIndex}][nombre]" class="border p-2 w-full my-1 actividad-nombre" placeholder="Nombre de la actividad" required>
                <input type="number" step="0.01" name="componentesPrograma[${componenteIndex}][actividadesPrograma][${actividadIndex}][monto]" class="border p-2 w-full mb-2 actividad-monto" placeholder="Monto de la actividad" required>
            `;
            actividadContainer.appendChild(nuevaActividad); 
            
            nuevaActividad.querySelector('.actividad-monto').addEventListener('input', () => {
                const componenteEl = nuevaActividad.closest('.componente');
                const montoComponenteInput = componenteEl?.querySelector('.componente-monto');
                const montoComponente = parseFloat(montoComponenteInput?.value) || 0;
                const actividadesInputs = componenteEl?.querySelectorAll('.actividad-monto') || [];
                let sumaActividades = 0;
                actividadesInputs.forEach(input => sumaActividades += parseFloat(input.value) || 0);
                const saldoComponente = (montoComponente - sumaActividades).toFixed(2);
                if (componenteEl?.querySelector('.saldo-componente')) {
                    componenteEl.querySelector('.saldo-componente').textContent = `$${saldoComponente}`;
                }
            });
            
            if (typeof validarAgregarActividad === 'function') validarAgregarActividad();
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
                        </tr>
                    `;
                });
            });
        }
        document.getElementById('cronogramaContainer').addEventListener('change', generarTablaResumen);
        document.getElementById('componentesContainer').addEventListener('change', generarTablaResumen);
        window.addEventListener('DOMContentLoaded', generarTablaResumen); 
        
        // Delegación para eliminar actividades existentes y futuras
        document.getElementById('cronogramaContainer').addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('eliminar-actividad')) {
                const actividad = e.target.closest('.actividad');
                if (actividad && confirm('¿Está seguro de que desea eliminar esta actividad y todas sus tareas?')) {
                    const componenteEl = actividad.closest('.componente');
                    const montoComponenteInput = componenteEl?.querySelector('.componente-monto');
                    const montoComponente = parseFloat(montoComponenteInput?.value) || 0;
                    const actividadesInputs = componenteEl?.querySelectorAll('.actividad-monto') || [];
                    let sumaActividades = 0;
                    actividadesInputs.forEach(input => sumaActividades += parseFloat(input.value) || 0);
                    const saldoComponente = (montoComponente - sumaActividades).toFixed(2);
                    if (componenteEl?.querySelector('.saldo-componente')) {
                        componenteEl.querySelector('.saldo-componente').textContent = `$${saldoComponente}`;
                    }
                    actividad.remove();
                    if (typeof actualizarSaldo === 'function') actualizarSaldo();
                    if (typeof generarCronogramaDesdeComponentes === 'function') generarCronogramaDesdeComponentes();
                    if (typeof generarTablaResumen === 'function') generarTablaResumen();
                }
            }
        });

    });
    </script>
@endsection