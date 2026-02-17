<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Sancion;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SancionNotificacion extends Mailable
{
    use Queueable, SerializesModels;

    public string $tipo;     // asignada, ampliada, quitada
    public User $user;
    public Sancion $sancion;
    public ?string $motivo;

    public function __construct(string $tipo, User $user, Sancion $sancion, ?string $motivo = null)
    {
        $this->tipo = $tipo;
        $this->user = $user;
        $this->sancion = $sancion;
        $this->motivo = $motivo;
    }

    public function build()
    {
        $asunto = match ($this->tipo) {
            'asignada' => 'Nueva sanción asignada',
            'ampliada' => 'Tu sanción ha sido ampliada',
            'quitada'  => 'Tu sanción ha sido levantada',
            default    => 'Notificación de sanción',
        };

        return $this->subject($asunto)
                    ->view('emails.sancion-notificacion');
    }
}
