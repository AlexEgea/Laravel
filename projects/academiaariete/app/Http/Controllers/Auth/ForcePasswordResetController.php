<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class ForcePasswordResetController extends Controller
{
    /**
     * Muestra el formulario para establecer la nueva contraseña
     * después de que el admin la haya reseteado.
     */
    public function create(Request $request)
    {
        $email = $request->session()->get('force_password_reset_email');

        // Si no hay email en sesión, volvemos al login
        if (!$email) {
            return redirect()->route('login');
        }

        return view('auth.force-password-reset', compact('email'));
    }

    /**
     * Guarda la nueva contraseña y limpia el flag.
     */
    public function store(Request $request): RedirectResponse
    {
        $email = $request->session()->get('force_password_reset_email');

        if (!$email) {
            return redirect()->route('login');
        }

        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::where('email', $email)->firstOrFail();

        $user->password = Hash::make($request->password);
        $user->must_reset_password = false; // 👈 ya no necesita reset
        $user->save();

        // Limpiamos el email de la sesión
        $request->session()->forget('force_password_reset_email');

        return redirect()
            ->route('login')
            ->with('status', 'Tu contraseña se ha actualizado correctamente. Ahora puedes iniciar sesión.');
    }
}
