@extends('layouts.app')

@section('title', 'Cambiar contraseña · Ariete')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center">
    <div class="w-full max-w-xl bg-white border border-slate-200 rounded-2xl shadow-xl px-6 py-6 md:px-8 md:py-8">

        <h1 class="titulo mb-3">Cambiar contraseña</h1>

        <p class="mb-4 text-sm text-slate-600">
            Introduce tu correo electrónico y tu nueva contraseña.
            Si la administración ha reseteado tu contraseña, aquí podrás establecer una nueva.
        </p>

        {{-- Mensaje de estado --}}
        @if (session('status'))
            <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-3 py-2 text-sm text-emerald-700">
                {{ session('status') }}
            </div>
        @endif

        {{-- Resumen de errores --}}
        @if ($errors->any())
            <div class="mb-4 rounded-lg border border-[rgba(185,28,28,0.4)] bg-[rgba(185,28,28,0.04)] px-3 py-2 text-sm text-[var(--baseariete)]">
                <p class="font-semibold mb-1">Hay errores en el formulario.</p>
                <ul class="list-disc ms-4 mb-0 text-xs md:text-[13px]">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-4" novalidate>
            @csrf

            {{-- Email --}}
            <div class="grid gap-1">
                <label for="email" class="titulo @error('email') error @enderror">
                    Correo electrónico
                </label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    class="w-full border-2 rounded-lg px-3 py-2 text-sm @error('email') is-invalid @enderror"
                    aria-invalid="@error('email') true @else false @enderror"
                    aria-describedby="@error('email') email_error @enderror"
                >
                @error('email')
                    <span id="email_error" class="invalid-feedback text-xs text-[var(--baseariete)] mt-1" role="alert">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            {{-- Nueva contraseña --}}
            <div class="grid gap-1">
                <label for="password" class="titulo @error('password') error @enderror">
                    Nueva contraseña
                </label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password"
                    class="w-full border-2 rounded-lg px-3 py-2 text-sm @error('password') is-invalid @enderror"
                    aria-invalid="@error('password') true @else false @enderror"
                    aria-describedby="@error('password') password_error @enderror"
                >
                @error('password')
                    <span id="password_error" class="invalid-feedback text-xs text-[var(--baseariete)] mt-1" role="alert">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            {{-- Confirmar contraseña --}}
            <div class="grid gap-1">
                <label for="password_confirmation" class="titulo @error('password_confirmation') error @enderror">
                    Confirmar contraseña
                </label>
                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    class="w-full border-2 rounded-lg px-3 py-2 text-sm @error('password_confirmation') is-invalid @enderror"
                    aria-invalid="@error('password_confirmation') true @else false @enderror"
                    aria-describedby="@error('password_confirmation') password_confirmation_error @enderror"
                >
                @error('password_confirmation')
                    <span id="password_confirmation_error" class="invalid-feedback text-xs text-[var(--baseariete)] mt-1" role="alert">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="mt-5 flex justify-end">
                <button type="submit" class="btn-brand inline-flex justify-center">
                    Guardar nueva contraseña
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
