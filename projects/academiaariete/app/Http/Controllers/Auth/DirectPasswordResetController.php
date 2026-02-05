<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class DirectPasswordResetController extends Controller
{
    /**
     * Mostrar formulario para cambiar la contraseña.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Actualizar directamente la contraseña del usuario.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate(
            [
                'email' => ['required', 'email', 'exists:users,email'],
                'password' => [
                    'required',
                    'confirmed',
                    Rules\Password::defaults(),
                ],
                'password_confirmation' => ['required'],
            ],
            [
                // EMAIL
                'email.required' => 'El correo electrónico es obligatorio.',
                'email.email'    => 'Introduce un correo electrónico válido.',
                'email.exists'   => 'No existe ningún usuario con ese correo electrónico.',

                // CONTRASEÑA
                'password.required'  => 'La nueva contraseña es obligatoria.',
                'password.confirmed' => 'Las contraseñas no coinciden.',

                // CONFIRMACIÓN
                'password_confirmation.required' => 'Debes confirmar la nueva contraseña.',
            ]
        );

        $user = User::where('email', $request->email)->first();

        if ($user) {
            $user->password = Hash::make($request->password);
            $user->must_reset_password = false;
            $user->save();
        }

        return redirect()
            ->route('login')
            ->with('status', 'Tu contraseña se ha actualizado correctamente. Ya puedes iniciar sesión.');
    }
}
