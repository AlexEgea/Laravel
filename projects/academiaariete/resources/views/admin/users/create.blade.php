{{-- resources/views/admin/users/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Crear usuario · Ariete')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center">
    <div class="w-full max-w-5xl bg-white border border-slate-200 rounded-2xl shadow-xl px-6 py-6 md:px-10 md:py-8">
        <div class="grid gap-8 md:grid-cols-[260px,1fr]">
            @php
                // Letra para el avatar de nuevo usuario (a partir del nombre tecleado)
                $nombreTmp      = old('name', 'Ariete');
                $avatarLetter   = strtoupper(mb_substr($nombreTmp, 0, 1));

                // Manejo de errores generales / de campos
                $mensajesGeneral = $errors->get('general') ?? [];
                $erroresCampos   = collect($errors->all())->diff($mensajesGeneral);
            @endphp

            {{-- Columna izquierda: info general + avatar --}}
            <div class="space-y-6 border-b md:border-b-0 md:border-r border-slate-200 pb-6 md:pb-0 md:pr-8">
                <div>
                    <h1 class="titulo mb-2">Crear usuario</h1>
                    <p class="text-sm text-slate-600">
                        Da de alta un nuevo usuario, asigna su rol y configura su contraseña.
                    </p>
                </div>

                <div class="flex flex-col items-center text-center gap-3">
                    <div class="relative">
                        <div class="h-28 w-28 rounded-full overflow-hidden border-2 border-[var(--baseariete)] shadow-md bg-slate-100 flex items-center justify-center">
                            <span class="text-3xl font-semibold text-[var(--baseariete)]">
                                {{ $avatarLetter }}
                            </span>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <p class="font-semibold text-slate-800">
                            {{ old('name') ? old('name') . ' ' . old('apellidos') : 'Nuevo usuario' }}
                        </p>

                        <p class="text-xs text-slate-500">
                            El usuario se creará con el rol que selecciones y deberá acceder con esta contraseña.
                        </p>
                    </div>

                    <p class="text-xs text-slate-500 max-w-xs">
                        La contraseña es <strong>obligatoria</strong> al crear el usuario. Más adelante podrás cambiarla desde este mismo panel.
                    </p>
                </div>
            </div>

            {{-- Columna derecha: formulario --}}
            <div>
                {{-- Mensajes flash --}}
                @if (session('ok'))
                    <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-3 py-2 text-sm text-emerald-700">
                        {{ session('ok') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 rounded-lg border border-[rgba(185,28,28,0.4)] bg-[rgba(185,28,28,0.04)] px-3 py-2 text-sm text-[var(--baseariete)]">
                        {{ session('error') }}
                    </div>
                @endif

                {{-- Error general desde el controlador (try/catch) --}}
                @error('general')
                    <div class="auth-errors mb-4" role="alert">
                        {{ $message }}
                    </div>
                @enderror

                {{-- Resumen de errores de campos --}}
                @if ($errors->any() && $erroresCampos->isNotEmpty())
                    <div class="auth-errors mb-4" role="alert">
                        <strong>Hay errores en el formulario.</strong>
                        <ul class="mt-1 text-sm">
                            @foreach ($erroresCampos as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST"
                      action="{{ route('admin.users.store') }}"
                      enctype="multipart/form-data"
                      class="space-y-5"
                      novalidate>
                    @csrf

                    {{-- Nombre + Apellidos --}}
                    <div class="grid md:grid-cols-2 gap-4">
                        {{-- NOMBRE --}}
                        <div class="form-group">
                            <label for="name" class="titulo">
                                Nombre <span class="text-red-500">*</span>
                            </label>
                            <input
                                id="name"
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                required
                                maxlength="20"
                                autocomplete="given-name"
                                class="w-full border-2 border-[var(--arietehover)] rounded-lg px-3 py-2 text-sm @error('name') is-invalid @enderror"
                                aria-invalid="@error('name') true @else false @enderror"
                                aria-describedby="@error('name') name_error @enderror"
                            >
                            @error('name')
                                <span id="name_error" class="invalid-feedback block text-xs text-red-600 mt-1" role="alert">
                                    {{ $message }}
                                </span>
                            @else
                                <span class="block text-xs mt-1 invisible">placeholder</span>
                            @enderror
                        </div>

                        {{-- APELLIDOS --}}
                        <div class="form-group">
                            <label for="apellidos" class="titulo">Apellidos</label>
                            <input
                                id="apellidos"
                                type="text"
                                name="apellidos"
                                value="{{ old('apellidos') }}"
                                maxlength="30"
                                autocomplete="family-name"
                                class="w-full border-2 border-[var(--arietehover)] rounded-lg px-3 py-2 text-sm @error('apellidos') is-invalid @enderror"
                                aria-invalid="@error('apellidos') true @else false @enderror"
                                aria-describedby="@error('apellidos') apellidos_error @enderror"
                            >
                            @error('apellidos')
                                <span id="apellidos_error" class="invalid-feedback block text-xs text-red-600 mt-1" role="alert">
                                    {{ $message }}
                                </span>
                            @else
                                <span class="block text-xs mt-1 invisible">placeholder</span>
                            @enderror
                        </div>
                    </div>

                    {{-- Email + Teléfono --}}
                    <div class="grid md:grid-cols-2 gap-4">
                        {{-- EMAIL --}}
                        <div class="form-group">
                            <label for="email" class="titulo">
                                Correo electrónico <span class="text-red-500">*</span>
                            </label>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                maxlength="30"
                                autocomplete="email"
                                class="w-full border-2 border-[var(--arietehover)] rounded-lg px-3 py-2 text-sm @error('email') is-invalid @enderror"
                                aria-invalid="@error('email') true @else false @enderror"
                                aria-describedby="@error('email') email_error @enderror"
                            >
                            @error('email')
                                <span id="email_error" class="invalid-feedback block text-xs text-red-600 mt-1" role="alert">
                                    {{ $message }}
                                </span>
                            @else
                                <span class="block text-xs mt-1 invisible">placeholder</span>
                            @enderror
                        </div>

                        {{-- TELÉFONO --}}
                        <div class="form-group">
                            <label for="telefono" class="titulo">Teléfono</label>
                            <input
                                id="telefono"
                                type="tel"
                                name="telefono"
                                value="{{ old('telefono') }}"
                                maxlength="15"
                                inputmode="tel"
                                autocomplete="tel"
                                class="w-full border-2 border-[var(--arietehover)] rounded-lg px-3 py-2 text-sm @error('telefono') is-invalid @enderror"
                                aria-invalid="@error('telefono') true @else false @enderror"
                                aria-describedby="@error('telefono') telefono_error @enderror"
                            >
                            <p class="text-[11px] text-slate-500 mt-1">
                                Puedes usar números, espacios, guiones y el signo +.
                            </p>
                            @error('telefono')
                                <span id="telefono_error" class="invalid-feedback block text-xs text-red-600 mt-1" role="alert">
                                    {{ $message }}
                                </span>
                            @else
                                <span class="block text-xs mt-1 invisible">placeholder</span>
                            @enderror
                        </div>
                    </div>

                    {{-- Dirección --}}
                    <div class="form-group">
                        <label for="direccion" class="titulo">Dirección</label>
                        <input
                            id="direccion"
                            type="text"
                            name="direccion"
                            value="{{ old('direccion') }}"
                            maxlength="50"
                            autocomplete="street-address"
                            class="w-full border-2 border-[var(--arietehover)] rounded-lg px-3 py-2 text-sm @error('direccion') is-invalid @enderror"
                            aria-invalid="@error('direccion') true @else false @enderror"
                            aria-describedby="@error('direccion') direccion_error @enderror"
                        >
                        @error('direccion')
                            <span id="direccion_error" class="invalid-feedback block text-xs text-red-600 mt-1" role="alert">
                                {{ $message }}
                            </span>
                        @else
                            <span class="block text-xs mt-1 invisible">placeholder</span>
                        @enderror
                    </div>

                    {{-- Rol --}}
                    <div class="form-group">
                        <label for="role" class="titulo">
                            Rol <span class="text-red-500">*</span>
                        </label>
                        <select
                            id="role"
                            name="role"
                            required
                            class="w-full border-2 border-[var(--arietehover)] rounded-lg px-3 py-2 text-sm @error('role') is-invalid @enderror"
                            aria-invalid="@error('role') true @else false @enderror"
                            aria-describedby="@error('role') role_error @enderror"
                        >
                            <option value="">Selecciona un rol…</option>
                            @foreach($roles as $roleNameOption => $label)
                                <option value="{{ $roleNameOption }}"
                                    {{ old('role') === $roleNameOption ? 'selected' : '' }}>
                                    {{ ucfirst($label) }}
                                </option>
                            @endforeach
                        </select>
                        @error('role')
                            <span id="role_error" class="invalid-feedback block text-xs text-red-600 mt-1" role="alert">
                                {{ $message }}
                            </span>
                        @else
                            <span class="block text-xs mt-1 invisible">placeholder</span>
                        @enderror
                    </div>

                    {{-- Contraseña (obligatoria al crear) --}}
                    <div class="grid md:grid-cols-2 gap-4">
                        {{-- PASSWORD --}}
                        <div class="form-group">
                            <label for="password" class="titulo">
                                Contraseña <span class="text-red-500">*</span>
                            </label>
                            <input
                                id="password"
                                type="password"
                                name="password"
                                required
                                autocomplete="new-password"
                                class="w-full border-2 border-[var(--arietehover)] rounded-lg px-3 py-2 text-sm @error('password') is-invalid @enderror"
                                aria-invalid="@error('password') true @else false @enderror"
                                aria-describedby="password_help @error('password') password_error @enderror"
                            >
                            <p id="password_help" class="text-[11px] text-slate-500 mt-1">
                                Entre 8 y 20 caracteres, con mayúsculas, minúsculas, números y al menos un carácter especial.
                            </p>
                            @error('password')
                                <span id="password_error" class="invalid-feedback block text-xs text-red-600 mt-1" role="alert">
                                    {{ $message }}
                                </span>
                            @else
                                <span class="block text-xs mt-1 invisible">placeholder</span>
                            @enderror
                        </div>

                        {{-- PASSWORD CONFIRMATION --}}
                        <div class="form-group">
                            <label for="password_confirmation" class="titulo">
                                Confirmar contraseña <span class="text-red-500">*</span>
                            </label>
                            <input
                                id="password_confirmation"
                                type="password"
                                name="password_confirmation"
                                required
                                autocomplete="new-password"
                                class="w-full border-2 border-[var(--arietehover)] rounded-lg px-3 py-2 text-sm @error('password_confirmation') is-invalid @enderror"
                                aria-invalid="@error('password_confirmation') true @else false @enderror"
                                aria-describedby="@error('password_confirmation') password_confirmation_error @enderror"
                            >
                            @error('password_confirmation')
                                <span id="password_confirmation_error" class="invalid-feedback block text-xs text-red-600 mt-1" role="alert">
                                    {{ $message }}
                                </span>
                            @else
                                <span class="block text-xs mt-1 invisible">placeholder</span>
                            @enderror
                        </div>
                    </div>

                    {{-- Foto --}}
                    <div class="form-group">
                        <label for="foto" class="titulo">Foto de perfil (opcional)</label>
                        <input
                            id="foto"
                            type="file"
                            name="foto"
                            accept="image/*"
                            class="block w-full text-sm text-slate-600
                                   file:mr-4 file:py-2 file:px-4
                                   file:rounded-md file:border-0
                                   file:text-sm file:font-semibold
                                   file:bg-[var(--baseariete)] file:text-white
                                   hover:file:bg-[var(--arietehover)] @error('foto') is-invalid @enderror"
                            aria-invalid="@error('foto') true @else false @enderror"
                            aria-describedby="@error('foto') foto_error @enderror"
                        >
                        @error('foto')
                            <span id="foto_error" class="invalid-feedback block text-xs text-red-600 mt-1" role="alert">
                                {{ $message }}
                            </span>
                        @else
                            <span class="block text-xs mt-1 invisible">placeholder</span>
                        @enderror
                    </div>

                    <div class="pt-4 flex justify-center gap-3">
                        <a href="{{ route('admin.users.index') }}"
                           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-slate-300 bg-white text-sm text-slate-700 hover:bg-slate-100 hover:border-slate-400 transition">
                            <i class="fa-solid fa-arrow-left-long text-xs"></i>
                            <span>Cancelar</span>
                        </a>

                        <button type="submit"
                                class="btn-brand inline-flex items-center justify-center gap-2">
                            <i class="fa-solid fa-floppy-disk text-xs"></i>
                            <span>Crear usuario</span>
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
