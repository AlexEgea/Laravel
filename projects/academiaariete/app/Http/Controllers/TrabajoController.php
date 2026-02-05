<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\TrabajoMensaje;

class TrabajoController extends Controller
{
    public function create()
    {
        // Vista: resources/views/contacto/trabaja-con-nosotros.blade.php
        return view('contacto.trabaja-con-nosotros');
    }

    public function store(Request $request)
    {
        // Validación con mensajes personalizados
        $validated = $request->validate(
            [
                'perfil'   => ['required', Rule::in(['docente','no_docente'])],

                'nombre'   => ['required','string','max:120'],
                'apellidos'=> ['required','string','max:160'],
                'telefono' => ['required','regex:/^[0-9]{9}$/'],
                'email'    => ['required','email','max:190'],
                'poblacion'=> ['required','string','max:120'],
                'provincia'=> ['required','string','max:120'],
                'direccion'=> ['required','string','max:190'],
                'cp'       => ['required','regex:/^[0-9]{5}$/'],

                'areas'    => ['required','array','min:1'],
                'areas.*'  => ['string','max:190'],

                'mensaje'  => ['required','string','min:10'],

                // CV opcional (5 MB máx)
                'cv'       => ['nullable','file','mimes:pdf,doc,docx','max:5120'],

                'acepta_privacidad' => ['accepted'],
            ],
            [
                // PERFIL
                'perfil.required' => 'Debes indicar si tu perfil es docente o no docente.',
                'perfil.in'       => 'El perfil seleccionado no es válido.',

                // NOMBRE
                'nombre.required' => 'El nombre es obligatorio.',
                'nombre.max'      => 'El nombre no puede tener más de 120 caracteres.',

                // APELLIDOS
                'apellidos.required' => 'Los apellidos son obligatorios.',
                'apellidos.max'      => 'Los apellidos no pueden tener más de 160 caracteres.',

                // TELÉFONO
                'telefono.required' => 'El teléfono es obligatorio.',
                'telefono.regex'    => 'El teléfono debe tener exactamente 9 dígitos.',

                // EMAIL
                'email.required' => 'El correo electrónico es obligatorio.',
                'email.email'    => 'Introduce un correo electrónico válido (debe contener "@").',
                'email.max'      => 'El correo electrónico no puede tener más de 190 caracteres.',

                // POBLACIÓN
                'poblacion.required' => 'La población es obligatoria.',
                'poblacion.max'      => 'La población no puede tener más de 120 caracteres.',

                // PROVINCIA
                'provincia.required' => 'La provincia es obligatoria.',
                'provincia.max'      => 'La provincia no puede tener más de 120 caracteres.',

                // DIRECCIÓN
                'direccion.required' => 'La dirección es obligatoria.',
                'direccion.max'      => 'La dirección no puede tener más de 190 caracteres.',

                // CÓDIGO POSTAL
                'cp.required' => 'El código postal es obligatorio.',
                'cp.regex'    => 'El código postal debe tener exactamente 5 dígitos.',

                // ÁREAS
                'areas.required' => 'Selecciona al menos un área profesional.',
                'areas.array'    => 'El formato de las áreas seleccionadas no es válido.',
                'areas.min'      => 'Selecciona al menos un área profesional.',
                'areas.*.max'    => 'Alguna de las áreas seleccionadas es demasiado larga.',

                // MENSAJE
                'mensaje.required' => 'El mensaje de presentación es obligatorio.',
                'mensaje.min'      => 'El mensaje de presentación debe tener al menos 10 caracteres.',

                // CV
                'cv.mimes' => 'El currículum debe estar en formato PDF, DOC o DOCX.',
                'cv.max'   => 'El currículum no puede superar los 5 MB.',

                // PRIVACIDAD
                'acepta_privacidad.accepted' => 'Debes aceptar la política de privacidad para enviar tu candidatura.',
            ]
        );

        // Guardado de CV (si se adjunta)
        $cvPath = null;
        if ($request->hasFile('cv')) {
            // Ruta: storage/app/public/candidaturas/...
            $original = pathinfo($request->file('cv')->getClientOriginalName(), PATHINFO_FILENAME);
            $safeName = Str::slug($original, '-');
            $ext      = $request->file('cv')->getClientOriginalExtension();

            $filename = now()->format('Ymd_His') . '_' .
                        Str::limit(Str::slug($validated['nombre'].' '.$validated['apellidos']), 60, '') .
                        '_' . $safeName . '.' . $ext;

            $cvPath = $request->file('cv')->storeAs('candidaturas', $filename, 'public');
        }

        // Preparar datos para el correo
        $datos = $validated;
        if ($cvPath) {
            $datos['cv_path'] = $cvPath;
        }

        // Enviar email a la academia
        Mail::to('info@ariete.org')->send(new TrabajoMensaje($datos));

        // Mensaje de confirmación
        return back()->with(
            'ok',
            'Hemos recibido tu candidatura correctamente. Revisaremos tu perfil y te contactaremos si encaja con nuestros procesos de selección.'
        );
    }
}
