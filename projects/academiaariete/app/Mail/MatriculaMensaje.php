<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MatriculaMensaje extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Datos validados del formulario de matrícula.
     *
     * @var array
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
        $email = $this->subject('Nueva matrícula online')
                      ->view('emails.matricula-mensaje');

        // Adjuntamos justificante si existe
        if (!empty($this->datos['justificante_path'])) {
            $email->attachFromStorageDisk('public', $this->datos['justificante_path'], 'justificante_pago.pdf');
        }

        // Adjuntamos documentación opcional si existe
        if (!empty($this->datos['adjuntos_path'])) {
            $email->attachFromStorageDisk('public', $this->datos['adjuntos_path'], 'documentacion_adicional.pdf');
        }

        return $email;
    }
}
