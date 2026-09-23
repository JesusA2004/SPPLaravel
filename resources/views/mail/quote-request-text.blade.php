Nueva solicitud de cotización - {{ config('spp.name') }}

Nombre: {{ $quote['nombre'] }}
Correo electrónico: {{ $quote['correo'] }}
Teléfono: {{ $quote['telefono'] }}
Empresa, evento o actividad: {{ $quote['empresa'] }}

Descripción:
{{ $quote['descripcion'] ?: 'Sin descripción.' }}

Por favor, contacta a esta persona lo antes posible.
