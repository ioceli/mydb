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
<h2 class="text-2xl font-extrabold text-gray-800 mb-6 border-b pb-2">Registrar nuevo Programa</h2>
<div class="max-w-6xl mx-auto bg-white p-8 rounded-xl shadow-2xl">
    <form action="{{ route('programa.store') }}" method="POST" class="space-y-8">
        @csrf
        <div class="sticky top-0 bg-white z-10 pt-4 -mt-4">
            @php $tabs = ['tab0' => 'Datos Iniciales', 'tab1' => 'Diagnóstico', 'tab2' => 'Alineación', 'tab3' => 'Financiamiento y Cronograma']; @endphp
            <ul class="flex flex-wrap border-b mb-6 font-extrabold text-sm sm:text-base" id="tabs">
                @foreach($tabs as $id => $tab)
                <li class="mr-2">
                    <button type="button" 
                            class="px-4 py-3 -mb-px text-center border-b-2 tab-button transition-colors duration-200 
                            {{ $loop->first ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-blue-500 hover:border-blue-300' }}" 
                            data-tab="{{ $id }}">
                        {{ $tab }}
                    </button>
                </li>
                @endforeach
            </ul>
        </div>
        <div id="tabContents">
            <div class="tab-content" id="tab0">
                <h3 class="text-xl font-bold text-gray-700 mb-4">1. Información General del Programa</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4"> 
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <label for="tipo_dictamen" class="block text-sm font-bold text-gray-700">1.1 Tipo de solicitud de dictamen</label>
                            <select name="tipo_dictamen" id="tipo_dictamen" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm p-2">
                                <option value="">-- Seleccione una opción --</option>
                                <option value="prioridad">Dictamen de prioridad</option>
                                <option value="aprobacion">Dictamen de aprobación</option>
                                <option value="actualizacion_prioridad">Actualización de prioridad</option>
                                <option value="actualizacion_aprobacion">Actualización de aprobación</option>
                            </select>
                            <p class="text-xs text-blue-500 mt-1">Define el proposito de está solicitud ante la autoridad competente.</p>
                        </div>
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <input type="hidden" name="nombre" id="nombre">
                            <label for="accion" class="block text-sm font-bold text-gray-700">1.2 ¿Qué se va a hacer?</label>
                            <select name="accion" id="accion" class="w-full border-gray-300 rounded-md shadow-sm p-2" required>
                                <option value="">Seleccione una acción</option>
                                    @foreach(['adquisición', 'construcción', 'adecuación', 'ampliación', 'dotación', 'habilitación', 'instalación', 'mejoramiento', 'implementación', 'recuperación', 'rehabilitación', 'renovación', 'reparación', 'reposicion', 'investigación', 'generación de información', 'saneamiento'] as $accion)
                                        <option value="{{ $accion }}">{{ ucfirst($accion) }}</option>
                                    @endforeach
                            </select>
                            <p class="text-xs text-blue-500 mt-1">Ej: Construcción, Mejoramiento, Adquisición.</p>
                        </div>
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <label for="objeto" class="block text-sm font-bold text-gray-700">1.3 ¿Sobre qué se va a hacer?</label>
                            <input type="text" name="objeto" id="objeto" class="w-full border-gray-300 rounded-md shadow-sm p-2" placeholder="Ej: carretera, hospital, unidad educativa" required>
                                <p class="text-xs text-blue-500 mt-1">El nombre del Programa se genera automáticamente: <span id="nombreProgramaPreview" class="font-semibold text-blue-500">...</span></p>
                        </div>   
                    </div>   
                    <div class="space-y-4">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <label class="block text-sm font-bold text-gray-700">1.4 ENTIDAD ASIGNADA</label>
                        <input class="w-full border-gray-300 rounded-md shadow-sm p-2" type="text" value="{{ $entidad->subSector }}" readonly aria-describedby="entidad-info">
                        <p id="entidad-info" class="mt-1 text-xs text-blue-500 mt-1">Este programa se asociará automáticamente a su entidad.</p>
                        {{-- <input type="hidden" name="idEntidad" value="{{ $entidad->idEntidad }}"> --}}
                    </div>
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <label class="block text-sm font-bold text-gray-700">1.5 Plazo de ejecución</label>
                        <input type="number" name="plazo_ejecucion" class="w-full border-gray-300 rounded-md shadow-sm p-2" placeholder="Ej: 12, 24" required min="1">
                            <p class="text-xs text-blue-500 mt-1">Tiempo estimado en meses para completar el programa.</p>
                    </div>
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <label class="block text-sm font-bold text-gray-700">1.6 Monto total (USD)</label>
                        <input type="number" step="0.01" name="monto_total" class="w-full border-green-300 rounded-md shadow-sm p-2 font-bold text-lg" placeholder="Ej: 150000.00" required min="0.01">
                        <p class="text-xs text-green-500 mt-1">Costo total estimado del programa. Este monto será distribuido en los componentes.</p>
                    </div>
                </div>
            </div>
        </div>
            <div class="tab-content hidden" id="tab1">
                <h3 class="text-xl font-bold text-gray-700 mb-4">2. Diagnóstico, Problema y Ubicación</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div class="mb-6 bg-blue-50 p-4 rounded-lg">
                            <label class="font-bold block mb-2 text-gray-700">2.1 Descripción de la Situación Actual del Sector</label>
                            <textarea name="diagnostico" class="w-full border-gray-300 rounded-md shadow-sm p-3" rows="4" placeholder="Describa el contexto sectorial y su estado actual."></textarea>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div class="mb-6 bg-blue-50 p-4 rounded-lg">
                            <label class="font-bold block mb-2 text-gray-700">2.2 Identificación, Descripción y Diagnóstico del Problema</label>
                            <textarea name="problema" class="w-full border-gray-300 rounded-md shadow-sm p-3" rows="4" placeholder="Defina claramente el problema que el programa busca resolver y sus causas/efectos."></textarea>
                        </div>
                    </div>
                </div>
                <div class="mb-6">
                    <h4 class="font-bold block mb-2 text-gray-700">2.3 Ubicación Geográfica e Impacto Territorial</h4>
                    <p class="text-sm text-gray-500 mb-2">Haga clic en el mapa para establecer la ubicación (Latitud y Longitud).</p>
                    <div id="map" style="height: 400px;" class="rounded-lg shadow-lg border border-gray-300"></div>
                    <div class="mt-4 flex space-x-4">
                        <div class="flex-1">
                            <label for="latitud" class="block text-sm font-semibold text-gray-700">Latitud</label>
                            <input type="text" name="latitud" id="latitud" class="w-full border-gray-300 rounded-md shadow-sm p-2" readonly placeholder="Coordenada N/S">
                        </div>
                        <div class="flex-1">
                            <label for="longitud" class="block text-sm font-semibold text-gray-700">Longitud</label>
                            <input type="text" name="longitud" id="longitud" class="w-full border-gray-300 rounded-md shadow-sm p-2" readonly placeholder="Coordenada E/O">
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-content hidden" id="tab2">
                <h3 class="text-xl font-bold text-gray-700 mb-6">3. Alineación con Planificación Nacional/Sectorial</h3>
                <div class="mb-8 bg-blue-50 p-5 rounded-lg border border-blue-200">
                    <label class="font-bold text-blue-700 block mb-3 text-lg">3.1 Objetivos Estratégicos</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                        @foreach($objetivoEstrategico as $objetivo)
                            <label class="inline-flex items-start space-x-3 cursor-pointer p-2 bg-white rounded shadow-sm hover:bg-blue-100 transition-colors">
                                <input type="checkbox" name="idObjetivoEstrategico[]" value="{{ $objetivo->idObjetivoEstrategico }}" class="form-checkbox h-5 w-5 text-blue-600 rounded mt-1">
                                <span class="text-sm text-gray-700">{{ $objetivo->descripcion }}</span>
                            </label>
                        @endforeach
                    </div>
                    <p class="text-xs text-blue-500 mt-3">Seleccione todos los objetivos estratégicos a los que el programa contribuye.</p>
                </div>
                <div class="mb-4 bg-green-50 p-5 rounded-lg border border-green-200">
                    <label class="font-bold text-green-700 block mb-3 text-lg">3.2 Alineación con Metas Estratégicas</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                        @foreach($metasEstrategicas as $meta)
                            <label class="inline-flex items-start space-x-3 cursor-pointer p-2 bg-white rounded shadow-sm hover:bg-green-100 transition-colors">
                                <input type="checkbox" name="idMetaEstrategica[]" value="{{ $meta->idMetaEstrategica }}" class="form-checkbox h-5 w-5 text-green-600 rounded mt-1">
                                <span class="text-sm text-gray-700">{{ $meta->descripcion }}</span>
                            </label>
                        @endforeach
                    </div>
                    <p class="text-xs text-green-500 mt-3">Indique las metas específicas que serán impactadas por el programa.</p>
                </div>
            </div>
            <div class="tab-content hidden" id="tab3">
                <h3 class="text-xl font-bold text-gray-700 mb-6 border-b pb-2">4. Estructura Presupuestaria y Cronograma</h3>
                <div class="flex justify-start space-x-8 mb-6 p-4 bg-indigo-50 rounded-lg shadow-inner">
                    <div class="text-lg">
                        <span class="font-bold text-indigo-700">Monto Total Programa: </span>
                        <span id="montoTotalDisplay" class="font-extrabold text-2xl text-indigo-600">$0.00</span>
                    </div>
                    <div class="text-lg">
                        <span class="font-bold text-gray-700">Saldo Restante: </span>
                        <span id="saldoRestanteDisplay" class="font-extrabold text-2xl text-green-600">$0.00</span>
                    </div>
                </div>
                <h4 class="font-bold text-lg text-gray-700 mb-3 border-b pb-1">4.1 Desglose por Componente (Presupuesto)</h4>
                <div id="componentesContainer" class="space-y-6">
                    </div>
                <button type="button" id="addComponente" class="mt-4 px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 transition duration-150 ease-in-out disabled:opacity-50 disabled:cursor-not-allowed">Agregar Componente</button>
                <div id="mensajeSinSaldo" class="mt-3 p-2 bg-red-100 text-red-700 rounded-lg font-semibold hidden"> 🛑 El saldo disponible ha sido agotado o el último componente no está completo.
                </div>
                <hr class="my-8 border-gray-200">
                <h4 class="font-bold text-lg text-gray-700 mb-4 border-b pb-1">4.2 Cronograma y Detalle de Actividades</h4>
                <div id="cronogramaContainer" class="space-y-6">
                    <p class="text-gray-500 italic">Agregue componentes para definir sus actividades.</p>
                </div>
                <hr class="my-8 border-gray-200">
                <div id="matrizResumen" class="space-y-4">
                    <h4 class="font-bold text-lg text-gray-700 mb-4">4.3 Matriz Resumen Estructurada</h4>
                    <table class="w-full table-auto border border-gray-300 text-sm rounded-lg overflow-hidden shadow-lg">
                        <thead class="bg-gray-200 text-left">
                            <tr>
                                <th class="border px-3 py-2">Estructura</th>
                                <th class="border px-3 py-2 text-right">Valor Componente (USD)</th>
                                <th class="border px-3 py-2 text-right">Valor Actividad (USD)</th>
                            </tr>
                        </thead>
                        <tbody id="tablaResumen" class="bg-white">
                            <tr><td colspan="3" class="text-center py-4 text-gray-500">Agregue componentes y actividades para ver el resumen.</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="flex justify-between pt-8 border-t border-gray-200">
            <button type="submit" class="px-6 py-2 bg-green-600 text-white font-extrabold rounded-lg shadow-lg hover:bg-green-700 transition duration-150 ease-in-out"> Guardar </button>
            <a href="{{ route('programa.index') }}" class="px-6 py-2 bg-gray-500 text-white font-bold rounded-lg shadow hover:bg-gray-600 transition duration-150 ease-in-out"> Cancelar</a>   
        </div>
    </form>
</div>
<script>
   function validarMontoComponente(input) {
    const montoTotal = parseFloat(document.querySelector('input[name="monto_total"]').value) || 0;
    const componentes = document.querySelectorAll('.componente-monto');
    let sumaOtros = 0;
    componentes.forEach(comp => {
        if (comp !== input) {
            const val = parseFloat(comp.value);
            if (!isNaN(val)) sumaOtros += val;
        }
    });
    const valorActual = parseFloat(input.value) || 0;
    if (valorActual + sumaOtros > montoTotal) {
        input.value = (montoTotal - sumaOtros > 0) ? (montoTotal - sumaOtros).toFixed(2) : 0;
        alert('El monto asignado al componente no puede superar el monto total disponible del programa.');
    }
    actualizarSaldo();
    generarCronogramaDesdeComponentes();
}
// Asignar el validador a los inputs existentes y futuros
document.addEventListener('input', function(e) {
    if (e.target.classList.contains('componente-monto')) {
        validarMontoComponente(e.target);
    } else if (e.target.classList.contains('actividad-monto')) {
        const componenteBloque = e.target.closest('.border.p-4.rounded.shadow'); 
        if (componenteBloque) {
            const evento = new Event('change', { bubbles: true });
            componenteBloque.dispatchEvent(evento);
        }
    }
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
                const saldoComponenteEl = bloque.querySelector('.saldo-componente');
                const btnAgregar = bloque.querySelector('.add-actividad');
                const mensaje = bloque.querySelector('.mensaje-sin-saldo-actividad');
                const montoComponente = parseFloat(inputMonto?.value) || 0; 
                let ultimoCompleto = true;
                const actividadesInputs = bloque.querySelectorAll('.actividad-monto');
                let sumaActividades = 0;
                let hayExceso = false;
                actividadesInputs.forEach(input => {
                    const val = parseFloat(input.value) || 0;
                    let sumaTotalConActual = sumaActividades + val;
                    if (sumaTotalConActual > montoComponente) {
                        // 2. Si el valor actual causa un exceso, se ajusta el valor del input
                        const valorMaximoPermitido = montoComponente - sumaActividades;
                        input.value = (valorMaximoPermitido > 0) ? valorMaximoPermitido.toFixed(2) : 0;
                        alert('El monto asignado a la actividad no puede superar el monto asignado al componente.');
                        hayExceso = true; // Marcamos para mostrar alerta
                    }
                    // 3. Recalculamos la suma con el valor ajustado (o el valor original si no hubo exceso)
                    sumaActividades += parseFloat(input.value) || 0; 
                });
                // Validación para el botón de agregar
                if (actividades.length > 0) {
                    const ultima = actividades[actividades.length - 1];
                    const nombre = ultima.querySelector('.actividad-nombre')?.value.trim();
                    const monto = ultima.querySelector('.actividad-monto')?.value;
                    if (!nombre || !monto || parseFloat(monto) <= 0) {
                        ultimoCompleto = false;
                    }
                }
               // Saldo
                const saldo = (montoComponente - sumaActividades).toFixed(2);
                // Actualizar Saldo Display
                saldoComponenteEl.textContent = `$${saldo}`;
                if (saldo <= 0) {
                    saldoComponenteEl.classList.add('text-red-600');
                    saldoComponenteEl.classList.remove('text-green-600');
                } else {
                    saldoComponenteEl.classList.remove('text-red-600');
                    saldoComponenteEl.classList.add('text-green-600');
                }
                // Habilitar/deshabilitar el botón
                if (parseFloat(saldo) <= 0 || !ultimoCompleto) {
                    btnAgregar.disabled = true;
                    btnAgregar.classList.add('opacity-50', 'cursor-not-allowed');
                    if (parseFloat(saldo) <= 0) {
                        mensaje.classList.remove('hidden');
                    } else {
                         mensaje.classList.add('hidden');
                    }
                } else {
                    btnAgregar.disabled = false;
                    btnAgregar.classList.remove('opacity-50', 'cursor-not-allowed');
                    mensaje.classList.add('hidden');
                }
            }
            bloque.querySelector('.add-actividad').addEventListener('click', () => generarActividad(i, validarAgregarActividad));
            bloque.addEventListener('input', validarAgregarActividad);
            bloque.addEventListener('change', validarAgregarActividad);
            validarAgregarActividad();
        });
        generarTablaResumen();
    }
    // Generar actividad
    function generarActividad(componenteIndex, validarAgregarActividad) {
        const actividadContainer = document.querySelector(`.actividades[data-componente-index="${componenteIndex}"]`);
        const actividadIndex = actividadContainer.querySelectorAll('.actividad').length;
        const nuevaActividad = document.createElement('div');
        nuevaActividad.classList.add('actividad', 'border', 'p-3', 'rounded', 'bg-gray-50');
        nuevaActividad.innerHTML = `
            <div class="flex justify-between items-center mb-1">
                <label class="font-semibold">Actividad ${actividadIndex + 1}</label>
            </div>
            <input type="text" name="componentesPrograma[${componenteIndex}][actividadesPrograma][${actividadIndex}][nombre]" class="border p-2 w-full my-1 actividad-nombre" placeholder="Nombre de la actividad" required>
            <input type="number" step="0.01" name="componentesPrograma[${componenteIndex}][actividadesPrograma][${actividadIndex}][monto]" class="border p-2 w-full mb-2 actividad-monto" placeholder="Monto de la actividad" required>
        `;
        actividadContainer.appendChild(nuevaActividad);
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
});
</script>
@endsection