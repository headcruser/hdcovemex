@component('mail::message')
# Hola {{$user->nombre}}

Se ha creado una cuenta para ti en <b>{{config('app.name')}}</b> Tus credenciales para accesar son:

@component('mail::table')
|                   |                       |
| ------------------|-----------------------|
| **Usuario**       | {{ $user->usuario}}   |
| **Contraseña**    | {{ $password }}       |
@endcomponent


@component('mail::button', ['url' => route('home')])
Ingresar al Sistema
@endcomponent

@endcomponent
