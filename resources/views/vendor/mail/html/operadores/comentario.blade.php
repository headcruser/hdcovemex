@component('mail::message')
# Hola {{ $usuario->nombre }}

**{{ $comment->ticket->operador->nombre }}** Agregó un nuevo Comentario en la solicitud

**Detalle:** {{  $comment->comentario }}

@component('mail::button', ['url' => route('solicitudes.show', $comment->ticket->solicitud->id)])
Ver solicitud
@endcomponent

{{ config('helpdesk.global.name') }}

@endcomponent
