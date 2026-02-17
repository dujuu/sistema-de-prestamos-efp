<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PrestamoAprobadoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $nombre;
    public $idPrestamo;
    public $fechaSolicitud;
    public $motivo;
    public $equipos;

    public function __construct($nombre, $idPrestamo, $fechaSolicitud, $motivo, $equipos)
    {
        $this->nombre = $nombre;
        $this->idPrestamo = $idPrestamo;
        $this->fechaSolicitud = $fechaSolicitud;
        $this->motivo = $motivo;
        $this->equipos = $equipos;
    }

    public function build()
    {
        return $this->markdown('emails.prestamos.aprobado');
    }
}
