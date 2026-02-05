<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\MatriculaMensaje;
use App\Models\Curso;
use App\Models\Titulacion;
use App\Models\Conocido;

class MatriculaController extends Controller
{
    /**
     * Mostrar el formulario de matrícula cargando datos desde la BD.
     *
     * Ruta en routes/web.php:
     *
     * Route::get('/matriculate', [MatriculaController::class, 'index'])->name('matriculate');
     */
    public function index()
    {
        // TITULACIONES
        $titulaciones = Titulacion::orderBy('id')->get();

        // CÓMO NOS HAS CONOCIDO
        $conocidos = Conocido::orderBy('id')->get();

        // AGRUPAR OPOSICIONES POR SECCIÓN
        $secciones = Curso::where('tipo', 'seccion')
            ->where('activo', true)
            ->orderBy('titulo')
            ->get();

        $oposicionesAgrupadas = collect();

        foreach ($secciones as $seccion) {
            $hijas = $seccion->hijos()
                ->where('tipo', 'oposicion')
                ->where('activo', true)
                ->orderBy('titulo')
                ->get();

            if ($hijas->isNotEmpty()) {
                $oposicionesAgrupadas->put($seccion->titulo, $hijas);
            }
        }

        // Oposiciones sin sección (parent_id null)
        $huerfanas = Curso::where('tipo', 'oposicion')
            ->whereNull('parent_id')
            ->where('activo', true)
            ->orderBy('titulo')
            ->get();

        if ($huerfanas->isNotEmpty()) {
            $oposicionesAgrupadas->put('Otras oposiciones', $huerfanas);
        }

        return view('matriculate.index', [
            'titulaciones'         => $titulaciones,
            'conocidos'            => $conocidos,
            'oposicionesAgrupadas' => $oposicionesAgrupadas,
        ]);
    }

    /**
     * Procesa el envío del formulario de matrícula.
     */
    public function enviar(Request $request)
    {
        // ==========================
        // VALIDACIÓN CON MENSAJES
        // ==========================
        $validated = $request->validate(
            [
                'curso_matriculacion' => ['required','string','max:50'],

                'nombre'      => ['required','string','max:100'],
                'apellido1'   => ['required','string','max:100'],
                'apellido2'   => ['required','string','max:100'],
                'dni'         => ['required','regex:/^[0-9]{8}[A-Za-z]$/'],
                'direccion'   => ['required','string','max:200'],
                'cp'          => ['required','regex:/^[0-9]{5}$/'],
                'poblacion'   => ['required','string','max:120'],
                'provincia'   => ['required','string','max:120'],
                'telefono'    => ['required','regex:/^[0-9]{9}$/'],
                'email'       => ['required','email','max:190'],
                'nacimiento'  => ['required','date'],

                'titulacion_id'   => ['required','integer','exists:titulacion,id'],
                'curso_modulo_id' => ['required','integer','exists:cursos,id'],
                'origen_id'       => ['required','integer','exists:conocido,id'],

                'origen_otros' => ['nullable','string','max:190'],

                'forma_pago'   => ['required','in:mensual,contado'],
                'observaciones'=> ['required','string','max:5000'],

                // Checkboxes RGPD
                'consiente_info'      => ['nullable'],
                'consiente_historico' => ['nullable'],
                'consiente_oferta'    => ['nullable'],

                // Aceptaciones obligatorias
                'acepta_normas'      => ['accepted'],
                'acepta_privacidad'  => ['accepted'],

                // Archivos
                'justificante' => ['required','file','mimes:pdf,jpg,jpeg,png','max:5120'],
                'adjuntos'     => ['nullable','file','mimes:pdf,jpg,jpeg,png','max:5120'],
            ],
            [
                // === Curso de matriculación ===
                'curso_matriculacion.required' => 'Debes indicar el curso de matriculación.',
                'curso_matriculacion.max'      => 'El curso de matriculación no puede tener más de 50 caracteres.',

                // === Datos personales ===
                'nombre.required'    => 'El nombre es obligatorio.',
                'nombre.max'         => 'El nombre no puede tener más de 100 caracteres.',

                'apellido1.required' => 'El primer apellido es obligatorio.',
                'apellido1.max'      => 'El primer apellido no puede tener más de 100 caracteres.',

                'apellido2.required' => 'El segundo apellido es obligatorio.',
                'apellido2.max'      => 'El segundo apellido no puede tener más de 100 caracteres.',

                'dni.required'       => 'El DNI es obligatorio.',
                'dni.regex'          => 'El DNI debe tener 8 dígitos y una letra, por ejemplo 12345678Z.',

                'direccion.required' => 'La dirección es obligatoria.',
                'direccion.max'      => 'La dirección no puede tener más de 200 caracteres.',

                'cp.required'        => 'El código postal es obligatorio.',
                'cp.regex'           => 'El código postal debe tener exactamente 5 dígitos.',

                'poblacion.required' => 'La población es obligatoria.',
                'poblacion.max'      => 'La población no puede tener más de 120 caracteres.',

                'provincia.required' => 'La provincia es obligatoria.',
                'provincia.max'      => 'La provincia no puede tener más de 120 caracteres.',

                'telefono.required'  => 'El teléfono es obligatorio.',
                'telefono.regex'     => 'El teléfono debe contener exactamente 9 dígitos, sin espacios ni guiones.',

                'email.required'     => 'El correo electrónico es obligatorio.',
                'email.email'        => 'Introduce un correo electrónico válido, por ejemplo alumno@correo.com.',
                'email.max'          => 'El correo electrónico no puede tener más de 190 caracteres.',

                'nacimiento.required'=> 'La fecha de nacimiento es obligatoria.',
                'nacimiento.date'    => 'Introduce una fecha de nacimiento válida.',

                // === Titulación / curso / origen ===
                'titulacion_id.required' => 'Selecciona tu titulación.',
                'titulacion_id.exists'   => 'La titulación seleccionada no es válida.',

                'curso_modulo_id.required' => 'Selecciona el curso o módulo de oposiciones.',
                'curso_modulo_id.exists'   => 'El curso o módulo seleccionado no es válido.',

                'origen_id.required'  => 'Indica cómo nos has conocido.',
                'origen_id.exists'    => 'La opción seleccionada en «Cómo nos has conocido» no es válida.',

                'origen_otros.max'    => 'El campo «Cuéntanos más» no puede tener más de 190 caracteres.',

                // === Forma de pago / observaciones ===
                'forma_pago.required' => 'Selecciona una forma de pago.',
                'forma_pago.in'       => 'La forma de pago seleccionada no es válida.',
                
                'observaciones.required' => 'Indica alguna observación, aunque sea breve.',
                'observaciones.max'      => 'Las observaciones no pueden superar los 5000 caracteres.',

                // === Aceptaciones ===
                'acepta_normas.accepted'     => 'Debes aceptar las normas de régimen interior.',
                'acepta_privacidad.accepted' => 'Debes aceptar la política de privacidad y el tratamiento de datos.',

                // === Archivos ===
                'justificante.required' => 'Es obligatorio adjuntar el justificante de pago.',
                'justificante.file'     => 'El justificante debe ser un archivo válido.',
                'justificante.mimes'    => 'El justificante debe ser un archivo PDF, JPG o PNG.',
                'justificante.max'      => 'El justificante no puede superar los 5 MB.',

                'adjuntos.file'  => 'Los adjuntos deben ser archivos válidos.',
                'adjuntos.mimes' => 'Los adjuntos deben ser archivos PDF, JPG o PNG.',
                'adjuntos.max'   => 'Cada archivo adjunto no puede superar los 5 MB.',
            ]
        );

        // ===============================
        // Resolver IDs → textos bonitos
        // ===============================
        $titulacion = Titulacion::find($validated['titulacion_id']);
        $conocido   = Conocido::find($validated['origen_id']);
        $curso      = Curso::find($validated['curso_modulo_id']);

        $validated['titulacion']   = $titulacion?->nombre ?? '';
        $validated['origen']       = $conocido?->nombre ?? '';
        $validated['curso_modulo'] = $curso?->titulo ?? '';

        // =================================
        // GUARDAR ARCHIVOS EN storage/public
        // =================================
        $justificantePath = null;
        if ($request->hasFile('justificante')) {
            $original = pathinfo(
                $request->file('justificante')->getClientOriginalName(),
                PATHINFO_FILENAME
            );

            $safeName = Str::slug($original, '-');
            $ext      = $request->file('justificante')->getClientOriginalExtension();

            $baseName = now()->format('Ymd_His') . '_' .
                Str::limit(Str::slug(
                    $validated['nombre'].' '.
                    $validated['apellido1'].' '.
                    $validated['apellido2']
                ), 60, '');

            $filename = $baseName . '_justificante_' . $safeName . '.' . $ext;

            $justificantePath = $request->file('justificante')->storeAs(
                'matriculas/justificantes',
                $filename,
                'public'
            );
        }

        $adjuntosPath = null;
        if ($request->hasFile('adjuntos')) {
            $original = pathinfo(
                $request->file('adjuntos')->getClientOriginalName(),
                PATHINFO_FILENAME
            );

            $safeName = Str::slug($original, '-');
            $ext      = $request->file('adjuntos')->getClientOriginalExtension();

            $baseName = now()->format('Ymd_His') . '_' .
                Str::limit(Str::slug(
                    $validated['nombre'].' '.
                    $validated['apellido1'].' '.
                    $validated['apellido2']
                ), 60, '');

            $filename = $baseName . '_adjuntos_' . $safeName . '.' . $ext;

            $adjuntosPath = $request->file('adjuntos')->storeAs(
                'matriculas/adjuntos',
                $filename,
                'public'
            );
        }

        // Normalizamos checkboxes a boolean
        $validated['consiente_info']      = $request->boolean('consiente_info');
        $validated['consiente_historico'] = $request->boolean('consiente_historico');
        $validated['consiente_oferta']    = $request->boolean('consiente_oferta');

        // Añadimos rutas de archivos a los datos
        $datos = $validated;
        $datos['justificante_path'] = $justificantePath;
        $datos['adjuntos_path']     = $adjuntosPath;

        // =================================
        // ENVÍO DEL CORREO
        // =================================
        $destino = env(
            'MAIL_TO_MATRICULA',
            env('MAIL_TO_CONTACTO', config('mail.from.address'))
        );

        try {
            Mail::to($destino)->send(new MatriculaMensaje($datos));
        } catch (\Throwable $e) {
            // logger()->error('Error enviando matrícula: '.$e->getMessage());
        }

        return back()->with(
            'ok',
            'Hemos recibido tu matrícula. En breve contactaremos contigo para confirmar tu plaza.'
        );
    }
}
