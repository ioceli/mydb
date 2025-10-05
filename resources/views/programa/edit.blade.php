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
        {{-- Barra de Pestañas --}}
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
        {{-- Contenido de las Pestañas --}}
        <div id="tabContents">
            {{-- Pestaña 0: Datos Iniciales --}}
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
                    <input type="number" step="0.01" name="monto_total" class="w-full border rounded p-2" required value="{{ $programa->monto_total }}">
                </div>
            </div>
            {{-- Pestaña 1: Diagnóstico --}}
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
            {{-- Pestaña 2: Alineación --}}
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
            {{-- Pestaña 3: Financiamiento y Cronograma --}}
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
                {{-- Contenedor de Componentes (Financiamiento) --}}
                <div id="componentesContainer" class="space-y-4">
                    @foreach($programa->componentesPrograma as $ci => $componente)
                    <div class="componente border p-4 rounded shadow" data-componente-index="{{ $ci }}">
                        <input type="hidden" name="componentesPrograma[{{ $ci }}][idComponentePrograma]" value="{{ $componente->idComponentePrograma ?? '' }}">
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
                        <button type="button" class="remove-componente mt-2 px-3 py-1 bg-red-600 text-white rounded text-sm">Eliminar Componente</button>
                    </div>
                    @endforeach
                </div>
                <button type="button" id="addComponente" class="mt-2 px-3 py-1 bg-blue-600 text-white rounded">Agregar Componente</button>
                <div id="mensajeSinSaldo" class="mt-2 text-red-600 font-semibold hidden">
                    No hay saldo disponible para agregar más componentes.
                </div>
                <hr class="my-6">
                <h3 class="font-bold text-lg mb-4">Cronograma y Estructura</h3>
                {{-- Contenedor de Cronograma (Actividades) - Se construye en JS dinámicamente --}}
                <div id="cronogramaContainer" class="space-y-4">
                    {{-- El contenido se crea o actualiza con JavaScript --}}
                    {{-- Por compatibilidad y para inicializar el JS, se dejan los datos precargados --}}
                    @foreach($programa->componentesPrograma as $ci => $componente)
                    <div class="cronograma-bloque border p-4 rounded shadow" data-componente-index="{{ $ci }}">
                        <h3 class="font-bold text-blue-700 mb-2">
                            <span class="componente-titulo">{{ $componente->nombre }}</span> - Monto: $<span class="componente-monto-display">{{ number_format($componente->monto, 2) }}</span>
                            <span class="text-xs font-normal text-gray-500 ml-2">(Saldo: <span class="saldo-componente text-green-600 font-bold">$0.00</span>)</span>
                        </h3>
                        <div class="actividades space-y-2 mb-4" data-componente-index="{{ $ci }}">
                            @foreach($componente->actividadesPrograma as $ai => $actividad)
                            <div class="actividad border p-3 rounded bg-gray-50" data-actividad-index="{{ $ai }}">
                                <input type="hidden" name="componentesPrograma[{{ $ci }}][actividadesPrograma][{{ $ai }}][idActividadPrograma]" value="{{ $actividad->idActividadPrograma ?? '' }}">
                                <div class="flex justify-between items-center mb-1">
                                    <label class="font-semibold">Actividad {{ $ai + 1 }}</label>
                                    <button type="button" class="remove-actividad text-red-500 hover:text-red-700 text-sm font-semibold">Eliminar</button>
                                </div>
                                <input type="text" name="componentesPrograma[{{ $ci }}][actividadesPrograma][{{ $ai }}][nombre]" class="border p-2 w-full my-1 actividad-nombre" placeholder="Nombre de la actividad" required value="{{ $actividad->nombre }}">
                                <input type="number" step="0.01" name="componentesPrograma[{{ $ci }}][actividadesPrograma][{{ $ai }}][monto]" class="border p-2 w-full mb-2 actividad-monto" placeholder="Monto de la actividad" required value="{{ $actividad->monto }}">
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
                <div id="matrizResumen" class="space-y-4 pt-6">
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
        {{-- Botones de acción --}}
        <div class="flex justify-between pt-6">
            <button type="submit" class="btn btn-success font-bold bg-blue-600 text-white p-2 rounded hover:bg-blue-700">Actualizar</button>
            <a href="{{ route('programa.index') }}" class="btn btn-secondary font-bold bg-gray-500 text-white p-2 rounded hover:bg-gray-600">Volver</a>
        </div>
    </form>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Inicializa el índice para los nuevos componentes. Debe ser el siguiente al último índice existente.
    let componenteIndex = {{ count($programa->componentesPrograma) }};
    function actualizarSaldoPrograma() {
        const montoTotal = parseFloat(document.querySelector('input[name="monto_total"]').value) || 0;
        const componentes = document.querySelectorAll('.componente:not(.eliminado)');
        let sumaAsignada = 0;
        componentes.forEach(compEl => {
            const inputMonto = compEl.querySelector('.componente-monto');
            const val = parseFloat(inputMonto.value) || 0;
            // Validación de sobrepasar el monto total (si se edita el monto total)
            if (sumaAsignada + val > montoTotal) {
                inputMonto.value = (montoTotal - sumaAsignada).toFixed(2);
                alert('El monto asignado al componente no puede superar el monto total disponible del programa.');
            }
            sumaAsignada += parseFloat(inputMonto.value) || 0;
        });
        const saldo = (montoTotal - sumaAsignada);
        const saldoFixed = saldo.toFixed(2);
        document.getElementById('montoTotalDisplay').textContent = `$${montoTotal.toFixed(2)}`;
        document.getElementById('saldoRestanteDisplay').textContent = `$${saldoFixed}`;
        const saldoLabel = document.getElementById('saldoRestanteDisplay');
        const btnAgregar = document.getElementById('addComponente');
        const mensaje = document.getElementById('mensajeSinSaldo');
        // Estilo de saldo
        if (saldo <= 0) {
            saldoLabel.classList.remove('text-green-600');
            saldoLabel.classList.add('text-red-600');
            mensaje.classList.remove('hidden');
        } else {
            saldoLabel.classList.add('text-green-600');
            saldoLabel.classList.remove('text-red-600');
            mensaje.classList.add('hidden');
        }
        // Validación para habilitar/deshabilitar botón de agregar componente
        let ultimoCompleto = true;
        if (componentes.length > 0) {
            const ultimo = componentes[componentes.length - 1];
            const nombre = ultimo.querySelector('input[name$="[nombre]"]')?.value.trim();
            const monto = ultimo.querySelector('input[name$="[monto]"]')?.value;
            if (!nombre || !monto || parseFloat(monto) <= 0) {
                ultimoCompleto = false;
            }
        }
        const puedeAgregar = (saldo > 0 && ultimoCompleto);
        if (!puedeAgregar) {
            btnAgregar.disabled = true;
            btnAgregar.classList.add('opacity-50', 'cursor-not-allowed');
        } else {
            btnAgregar.disabled = false;
            btnAgregar.classList.remove('opacity-50', 'cursor-not-allowed');
        }
        actualizarCronogramaYResumen();
    }
    function actualizarSaldoComponente(bloqueCronograma) {
        const componenteIndex = bloqueCronograma.dataset.componenteIndex;
        const componenteEl = document.querySelector(`.componente[data-componente-index="${componenteIndex}"]`);
        if (!componenteEl) return; 
        const montoComponente = parseFloat(componenteEl.querySelector('.componente-monto')?.value) || 0;
        const actividades = bloqueCronograma.querySelectorAll('.actividad:not(.eliminado)');
        const btnAgregar = bloqueCronograma.querySelector('.add-actividad');
        const mensaje = bloqueCronograma.querySelector('.mensaje-sin-saldo-actividad');
        const saldoComponenteEl = bloqueCronograma.querySelector('.saldo-componente');
        const componenteTituloEl = bloqueCronograma.querySelector('.componente-titulo');
        const componenteMontoDisplayEl = bloqueCronograma.querySelector('.componente-monto-display');
        // Actualiza el título y monto del bloque del cronograma
        componenteTituloEl.textContent = componenteEl.querySelector('.componente-nombre').value;
        componenteMontoDisplayEl.textContent = montoComponente.toFixed(2);
        let sumaActividades = 0;
        let ultimoCompleto = true;
        actividades.forEach(actividadEl => {
            const inputMonto = actividadEl.querySelector('.actividad-monto');
            const val = parseFloat(inputMonto.value) || 0;
            const nombre = actividadEl.querySelector('.actividad-nombre')?.value.trim();
            // Validación de sobrepasar el monto del componente
            if (val > montoComponente - (sumaActividades)) {
                inputMonto.value = (montoComponente - sumaActividades > 0) ? (montoComponente - sumaActividades).toFixed(2) : 0;
                alert('El monto asignado a la actividad no puede superar el saldo restante del componente.');
            }
            sumaActividades += parseFloat(inputMonto.value) || 0;
            // Validación para el botón de agregar
            if (actividadEl === actividades[actividades.length - 1] && (!nombre || parseFloat(inputMonto.value) <= 0)) {
                ultimoCompleto = false;
            }
        });
        // Calcula y muestra el saldo
        const saldo = (montoComponente - sumaActividades);
        const saldoFixed = saldo.toFixed(2);
        saldoComponenteEl.textContent = `$${saldoFixed}`;
        // Estilo de saldo
        if (saldo <= 0) {
            saldoComponenteEl.classList.add('text-red-600');
            saldoComponenteEl.classList.remove('text-green-600');
            mensaje.classList.remove('hidden');
        } else {
            saldoComponenteEl.classList.remove('text-red-600');
            saldoComponenteEl.classList.add('text-green-600');
            mensaje.classList.add('hidden');
        }
        // Habilitar/deshabilitar el botón de agregar actividad
        const puedeAgregar = (saldo > 0 && ultimoCompleto);
        if (!puedeAgregar) {
            btnAgregar.disabled = true;
            btnAgregar.classList.add('opacity-50', 'cursor-not-allowed');
        } else {
            btnAgregar.disabled = false;
            btnAgregar.classList.remove('opacity-50', 'cursor-not-allowed');
        }
        generarTablaResumen(); // Actualiza la tabla de resumen al cambiar una actividad
    }
    function agregarNuevoComponente() {
        if (document.getElementById('addComponente').disabled) return;
        const container = document.getElementById('componentesContainer');
        const ci = componenteIndex; // Usa el índice actual
        const nuevo = document.createElement('div');
        nuevo.classList.add('componente', 'border', 'p-4', 'rounded', 'shadow');
        nuevo.dataset.componenteIndex = ci;
        nuevo.innerHTML = `
            <div class="mb-2">
                <label class="block text-sm font-bold">Nombre del Componente</label>
                <input type="text" name="componentesPrograma[${ci}][nombre]" class="w-full border rounded p-2 componente-nombre" required>
            </div>
            <div class="mb-2">
                <label class="block text-sm font-bold">Descripción</label>
                <textarea name="componentesPrograma[${ci}][descripcion]" class="w-full border rounded p-2" rows="3"></textarea>
            </div>
            <div class="mb-2">
                <label class="block text-sm font-bold">Monto asignado</label>
                <input type="number" step="0.01" name="componentesPrograma[${ci}][monto]" class="w-full border rounded p-2 componente-monto" required>
            </div>
            <button type="button" class="remove-componente mt-2 px-3 py-1 bg-red-600 text-white rounded text-sm">Eliminar Componente</button>
        `;
        container.appendChild(nuevo);
        componenteIndex++; // Incrementa el índice para el siguiente componente
        agregarBloqueCronograma(ci);
        actualizarSaldoPrograma();
    }
    function agregarBloqueCronograma(ci) {
        const container = document.getElementById('cronogramaContainer');
        const bloque = document.createElement('div');
        bloque.classList.add('cronograma-bloque', 'border', 'p-4', 'rounded', 'shadow');
        bloque.dataset.componenteIndex = ci;
        bloque.innerHTML = `
            <h3 class="font-bold text-blue-700 mb-2">
                <span class="componente-titulo">Componente ${ci + 1}</span> - Monto: $<span class="componente-monto-display">0.00</span>
                <span class="text-xs font-normal text-gray-500 ml-2">(Saldo: <span class="saldo-componente text-green-600 font-bold">$0.00</span>)</span>
            </h3>
            <div class="actividades space-y-2 mb-4" data-componente-index="${ci}"></div>
            <button type="button" class="add-actividad mt-2 px-3 py-1 bg-blue-500 text-white rounded text-sm" data-componente-index="${ci}">Agregar Actividad</button>
            <div class="mensaje-sin-saldo-actividad text-red-600 font-semibold hidden">
                No hay saldo disponible en este componente para agregar más actividades.
            </div>
        `;
        container.appendChild(bloque);
        // Asignar listener para el botón de agregar actividad
        bloque.querySelector('.add-actividad').addEventListener('click', function() {
            agregarNuevaActividad(ci);
        });
        // Escucha eventos en el bloque para validar el saldo del componente
        bloque.addEventListener('input', (e) => {
            if (e.target.classList.contains('actividad-monto') || e.target.classList.contains('actividad-nombre')) {
                actualizarSaldoComponente(bloque);
            }
        });
    }
    function agregarNuevaActividad(componenteIndex) {
        const actividadContainer = document.querySelector(`.actividades[data-componente-index="${componenteIndex}"]`);
        const bloqueCronograma = actividadContainer.closest('.cronograma-bloque');
        if (bloqueCronograma.querySelector('.add-actividad').disabled) return;
        const actividadIndex = actividadContainer.querySelectorAll('.actividad').length;
        const nuevaActividad = document.createElement('div');
        nuevaActividad.classList.add('actividad', 'border', 'p-3', 'rounded', 'bg-gray-50');
        nuevaActividad.dataset.actividadIndex = actividadIndex;
        nuevaActividad.innerHTML = `
            <div class="flex justify-between items-center mb-1">
                <label class="font-semibold">Actividad ${actividadIndex + 1}</label>
                <button type="button" class="remove-actividad text-red-500 hover:text-red-700 text-sm font-semibold">Eliminar</button>
            </div>
            <input type="text" name="componentesPrograma[${componenteIndex}][actividadesPrograma][${actividadIndex}][nombre]" class="border p-2 w-full my-1 actividad-nombre" placeholder="Nombre de la actividad" required>
            <input type="number" step="0.01" name="componentesPrograma[${componenteIndex}][actividadesPrograma][${actividadIndex}][monto]" class="border p-2 w-full mb-2 actividad-monto" placeholder="Monto de la actividad" required>
        `;
        actividadContainer.appendChild(nuevaActividad);
        // Inicializar el listener de eliminación para la nueva actividad
        nuevaActividad.querySelector('.remove-actividad').addEventListener('click', function() {
            eliminarActividad(nuevaActividad);
        });
        actualizarSaldoComponente(bloqueCronograma);
    }
        function eliminarComponente(componenteEl) {
        if (!confirm('¿Está seguro de eliminar este componente y todas sus actividades asociadas?')) return;
        const componenteIndex = componenteEl.dataset.componenteIndex;
        // 1. Eliminar el componente visualmente
        componenteEl.remove();
        // 2. Eliminar el bloque de cronograma asociado
        const bloqueCronograma = document.querySelector(`.cronograma-bloque[data-componente-index="${componenteIndex}"]`);
        if (bloqueCronograma) bloqueCronograma.remove();
        reindexarComponentes();
                actualizarSaldoPrograma();
    }
        function eliminarActividad(actividadEl) {
        const bloqueCronograma = actividadEl.closest('.cronograma-bloque');
        actividadEl.remove();
        reindexarActividades(bloqueCronograma);
        actualizarSaldoComponente(bloqueCronograma);
    }
        function reindexarComponentes() {
        const componentes = document.querySelectorAll('#componentesContainer .componente');
        const cronogramas = document.querySelectorAll('#cronogramaContainer .cronograma-bloque');
        componentes.forEach((compEl, newIndex) => {
            const oldIndex = compEl.dataset.componenteIndex;
            compEl.dataset.componenteIndex = newIndex;
            // Reindexar inputs del componente
            compEl.querySelectorAll('input, textarea').forEach(input => {
                input.name = input.name.replace(`componentesPrograma[${oldIndex}]`, `componentesPrograma[${newIndex}]`);
            });
            // Reindexar actividades dentro del cronograma
            const bloqueCronograma = Array.from(cronogramas).find(b => b.dataset.componenteIndex === oldIndex);
            if (bloqueCronograma) {
                bloqueCronograma.dataset.componenteIndex = newIndex;
                bloqueCronograma.querySelector('.add-actividad').dataset.componenteIndex = newIndex;
                reindexarActividades(bloqueCronograma);
            }
        });
        componenteIndex = componentes.length; // Actualiza el índice global
    }
        function reindexarActividades(bloqueCronograma) {
        const componenteIndex = bloqueCronograma.dataset.componenteIndex;
        const actividades = bloqueCronograma.querySelectorAll('.actividad');
        const actividadesContainer = bloqueCronograma.querySelector('.actividades');
        actividades.forEach((actEl, newIndex) => {
            const oldIndex = actEl.dataset.actividadIndex;
            actEl.dataset.actividadIndex = newIndex;
            // Actualizar número de actividad en la etiqueta (si existe)
            const label = actEl.querySelector('label.font-semibold');
            if(label) label.textContent = `Actividad ${newIndex + 1}`;
            // Reindexar inputs de la actividad
            actEl.querySelectorAll('input').forEach(input => {
                input.name = input.name.replace(`[actividadesPrograma][${oldIndex}]`, `[actividadesPrograma][${newIndex}]`);
            });
        });
    }
    function actualizarCronogramaYResumen() {
        const componentes = document.querySelectorAll('.componente:not(.eliminado)');
        const cronogramaContainer = document.getElementById('cronogramaContainer');
        const bloquesCronograma = document.querySelectorAll('.cronograma-bloque');
        // Mapeo para saber qué bloques existen
        const existentes = {};
        bloquesCronograma.forEach(b => {
            existentes[b.dataset.componenteIndex] = b;
        });
        // 1. Sincronizar bloques de cronograma existentes
        componentes.forEach((compEl, ci) => {
            const inputNombre = compEl.querySelector('.componente-nombre');
            const inputMonto = compEl.querySelector('.componente-monto');
            const bloque = existentes[compEl.dataset.componenteIndex];
            if (bloque) {
                // Actualizar visualización del cronograma con los nuevos datos
                bloque.querySelector('.componente-titulo').textContent = inputNombre.value;
                bloque.querySelector('.componente-monto-display').textContent = parseFloat(inputMonto.value || 0).toFixed(2);
                actualizarSaldoComponente(bloque); // Recalcular saldo de actividades
            } else {
                // Si el componente se agregó dinámicamente, agregar su bloque de cronograma
                agregarBloqueCronograma(compEl.dataset.componenteIndex);
            }
        });
        generarTablaResumen();
    }
    function generarTablaResumen() {
        const tbody = document.getElementById('tablaResumen');
        tbody.innerHTML = '';
        const componentes = document.querySelectorAll('.componente:not(.eliminado)');
        componentes.forEach((componenteEl) => {
            const ci = componenteEl.dataset.componenteIndex;
            const nombreComponente = componenteEl.querySelector('.componente-nombre')?.value || `Componente ${ci}`;
            const montoComponente = parseFloat(componenteEl.querySelector('.componente-monto')?.value || 0);
            let htmlComponente = `
                <tr>
                    <td class="border px-2 py-1 font-semibold text-gray-900">${nombreComponente}</td>
                    <td class="border px-2 py-1 text-right font-bold text-blue-600">$${montoComponente.toFixed(2)}</td>
                    <td class="border px-2 py-1"></td>
                </tr>
            `;
            tbody.innerHTML += htmlComponente;
            const actividades = document.querySelectorAll(`.cronograma-bloque[data-componente-index="${ci}"] .actividad:not(.eliminado)`);
            actividades.forEach((actividadEl, actIdx) => {
                const nombreAct = actividadEl.querySelector(`.actividad-nombre`)?.value || `Actividad ${actIdx + 1}`;
                const montoAct = parseFloat(actividadEl.querySelector(`.actividad-monto`)?.value || 0);
                
                tbody.innerHTML += `
                    <tr>
                        <td class="border px-2 py-1 pl-6 text-gray-800">== ${nombreAct}</td>
                        <td class="border px-2 py-1"></td>
                        <td class="border px-2 py-1 text-right text-green-600">$${montoAct.toFixed(2)}</td>
                    </tr>
                `;
            });
        });
    }
    // 1. Inicialización de Tabs
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
    // 2. Generación del Nombre del Programa
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
    // 3. Leaflet Map
    const initialLat = parseFloat(document.getElementById('latitud').value) || -0.1807;
    const initialLng = parseFloat(document.getElementById('longitud').value) || -78.4678;
    const map = L.map('map').setView([initialLat, initialLng], 10);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(map);
    const marker = L.marker([initialLat, initialLng]).addTo(map);
    map.on('click', function(e) {
        const lat = e.latlng.lat;
        const lng = e.latlng.lng;
        document.getElementById('latitud').value = lat;
        document.getElementById('longitud').value = lng;
        marker.setLatLng([lat, lng]);
    });
    // Listener principal para todo el contenedor de componentes (actualiza saldos del programa y cronograma)
    document.getElementById('componentesContainer').addEventListener('input', function(e) {
        if (e.target.classList.contains('componente-monto') || e.target.classList.contains('componente-nombre')) {
            actualizarSaldoPrograma();
        }
    });
    // Listener para el campo de Monto Total
    document.querySelector('input[name="monto_total"]').addEventListener('input', actualizarSaldoPrograma);
    // Botón para agregar componente
    document.getElementById('addComponente').addEventListener('click', agregarNuevoComponente);
    // Listeners de eliminación para componentes y actividades precargadas
    document.querySelectorAll('.remove-componente').forEach(btn => {
        btn.addEventListener('click', function() {
            eliminarComponente(this.closest('.componente'));
        });
    });
    document.querySelectorAll('.remove-actividad').forEach(btn => {
        btn.addEventListener('click', function() {
            eliminarActividad(this.closest('.actividad'));
        });
    });
    // Listeners de agregar actividad para los bloques de cronograma precargados
    document.querySelectorAll('.add-actividad').forEach(btn => {
        btn.addEventListener('click', function() {
            const ci = parseInt(this.dataset.componenteIndex);
            agregarNuevaActividad(ci);
        });
    });
        // Listeners de input/change para actividades precargadas
    document.querySelectorAll('.cronograma-bloque').forEach(bloque => {
        const ci = bloque.dataset.componenteIndex;
        // Asignar el listener de validación a las actividades precargadas
        bloque.addEventListener('input', (e) => {
            if (e.target.classList.contains('actividad-monto') || e.target.classList.contains('actividad-nombre')) {
                actualizarSaldoComponente(bloque);
            }
        });
    actualizarSaldoComponente(bloque);
    });
    actualizarNombre();
    actualizarSaldoPrograma();
});
</script>
@endsection