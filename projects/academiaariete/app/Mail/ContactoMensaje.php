<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactoMensaje extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Datos del formulario (validados)
     *
     * @var array
     */
    public array $datos;

    /**
     * Recibe los datos validados del formulario de contacto.
     */
    public function __construct(array $datos)
    {
        $this->datos = $datos;
    }

    /**
     * Construye el correo.
     */
    public function build()
    {
        $mail = $this->subject('Nuevo mensaje desde el formulario de contacto')
                     ->view('emails.contacto-mensaje');

        // Si hay adjunto subido, lo añadimos al correo
        if (!empty($this->datos['adjunto_path'])) {
            $mail->attachFromStorageDisk('public', $this->datos['adjunto_path']);
        }

        return $mail;
    }
}
