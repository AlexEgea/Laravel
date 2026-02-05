@extends('layouts.app')

@section('title', 'Restablecer contraseña · Ariete')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center">
    <div class="w-full max-w-xl bg-white border border-slate-200 rounded-2xl shadow-xl px-6 py-6 md:px-8 md:py-8">

        <h1 class="titulo mb-3">Restablecer contraseña</h1>

        <p class="mb-6 text-sm text-slate-600">
            Introduce tu correo electrónico y tu nueva contraseña. 
            Este formulario se ha abierto desde el enlace de restablecimiento que te hemos enviado por correo.
        </p>

        {{-- Errores globales --}}
        @if ($errors->any())
            <div class="mb-4 rounded-lg border border-[rgba(185,28,28,0.4)] bg-[rgba(185,28,28,0.04)] px-3 py-2 text-sm text-[var(--baseariete)]">
                <ul class="list-disc ms-4 mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
            @csrf

            {{-- Token de reseteo --}}
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            {{-- Email --}}
            <div class="grid gap-1">
                <label for="email" class="titulo">Correo electrónico</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email', $request->email) }}"
                    required
                    autofocus
                    autocomplete="username"
                    class="border-2 border-[var(--arietehover)] rounded-lg px-3 py-2 text-sm @error('email') is-invalid @enderror"
                >
                @error('email')
                    <p class="invalid-feedback text-sm text-[var(--baseariete)] mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Nueva contraseña --}}
            <div class="grid gap-1 mt-2">
                <label for="password" class="titulo">Nueva contraseña</label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password"
                    class="border-2 border-[var(--arietehover)] rounded-lg px-3 py-2 text-sm @error('password') is-invalid @enderror"
                >
                @error('password')
                    <p class="invalid-feedback text-sm text-[var(--baseariete)] mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Confirmar contraseña --}}
            <div class="grid gap-1 mt-2">
                <label for="password_confirmation" class="titulo">Confirmar contraseña</label>
                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    class="border-2 border-[var(--arietehover)] rounded-lg px-3 py-2 text-sm @error('password_confirmation') is-invalid @enderror"
                >
                @error('password_confirmation')
                    <p class="invalid-feedback text-sm text-[var(--baseariete)] mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-5 flex justify-end">
                <button type="submit" class="btn-brand inline-flex justify-center">
                    Restablecer contraseña
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
