<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Mostrar el formulario de perfil del usuario.
     */
    public function edit(Request $request): View
    {
        return view('perfil.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Actualizar la información de perfil del usuario.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        // Validación (datos de perfil + contraseña opcional + foto opcional)
        $validated = $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'apellidos' => ['nullable', 'string', 'max:255'],
            'email'     => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'direccion' => ['nullable', 'string', 'max:255'],
            'telefono'  => ['nullable', 'string', 'max:50'],

            // Contraseña solo si se rellena
            'password'  => ['nullable', 'confirmed', Password::defaults()],

            // Foto de perfil
            'foto'      => ['nullable', 'image', 'max:2048'], // máx. 2MB
        ]);

        // Asignar campos básicos
        $user->name      = $validated['name'];
        $user->apellidos = $validated['apellidos'] ?? null;
        $user->email     = $validated['email'];
        $user->direccion = $validated['direccion'] ?? null;
        $user->telefono  = $validated['telefono'] ?? null;

        // Si el usuario ha rellenado una nueva contraseña
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        // Si el usuario ha subido una nueva foto
        if ($request->hasFile('foto')) {
            // Borrar la foto anterior si existe
            if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
            }

            // Guardar la nueva en storage/app/public/perfiles
            // y en BD solo guardamos "perfiles/xxxx.ext"
            $ruta = $request->file('foto')->store('perfiles', 'public');
            $user->foto = $ruta;
        }

        $user->save();

        return Redirect::route('perfil.edit')->with('status', 'profile-updated');
    }

    /**
     * Eliminar la cuenta del usuario actual.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = $request->user();

        // Confirmar contraseña antes de borrar la cuenta
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        Auth::logout();

        // Borrar también la foto del disco si existe
        if ($user->foto && Storage::disk('public')->exists($user->foto)) {
            Storage::disk('public')->delete($user->foto);
        }

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
