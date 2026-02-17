@component('mail::message')
# Hola {{ $user->persona->Nombre ?? 'usuario' }},

Recibimos una solicitud para restablecer tu contraseña en el **Sistema de Reserva de Equipos**.

@component('mail::button', ['url' => $resetUrl])
Restablecer Contraseña
@endcomponent

Si no solicitaste este cambio, ignora este mensaje.

Atentamente,  
**El equipo del Sistema de Reserva de Equipos**
@endcomponent
