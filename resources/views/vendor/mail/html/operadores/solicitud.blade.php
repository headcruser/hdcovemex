@component('mail::message')
# Hola {{ $usuario->nombre }} tienes una nueva solicitud

**Solicitud de soporte:** {{ $solicitud->id}}

@component('mail::table')
|                   |                                                                              |
| ------------------|------------------------------------------------------------------------------|
| **Usuario**       |  ({{ $solicitud->empleado->usuario }})  {{$solicitud->empleado->nombre }})   |
| **Detalle**       | {{ $solicitud->incidente }}                                                  |
@endcomponent

@component('mail::button', ['url' => route('operador.gestion-solicitudes.show',$solicitud)])
Ver solicitud
@endcomponent

Atte:
{{ config('helpdesk.global.name') }}

@endcomponent
