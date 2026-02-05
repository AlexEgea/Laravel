<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\ContactoMensaje;

class ContactoController extends Controller
{
    /**
     * Muestra el formulario de contacto
     * (ruta GET /contacto -> nombre de ruta: contacto)
     */
    public function create()
    {
        return view('contacto.contacto');
    }

    /**
     * Procesa el formulario y envía el correo
     * (ruta POST /contacto -> nombre de ruta: contacto.enviar)
     */
    public function enviar(Request $request)
    {
        // Reglas + MENSAJES PERSONALIZADOS
        $data = $request->validate(
            [
                'nombre'    => ['required', 'string', 'max:100'],
                'apellidos' => ['required', 'string', 'max:150'],
                'email'     => ['required', 'email', 'max:255'],
                'telefono'  => ['required', 'regex:/^[0-9]{9}$/'],
                'asunto'    => ['required', 'string', 'max:150'],
                'mensaje'   => ['required', 'string', 'max:5000'],
                'adjunto'   => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
                'acepto'    => ['accepted'],
            ],
            [
                // NOMBRE
                'nombre.required'    => 'El nombre es obligatorio.',
                'nombre.string'      => 'El nombre debe ser un texto válido.',
                'nombre.max'         => 'El nombre no puede tener más de 100 caracteres.',

                // APELLIDOS
                'apellidos.required' => 'Los apellidos son obligatorios.',
                'apellidos.string'   => 'Los apellidos deben ser un texto válido.',
                'apellidos.max'      => 'Los apellidos no pueden tener más de 150 caracteres.',

                // EMAIL
                'email.required'     => 'El correo electrónico es obligatorio.',
                'email.email'        => 'Introduce un correo electrónico válido (debe contener "@").',
                'email.max'          => 'El correo electrónico no puede tener más de 255 caracteres.',

                // TELÉFONO
                'telefono.required'  => 'El teléfono es obligatorio.',
                'telefono.regex'     => 'El teléfono debe tener exactamente 9 dígitos.',

                // ASUNTO
                'asunto.required'    => 'El asunto es obligatorio.',
                'asunto.string'      => 'El asunto debe ser un texto válido.',
                'asunto.max'         => 'El asunto no puede tener más de 150 caracteres.',

                // MENSAJE
                'mensaje.required'   => 'El mensaje es obligatorio.',
                'mensaje.string'     => 'El mensaje debe ser un texto válido.',
                'mensaje.max'        => 'El mensaje no puede superar los 5000 caracteres.',

                // ADJUNTO
                'adjunto.file'       => 'El adjunto debe ser un archivo válido.',
                'adjunto.mimes'      => 'El adjunto debe ser un PDF o una imagen (JPG, JPEG, PNG).',
                'adjunto.max'        => 'El adjunto no puede superar los 5 MB.',

                // CONSENTIMIENTO
                'acepto.accepted'    => 'Debes aceptar la política de privacidad y el tratamiento de datos.',
            ]
        );

        // Guardar adjunto (si viene) en storage/app/public/contacto
        if ($request->hasFile('adjunto')) {
            $data['adjunto_path'] = $request->file('adjunto')->store('contacto', 'public');
        }

        // Log de prueba
        Log::info('Formulario de contacto recibido', [
            'nombre' => $data['nombre'] . ' ' . $data['apellidos'],
            'email'  => $data['email'],
            'asunto' => $data['asunto'],
        ]);

        // Envío del correo
        Mail::to('prueba@ejemplo.com') // cambia a tu correo real cuando toque
            ->send(new ContactoMensaje($data));

        return back()->with('ok', '¡Mensaje enviado! Te responderemos lo antes posible.');
    }
}
