<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PrestamoRechazadoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $nombre;
    public $idPrestamo;
    public $fechaSolicitud;
    public $motivo;

    public function __construct($nombre, $idPrestamo, $fechaSolicitud, $motivo)
    {
        $this->nombre = $nombre;
        $this->idPrestamo = $idPrestamo;
        $this->fechaSolicitud = $fechaSolicitud;
        $this->motivo = $motivo;
    }

    public function build()
    {
        return $this->markdown('emails.prestamos.rechazado');
    }
}
