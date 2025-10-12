<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Informe Técnico de Revisión: {{ ucfirst($tipo) }} - {{ $item->nombre ?? 'Documento' }}</title>
    <style>
        body { font-family: 'Arial', sans-serif; font-size: 10pt; margin: 0; padding: 0; color: #1f2937; }
        .container { padding: 30px 40px; }
        h1 { font-size: 20pt; color: #1e40af; border-bottom: 3px solid #1e40af; padding-bottom: 8px; margin-bottom: 5px; text-transform: uppercase; }
        .subtitle { font-size: 12pt; color: #4b5563; margin-bottom: 25px; display: block; }
        h2 { font-size: 14pt; color: #374151; border-bottom: 1px solid #d1d5db; padding-bottom: 5px; margin-top: 30px; margin-bottom: 15px; font-weight: bold; }
        h3 { font-size: 11pt; color: #4b5563; margin-top: 15px; margin-bottom: 5px; border-left: 3px solid #a5b4fc; padding-left: 8px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 8px; text-align: left; vertical-align: top; border: 1px solid #ddd; }
        th { background-color: #eff6ff; color: #1e40af; font-weight: bold; font-size: 10pt; }
        /* Estilo para los bloques de información clave (similar a grid-info, pero más formal) */
        .info-block { margin-bottom: 20px; border: 1px solid #e5e7eb; border-radius: 4px; padding: 10px; background-color: #f9fafb; }
        .info-row { display: table; width: 100%; table-layout: fixed; }
        .info-cell { display: table-cell; padding: 8px 10px; border-right: 1px dashed #e5e7eb; width: 33.3%; }
        .info-cell:last-child { border-right: none; }
        .label { font-size: 8pt; font-weight: bold; text-transform: uppercase; color: #6b7280; display: block; margin-bottom: 2px; }
        .value { font-size: 10pt; color: #1f2937; white-space: pre-wrap; line-height: 1.4; }
        .section-box { border: 1px solid #d1d5db; padding: 15px; margin-bottom: 20px; border-radius: 4px; }
        .status-aprobado { background-color: #d1fae5; color: #065f46; padding: 4px 10px; border-radius: 9999px; font-weight: bold; font-size: 10pt; }
        .status-devuelto { background-color: #fee2e2; color: #991b1b; padding: 4px 10px; border-radius: 9999px; font-weight: bold; font-size: 10pt; }
        .status-pendiente { background-color: #fffbeb; color: #92400e; padding: 4px 10px; border-radius: 9999px; font-weight: bold; font-size: 10pt; }
        .componente-box { border: 1px solid #a5b4fc; background-color: #eef2ff; padding: 12px; margin-top: 15px; border-radius: 4px; }
        .actividad-box { border-left: 3px solid #6366f1; padding-left: 10px; margin-top: 8px; font-size: 9pt; background-color: #f7f9ff; padding: 8px; border-radius: 2px; }
        .list-unstyled { margin: 5px 0 10px 0; padding: 0; list-style: none; }
        .list-item { margin-bottom: 5px; border-left: 3px solid #ccc; padding-left: 8px; font-size: 9.5pt; }
        .header-date { text-align: right; font-size: 9pt; color: #6b7280; margin-bottom: 20px; }
        .monto-valor { font-weight: bold; color: #059669; font-size: 11pt; }
    </style>
</head>
<body>
    @php
    use App\Enums\EstadoRevisionEnum;
    use App\Enums\EstadoAutoridadEnum; 
    $formatCurrency = function ($amount) {
        return is_numeric($amount) ? 'US$ ' . number_format($amount, 2, '.', ',') : 'US$ -';
    };
    $primaryKey = $tipo === 'planes' ? 'idPlan' : ($tipo === 'programas' ? 'idPrograma' : 'idProyecto');
    $estadoRevisionValue = $item->estado_revision instanceof EstadoRevisionEnum 
        ? $item->estado_revision->value 
        : $item->estado_revision;
    $estadoRevision = $estadoRevisionValue ? ucfirst($estadoRevisionValue) : 'Pendiente';
    $estadoAutoridadValue = $item->estado_autoridad instanceof EstadoAutoridadEnum 
        ? $item->estado_autoridad->value 
        : $item->estado_autoridad;
    $estadoAutoridad = $estadoAutoridadValue ? ucfirst($estadoAutoridadValue) : 'N/A';
    $componentesKey = $tipo === 'programas' ? 'componentesPrograma' : ($tipo === 'proyectos' ? 'componentesProyecto' : null);
    @endphp
    <div class="container">
        <div class="header-date">
            <span style="font-weight: bold;">FECHA DE GENERACIÓN:</span> {{ date('d/m/Y H:i:s') }}
        </div>
        <h1>INFORME TÉCNICO DE REVISIÓN</h1>
        <span class="subtitle">{{ strtoupper($tipo) }}: {{ $item->nombre ?? 'DOCUMENTO SIN NOMBRE' }}</span>
        {{-- 1. Resumen Clave del Documento y Estado --}}
        <div class="info-block">
            <div class="info-row">
                <div class="info-cell" style="width: 25%;">
                    <span class="label">ID del Documento</span>
                    <span class="value" style="font-size: 13pt; font-weight: bold; color: #1e40af;">{{ $item->$primaryKey }}</span>
                </div>
                <div class="info-cell" style="width: 50%;">
                    <span class="label">Nombre del Documento</span>
                    <span class="value">{{ $item->nombre ?? '-' }}</span>
                </div>
                <div class="info-cell" style="width: 25%; border-right: none;">
                    <span class="label">Estado de Revisión</span>
                    <span class="value">
                        <span class="status-{{ strtolower($estadoRevision) }}">
                            {{ $estadoRevision }}
                        </span>
                    </span>
                </div>
            </div>
            <div class="info-row" style="margin-top: 10px; border-top: 1px dashed #e5e7eb;">
                <div class="info-cell" style="width: 50%;">
                    <span class="label">CUP / Código</span>
                    <span class="value">{{ $item->cup ?? '-' }}</span>
                </div>
                 <div class="info-cell" style="width: 50%; border-right: none;">
                    <span class="label">Monto Total Estimado</span>
                    <span class="monto-valor">
                        {{ $formatCurrency($item->monto_total) }}
                    </span>
                </div>
            </div>
        </div>
        <div class="section-box">
             <h2><span style="color: #6366f1;">•</span> Información de la Entidad Ejecutora</h2>
             <div class="info-block" style="background-color: transparent; border: none; padding: 0;">
                <div class="info-row">
                    <div class="info-cell" style="width: 33.3%;">
                        <span class="label">Entidad</span>
                        <span class="value">{{ $item->entidad->codigo ?? '-' }}</span>
                    </div>
                    <div class="info-cell" style="width: 33.3%;">
                        <span class="label">Subsector</span>
                        <span class="value">{{ $item->entidad->subSector ?? '-' }}</span>
                    </div>
                    <div class="info-cell" style="width: 33.3%; border-right: none;">
                        <span class="label">Estado por Autoridad</span>
                        <span class="value">{{ $estadoAutoridad }}</span>
                    </div>
                </div>
            </div>
        </div>
        {{-- 2. Detalles del Documento (Objetivo, Plazo, etc.) --}}
        <div class="section-box">
            <h2><span style="color: #6366f1;">•</span> Descripción y Plazo</h2>
            <div style="margin-bottom: 15px;">
                <span class="label">Objeto General del {{ ucfirst($tipo) }}</span>
                <span class="value" style="display: block; font-style: italic;">{{ $item->objeto ?? 'Sin objeto definido.' }}</span>
            </div>
            <div class="info-block" style="background-color: transparent; border: none; padding: 0;">
                <div class="info-row">
                    <div class="info-cell" style="width: 33.3%;">
                        <span class="label">Tipo de Dictamen</span>
                        <span class="value">{{ $item->tipo_dictamen ?? '-' }}</span>
                    </div>
                    <div class="info-cell" style="width: 33.3%;">
                        <span class="label">Acción (Modificación/Creación)</span>
                        <span class="value">{{ $item->accion ?? '-' }}</span>
                    </div>
                    <div class="info-cell" style="width: 33.3%; border-right: none;">
                        <span class="label">Plazo de Ejecución</span>
                        <span class="value">{{ $item->plazo_ejecucion ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>
        {{-- 3. Contexto, Ubicación y Fundamento --}}
        <div class="section-box">
            <h2><span style="color: #6366f1;">•</span> Contexto y Alcance</h2>
            <div style="margin-bottom: 10px;">
                <span class="label">Diagnóstico / Justificación</span>
                <span class="value" style="display: block;">{{ $item->diagnostico ?? 'N/A' }}</span>
            </div>
            <div style="margin-bottom: 15px;">
                <span class="label">Problema Central a Resolver</span>
                <span class="value" style="display: block;">{{ $item->problema ?? 'N/A' }}</span>
            </div>
            @if ($item->latitud || $item->longitud)
                <div class="info-block" style="border-top: 1px solid #eee; padding-top: 10px; background-color: #f0f4ff; margin-top: 15px;">
                    <div class="info-row">
                        <div class="info-cell" style="width: 50%;">
                            <span class="label">Latitud</span>
                            <span class="value">{{ $item->latitud ?? '-' }}</span>
                        </div>
                        <div class="info-cell" style="width: 50%; border-right: none;">
                            <span class="label">Longitud</span>
                            <span class="value">{{ $item->longitud ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        {{-- 4. Componentes y Actividades (Solo para Programas/Proyectos) --}}
        @if ($componentesKey && !empty($item[$componentesKey]))
            <div class="section-box">
                <h2><span style="color: #6366f1;">•</span> Estructura: Componentes y Actividades</h2>
                @foreach ($item[$componentesKey] as $index => $componente)
                    <div class="componente-box">
                        <h3 style="color: #4338ca; border-left: 3px solid #4338ca;">COMPONENTE {{ $index + 1 }}: **{{ $componente->nombre ?? 'SIN NOMBRE' }}**</h3>
                        <div class="info-row" style="margin-bottom: 5px;">
                            <div class="info-cell" style="width: 30%; padding-top: 0; padding-bottom: 0;">
                                <span class="label">Monto del Componente</span>
                                <span class="monto-valor">
                                    {{ $formatCurrency($componente->monto) }}
                                </span>
                            </div>
                            <div class="info-cell" style="width: 70%; border-right: none; padding-top: 0; padding-bottom: 0;">
                                <span class="label">Descripción</span>
                                <span class="value">{{ $componente->descripcion ?? '-' }}</span>
                            </div>
                        </div>
                        @php
                            $actividadesKey = $tipo === 'programas' ? 'actividadesPrograma' : 'actividadesProyecto';
                        @endphp
                        @if (!empty($componente[$actividadesKey]))
                            <h3 style="margin-top: 10px; border-left: 3px solid #a5b4fc; padding-left: 8px; font-size: 10pt; font-weight: bold; color: #4b5563;">Detalle de Actividades:</h3>
                            @forelse ($componente[$actividadesKey] as $actIndex => $actividad)
                                <div class="actividad-box">
                                    <span style="font-weight: bold; color: #1f2937;">{{ $actIndex + 1 }}.</span> {{ $actividad->nombre ?? 'Actividad sin nombre' }}
                                    <span style="float: right; color: #059669; font-weight: bold;">Monto: {{ $formatCurrency($actividad->monto) }}</span>
                                </div>
                            @empty
                                <p style="color: #9ca3af; font-style: italic; font-size: 9pt; margin-left: 10px;">Este componente no tiene actividades detalladas.</p>
                            @endforelse
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
        {{-- 5. Alineación Estratégica --}}
        <div class="section-box">
            <h2><span style="color: #6366f1;">•</span> Alineación y Marco Estratégico</h2>
            <h3 style="border-bottom: 1px dotted #ccc; padding-bottom: 3px;">Objetivos Estratégicos ({{ count($item->objetivos_estrategicos ?? []) }})</h3>
            <ul class="list-unstyled">
                @forelse ($item->objetivos_estrategicos ?? [] as $obj)
                    <li class="list-item">**OE:** {{ $obj->descripcion ?? $obj->nombre ?? 'Descripción no disponible' }}</li>
                @empty
                    <p style="color: #9ca3af; font-style: italic; font-size: 9pt;">Sin objetivos asociados en el registro.</p>
                @endforelse
            </ul>
            <h3 style="margin-top: 15px; border-bottom: 1px dotted #ccc; padding-bottom: 3px;">Metas Estratégicas ({{ count($item->metas_estrategicas ?? []) }})</h3>
            <ul class="list-unstyled">
                @forelse ($item->metas_estrategicas ?? [] as $meta)
                    <li class="list-item">**Meta:** {{ $meta->nombre ?? 'Nombre no disponible' }}</li>
                @empty
                    <p style="color: #9ca3af; font-style: italic; font-size: 9pt;">Sin metas asociadas en el registro.</p>
                @endforelse
            </ul>
        </div>
        {{-- 6. Resumen de Revisión --}}
        <div class="section-box" style="margin-top: 30px; border-left: 5px solid #1e40af;">
            <h2 style="border-bottom: none; margin-top: 0;"><span style="color: #1e40af;">•</span> Conclusión y Observaciones de la Revisión</h2>
            <p class="value" style="font-size: 10pt; line-height: 1.6;">
                Este informe detalla la información registrada para el **{{ strtoupper($tipo) }}** con ID **{{ $item->$primaryKey }}**.
                El estado de revisión actual es <span class="status-{{ strtolower($estadoRevision) }}" style="display: inline-block; font-size: 9pt;">{{ $estadoRevision }}</span> y el estado por autoridad es **{{ $estadoAutoridad }}**.
                El monto total del documento asciende a **{{ $formatCurrency($item->monto_total) }}**. 
            </p>
        </div>
    </div>
</body>
</html>