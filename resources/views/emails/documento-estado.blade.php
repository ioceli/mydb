@component('mail::message')
# Cambio de Estado de Documento Institucional

Estimado equipo,

Les notificamos que el **{{ class_basename($instancia) }}** (ID: {{ $instancia->id }} / Entidad ID: {{ $instancia->idEntidad }}) ha sido revisado por el **{{ $rol }}**.

El nuevo estado es: **{{ $estado }}**

@if ($estado === 'Aprobado')
El documento ha sido finalizado y **aprobado**.

@component('mail::button', ['url' => url('/ruta-de-vista/' . strtolower(class_basename($instancia)) . '/' . $instancia->id), 'color' => 'success'])
Ver Documento Aprobado
@endcomponent

@else
El documento ha sido **devuelto** y requiere su atención.

@if ($observaciones)
**Observaciones del {{ $rol }}:**
{{ $observaciones }}
@endif

Por favor, acceda al sistema para realizar las correcciones necesarias y reenviar el documento.

@component('mail::button', ['url' => url('/ruta-de-edicion/' . strtolower(class_basename($instancia)) . '/' . $instancia->id . '/edit'), 'color' => 'error'])
Ir a Editar Documento
@endcomponent

@endif

Gracias,
{{ config('app.name') }}
@endcomponent