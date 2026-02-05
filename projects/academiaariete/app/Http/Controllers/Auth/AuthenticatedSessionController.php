<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Mostrar la vista de login.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Procesar el login.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1) Validamos los campos del formulario
        //    Si falla, Laravel redirige de vuelta a /login con $errors y los old() rellenos
        $credentials = $request->validate(
            [
                'email'    => ['required', 'email'],
                'password' => ['required', 'string'],
            ],
            [
                'email.required'    => 'El correo electrónico es obligatorio.',
                'email.email'       => 'Introduce un correo electrónico válido.',
                'password.required' => 'La contraseña es obligatoria.',
            ]
        );

        // 2) Buscar el usuario por email para comprobar si debe resetear contraseña
        $user = User::where('email', $credentials['email'])->first();

        if ($user && $user->must_reset_password) {
            // Guardamos el email en sesión para usarlo en la vista de cambio de contraseña
            $request->session()->put('force_password_reset_email', $user->email);

            return redirect()
                ->route('password.force')
                ->with('status', 'Tu contraseña ha sido reseteada por la administración. Establece una nueva para continuar.');
        }

        // 3) Intentar autenticar (login normal)
        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            // Credenciales incorrectas → volvemos al login con error en el campo email
            return back()
                ->withErrors([
                    'email' => 'El email o la contraseña son incorrectos',
                ])
                ->onlyInput('email');
        }

        // 4) Regenerar la sesión y redirigir a inicio
        $request->session()->regenerate();

        return redirect()->intended(route('inicio'));
    }

    /**
     * Cerrar sesión.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('inicio');
    }
}
