@extends('layouts.app')

@section('title', 'Establecer nueva contraseña · Ariete')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center">
    <div class="w-full max-w-xl bg-white border border-slate-200 rounded-2xl shadow-xl px-6 py-6 md:px-8 md:py-8">

        <h1 class="titulo mb-3">Tu contraseña ha sido reseteada</h1>

        <p class="mb-4 text-sm text-slate-600">
            Desde la administración de <strong>Academia Ariete</strong> han reseteado tu contraseña.
            Para seguir usando tu cuenta, establece una nueva contraseña a continuación.
        </p>

        @if (session('status'))
            <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-3 py-2 text-sm text-emerald-700">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 rounded-lg border border-[rgba(185,28,28,0.4)] bg-[rgba(185,28,28,0.04)] px-3 py-2 text-sm text-[var(--baseariete)]">
                <ul class="list-disc ms-4 mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.force.store') }}" class="space-y-4">
            @csrf

            {{-- Email mostrado solo a modo informativo --}}
            <div class="grid gap-1">
                <label class="titulo">Correo electrónico</label>
                <input
                    type="email"
                    value="{{ $email }}"
                    readonly
                    class="border border-slate-200 rounded-lg px-3 py-2 text-sm bg-slate-50 text-slate-600 cursor-not-allowed"
                >
            </div>

            {{-- Nueva contraseña --}}
            <div class="grid gap-1">
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

            {{-- Confirmar nueva contraseña --}}
            <div class="grid gap-1">
                <label for="password_confirmation" class="titulo">Confirmar contraseña</label>
                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    class="border-2 border-[var(--arietehover)] rounded-lg px-3 py-2 text-sm"
                >
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
