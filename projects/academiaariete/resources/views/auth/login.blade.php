{{-- resources/views/auth/login.blade.php --}}
@extends('layouts.app')

@section('title', 'Iniciar sesión · Ariete')

@section('content')
<div class="auth-page">
    <div class="auth-card">
        {{-- Cabecera --}}
        <h1 class="titulo mb-4">Iniciar sesión</h1>

        {{-- Mensaje de estado (por ejemplo, "Se ha enviado el enlace de restablecimiento...") --}}
        @if (session('status'))
            <div class="auth-status" role="status">
                {{ session('status') }}
            </div>
        @endif

        {{-- Formulario --}}
        <form method="POST" action="{{ route('login') }}" class="auth-form mt-4 space-y-4">
            @csrf

            {{-- Email --}}
            <div class="form-group">
                <label for="email" class="titulo">Correo electrónico</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="email"
                    class="@error('email') is-invalid @enderror"
                >
                @error('email')
                    <p class="invalid-feedback">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div class="form-group">
                <label for="password" class="titulo">Contraseña</label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    class="@error('password') is-invalid @enderror"
                >
                @error('password')
                    <p class="invalid-feedback">{{ $message }}</p>
                @enderror
            </div>

            {{-- Recordarme + enlace recuperar --}}
            <div class="flex items-center justify-between gap-3 flex-wrap">
                <label class="flex items-center gap-2 text-sm text-slate-700">
                    <input
                        type="checkbox"
                        name="remember"
                        class="auth-remember"
                        {{ old('remember') ? 'checked' : '' }}
                    >
                    <span>Recordarme</span>
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="auth-link">
                        ¿Has olvidado la contraseña?
                    </a>
                @endif
            </div>

            {{-- Botón --}}
            <div class="pt-2">
                <button type="submit" class="btn-brand w-full justify-center">
                    Entrar
                </button>
            </div>

            {{-- Enlace a registro, si está habilitado --}}
            @if (Route::has('register'))
                <p class="auth-bottom-text">
                    ¿Aún no tienes cuenta?
                    <a href="{{ route('register') }}" class="auth-link">
                        Regístrate aquí
                    </a>
                </p>
            @endif
        </form>
    </div>
</div>
@endsection
