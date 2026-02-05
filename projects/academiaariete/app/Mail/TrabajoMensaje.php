<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TrabajoMensaje extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Datos validados del formulario "Trabaja con nosotros".
     */
    public array $datos;

    /**
     * Create a new message instance.
     */
    public function __construct(array $datos)
    {
        $this->datos = $datos;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        // Asunto del correo
        $email = $this->subject('Nueva candidatura - Formulario "Trabaja con nosotros"')
                      ->view('emails.trabajo-mensaje');

        // Si hay CV subido, lo adjuntamos (desde el disco "public")
        if (!empty($this->datos['cv_path'])) {
            $email->attachFromStorageDisk('public', $this->datos['cv_path']);
        }

        return $email;
    }
}
