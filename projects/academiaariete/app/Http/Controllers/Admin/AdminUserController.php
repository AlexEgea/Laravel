<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class AdminUserController extends Controller
{
    /**
     * Listado de usuarios (con buscador y paginación de 20 en 20).
     */
    public function index(Request $request): View
    {
        $q = trim($request->input('q', ''));

        $usersQuery = User::with('roles')
            ->orderBy('name');

        if ($q !== '') {
            $usersQuery->where(function ($query) use ($q) {
                $query
                    ->where('name', 'like', "%{$q}%")
                    ->orWhere('apellidos', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            });
        }

        $users = $usersQuery
            ->paginate(20)
            ->withQueryString();

        return view('admin.users.index', compact('users', 'q'));
    }

    /**
     * Formulario para crear un usuario.
     */
    public function create(): View
    {
        // Roles disponibles (ajusta si tienes más)
        $roles = Role::whereIn('name', ['admin', 'profesor', 'alumno'])
            ->pluck('name', 'name');

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Guardar un nuevo usuario.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'       => ['required', 'string', 'max:20'],
            'apellidos'  => ['nullable', 'string', 'max:30'],
            'email'      => ['required', 'email', 'max:30', 'unique:users,email'],
            'telefono'   => ['nullable', 'string', 'max:15', 'regex:/^[0-9+\-\s()]*$/'],
            'direccion'  => ['nullable', 'string', 'max:50'],
            'role'       => ['required', 'in:admin,profesor,alumno'],

            'foto'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],

            // ✅ 8–20 caracteres, mayúsculas, minúsculas, números y símbolo
            'password'   => [
                'required',
                'string',
                'min:8',
                'max:20',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).+$/',
            ],
        ], [
            'name.required'      => 'El nombre es obligatorio.',
            'name.max'           => 'El nombre no puede superar los 20 caracteres.',
            'apellidos.max'      => 'Los apellidos no pueden superar los 30 caracteres.',

            'email.required'     => 'El correo electrónico es obligatorio.',
            'email.email'        => 'El correo electrónico no tiene un formato válido.',
            'email.max'          => 'El correo electrónico no puede superar los 30 caracteres.',
            'email.unique'       => 'Ya existe un usuario con ese correo electrónico.',

            'telefono.max'       => 'El teléfono no puede superar los 15 caracteres.',
            'telefono.regex'     => 'El teléfono solo puede contener números, espacios, guiones, paréntesis y el signo +.',

            'direccion.max'      => 'La dirección no puede superar los 50 caracteres.',

            'role.required'      => 'Debes seleccionar un rol.',
            'role.in'            => 'El rol seleccionado no es válido.',

            'password.required'  => 'La contraseña es obligatoria.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min'       => 'La contraseña debe tener al menos 8 caracteres.',
            'password.max'       => 'La contraseña no puede superar los 20 caracteres.',
            'password.regex'     => 'La contraseña debe incluir mayúsculas, minúsculas, números y al menos un carácter especial.',

            'foto.image'         => 'El archivo de la foto debe ser una imagen.',
            'foto.mimes'         => 'La foto debe ser un archivo JPG, JPEG, PNG o WEBP.',
            'foto.max'           => 'La foto no puede superar los 2 MB.',
        ]);

        $user = new User();
        $user->name      = $validated['name'];
        $user->apellidos = $validated['apellidos'] ?? null;
        $user->email     = $validated['email'];
        $user->telefono  = $validated['telefono'] ?? null;
        $user->direccion = $validated['direccion'] ?? null;
        $user->password  = Hash::make($validated['password']);

        // Foto de perfil
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('perfiles', 'public');
            $user->foto = $path;
        }

        $user->save();

        // Asignar rol (Spatie)
        $user->syncRoles([$validated['role']]);

        return redirect()
            ->route('admin.users.index')
            ->with('ok', 'Usuario creado correctamente.');
    }

    /**
     * Formulario para editar un usuario.
     */
    public function edit(User $user): View
    {
        // Solo el admin con ID 1 puede editar al usuario 1
        if ($user->id === 1 && Auth::id() !== 1) {
            abort(403, 'No tienes permiso para editar al administrador principal.');
        }

        $roles = Role::whereIn('name', ['admin', 'profesor', 'alumno'])
            ->pluck('name', 'name');

        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Actualizar datos del usuario (datos + rol + foto + contraseña opcional).
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        // Solo el admin con ID 1 puede actualizar al usuario 1
        if ($user->id === 1 && Auth::id() !== 1) {
            return back()->with('error', 'No tienes permiso para editar al administrador principal.');
        }

        // No permitir que un admin se quite a sí mismo el rol admin
        if (Auth::id() === $user->id && $request->input('role') !== 'admin') {
            return back()->with('error', 'No puedes quitarte a ti mismo el rol de administrador.');
        }

        $validated = $request->validate([
            'name'       => ['required', 'string', 'max:20'],
            'apellidos'  => ['nullable', 'string', 'max:30'],
            'email'      => ['required', 'email', 'max:30', 'unique:users,email,' . $user->id],
            'telefono'   => ['nullable', 'string', 'max:15', 'regex:/^[0-9+\-\s()]*$/'],
            'direccion'  => ['nullable', 'string', 'max:50'],
            'role'       => ['required', 'in:admin,profesor,alumno'],

            'foto'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],

            // Contraseña opcional, mismos criterios
            'password'   => [
                'nullable',
                'string',
                'min:8',
                'max:20',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).+$/',
            ],
        ], [
            'name.required'      => 'El nombre es obligatorio.',
            'name.max'           => 'El nombre no puede superar los 20 caracteres.',
            'apellidos.max'      => 'Los apellidos no pueden superar los 30 caracteres.',

            'email.required'     => 'El correo electrónico es obligatorio.',
            'email.email'        => 'El correo electrónico no tiene un formato válido.',
            'email.max'          => 'El correo electrónico no puede superar los 30 caracteres.',
            'email.unique'       => 'Ya existe un usuario con ese correo electrónico.',

            'telefono.max'       => 'El teléfono no puede superar los 15 caracteres.',
            'telefono.regex'     => 'El teléfono solo puede contener números, espacios, guiones, paréntesis y el signo +.',

            'direccion.max'      => 'La dirección no puede superar los 50 caracteres.',

            'role.required'      => 'Debes seleccionar un rol.',
            'role.in'            => 'El rol seleccionado no es válido.',

            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min'       => 'La contraseña debe tener al menos 8 caracteres.',
            'password.max'       => 'La contraseña no puede superar los 20 caracteres.',
            'password.regex'     => 'La contraseña debe incluir mayúsculas, minúsculas, números y al menos un carácter especial.',

            'foto.image'         => 'El archivo de la foto debe ser una imagen.',
            'foto.mimes'         => 'La foto debe ser un archivo JPG, JPEG, PNG o WEBP.',
            'foto.max'           => 'La foto no puede superar los 2 MB.',
        ]);

        // Campos básicos
        $user->name      = $validated['name'];
        $user->apellidos = $validated['apellidos'] ?? null;
        $user->email     = $validated['email'];
        $user->telefono  = $validated['telefono'] ?? null;
        $user->direccion = $validated['direccion'] ?? null;

        // Contraseña opcional
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        // Foto de perfil
        if ($request->hasFile('foto')) {
            if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
            }

            $path       = $request->file('foto')->store('perfiles', 'public');
            $user->foto = $path;
        }

        $user->save();

        // Asignar rol (Spatie)
        $user->syncRoles([$validated['role']]);

        return redirect()
            ->route('admin.users.index')
            ->with('ok', 'Usuario actualizado correctamente.');
    }

    /**
     * Eliminar usuario.
     */
    public function destroy(User $user): RedirectResponse
    {
        // Proteger SIEMPRE al admin principal (ID = 1)
        if ($user->id === 1) {
            return back()->with('error', 'El usuario administrador principal (ID 1) no se puede eliminar.');
        }

        // No permitir que un usuario se elimine a sí mismo
        if (Auth::id() === $user->id) {
            return back()->with('error', 'No puedes eliminar tu propio usuario.');
        }

        // Borrar foto si existe
        if ($user->foto && Storage::disk('public')->exists($user->foto)) {
            Storage::disk('public')->delete($user->foto);
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('ok', 'Usuario eliminado correctamente.');
    }
}
