<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Mostrar formulario de registro.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Guardar nuevo usuario.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1) VALIDACIÓN
        //    Si falla, Laravel redirige de vuelta a /register con $errors y old()
        $validated = $request->validate(
            [
                // === CAMPOS OBLIGATORIOS ===
                'name'     => ['required', 'string', 'max:20'],
                'email'    => [
                    'required',
                    'string',
                    'email',
                    'max:30',
                    'unique:users,email',
                ],
                'password' => [
                    'required',
                    'confirmed',  // exige password_confirmation
                    'string',
                    'min:8',
                    'max:20',
                    // al menos una minúscula, una mayúscula, un número y un símbolo
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).+$/',
                ],
                'password_confirmation' => ['required'],

                // === CAMPOS OPCIONALES ===
                'apellidos' => ['nullable', 'string', 'max:30'],
                'telefono'  => ['nullable', 'digits:9'],
                'direccion' => ['nullable', 'string', 'max:50'],
            ],
            [
                // MENSAJES: explican cómo ponerlo bien

                // Nombre
                'name.required' => 'El nombre es obligatorio.',
                'name.max'      => 'El nombre no puede tener más de 20 caracteres.',

                // Apellidos
                'apellidos.max' => 'Los apellidos no pueden tener más de 30 caracteres.',

                // Email
                'email.required' => 'El correo electrónico es obligatorio.',
                'email.email'    => 'Introduce un correo electrónico válido que contenga "@".',
                'email.max'      => 'El correo electrónico no puede tener más de 30 caracteres.',
                'email.unique'   => 'Ya existe un usuario con ese correo electrónico.',

                // Teléfono
                'telefono.digits' => 'El teléfono debe contener exactamente 9 números.',

                // Dirección
                'direccion.max'   => 'La dirección no puede tener más de 50 caracteres.',

                // Contraseña
                'password.required'  => 'La contraseña es obligatoria.',
                'password.confirmed' => 'Las contraseñas deben coincidir.',
                'password.min'       => 'La contraseña debe tener al menos 8 caracteres.',
                'password.max'       => 'La contraseña no puede tener más de 20 caracteres.',
                'password.regex'     => 'La contraseña debe incluir mayúsculas, minúsculas, números y al menos un carácter especial.',

                // Confirmación
                'password_confirmation.required' => 'Debes confirmar la contraseña.',
            ]
        );

        try {
            // 2) CREAR USUARIO
            //    Asegúrate de que estos campos existen en la tabla `users`
            //    y en $fillable del modelo User.
            $user = User::create([
                'name'      => $validated['name'],
                'apellidos' => $validated['apellidos'] ?? null,
                'email'     => $validated['email'],
                'telefono'  => $validated['telefono'] ?? null,
                'direccion' => $validated['direccion'] ?? null,
                // El cast 'password' => 'hashed' en el modelo se encarga de encriptarla
                'password'  => $validated['password'],
            ]);

            // 3) LOGIN AUTOMÁTICO
            Auth::login($user);

            // 4) Redirigir a inicio
            return redirect()->route('inicio');

        } catch (\Throwable $e) {
            //  ❌ Si falla la BD u otra cosa, NO mostramos 500 al usuario
            Log::error('Error en el registro de usuario', [
                'mensaje' => $e->getMessage(),
            ]);

            return back()
                ->withInput()
                ->withErrors([
                    'general' => 'Ha ocurrido un error inesperado al crear tu cuenta. 
                                  Inténtalo de nuevo más tarde o contacta con la academia.',
                ]);
        }
    }
}
