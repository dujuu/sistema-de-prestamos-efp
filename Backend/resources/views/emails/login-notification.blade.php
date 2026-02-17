@component('mail::message')
# Nuevo inicio de sesión detectado

Hola {{ Auth::user()->name ?? 'usuario' }},

Se ha iniciado sesión en tu cuenta el **{{ now()->format('d/m/Y H:i') }}**.

Si fuiste tú, no necesitas hacer nada.  
Si no reconoces esta actividad, cambia tu contraseña inmediatamente.

@component('mail::button', ['url' => config('app.url')])
Ir al sitio
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent
