@extends('layouts.app')

@section('title', 'Registrarse · Ariete')

@section('content')
<div class="auth-page min-h-[60vh] flex items-center justify-center">
    <div class="auth-card w-full max-w-xl bg-white border border-slate-200 rounded-2xl shadow-2xl px-6 py-6 md:px-10 md:py-8">
        <h1 class="titulo mb-2">Crear cuenta</h1>

        {{-- Resumen de errores de campos --}}
        @if ($errors->any())
            @php
                // Evitamos duplicar el error "general" en el listado
                $mensajesGeneral = $errors->get('general') ?? [];
                $erroresCampos = collect($errors->all())->diff($mensajesGeneral);
            @endphp

            @if ($erroresCampos->isNotEmpty())
                <div class="auth-errors mb-4" role="alert">
                    <strong>Hay errores en el formulario.</strong>
                    <ul class="mt-1 text-sm">
                        @foreach ($erroresCampos as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        @endif

        {{-- Error general desde el controlador (try/catch) --}}
        @error('general')
            <div class="auth-errors mb-4" role="alert">
                {{ $message }}
            </div>
        @enderror

        <form
            method="POST"
            action="{{ route('register') }}"
            class="auth-form mt-2 space-y-4"
            novalidate
        >
            @csrf

            {{-- Nombre + Apellidos --}}
            <div class="grid md:grid-cols-2 gap-4">
                {{-- NOMBRE (OBLIGATORIO) --}}
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
                        autofocus
                        maxlength="20"
                        autocomplete="given-name"
                        class="w-full @error('name') is-invalid @enderror"
                        aria-invalid="@error('name') true @else false @enderror"
                        aria-describedby="@error('name') name_error @enderror"
                    >
                    @error('name')
                        <span id="name_error" class="invalid-feedback block text-xs text-red-600 mt-1" role="alert">
                            {{ $message }}
                        </span>
                    @else
                        {{-- Hueco reservado para que no se descuadre la fila --}}
                        <span class="block text-xs mt-1 invisible">placeholder</span>
                    @enderror
                </div>

                {{-- APELLIDOS (OPCIONAL) --}}
                <div class="form-group">
                    <label for="apellidos" class="titulo">Apellidos</label>
                    <input
                        id="apellidos"
                        type="text"
                        name="apellidos"
                        value="{{ old('apellidos') }}"
                        maxlength="30"
                        autocomplete="family-name"
                        class="w-full @error('apellidos') is-invalid @enderror"
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

            {{-- Email (OBLIGATORIO) --}}
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
                    class="w-full @error('email') is-invalid @enderror"
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

            {{-- Teléfono + Dirección (opcionales) --}}
            <div class="grid md:grid-cols-2 gap-4">
                <div class="form-group">
                    <label for="telefono" class="titulo">Teléfono</label>
                    <input
                        id="telefono"
                        type="tel"
                        name="telefono"
                        value="{{ old('telefono') }}"
                        maxlength="9"
                        inputmode="numeric"
                        autocomplete="tel"
                        class="w-full @error('telefono') is-invalid @enderror"
                        aria-invalid="@error('telefono') true @else false @enderror"
                        aria-describedby="@error('telefono') telefono_error @enderror"
                    >
                    @error('telefono')
                        <span id="telefono_error" class="invalid-feedback block text-xs text-red-600 mt-1" role="alert">
                            {{ $message }}
                        </span>
                    @else
                        <span class="block text-xs mt-1 invisible">placeholder</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="direccion" class="titulo">Dirección</label>
                    <input
                        id="direccion"
                        type="text"
                        name="direccion"
                        value="{{ old('direccion') }}"
                        maxlength="50"
                        autocomplete="street-address"
                        class="w-full @error('direccion') is-invalid @enderror"
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
            </div>

            {{-- Contraseña + Confirmación (OBLIGATORIAS) --}}
            <div class="space-y-4">
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
                        class="w-full @error('password') is-invalid @enderror"
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
                        class="w-full @error('password_confirmation') is-invalid @enderror"
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

            <div class="pt-3 flex flex-col gap-3">
                <button type="submit" class="btn-brand w-full justify-center">
                    Crear cuenta
                </button>

                <p class="auth-bottom-text">
                    ¿Ya tienes cuenta?
                    <a href="{{ route('login') }}" class="auth-link">
                        Inicia sesión aquí
                    </a>
                </p>
            </div>
        </form>
    </div>
</div>
@endsection
