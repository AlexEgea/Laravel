@extends('layouts.app')

@section('title', 'Confirmar contraseña · Ariete')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center">
    <div class="w-full max-w-xl bg-white border border-slate-200 rounded-2xl shadow-xl px-6 py-6 md:px-8 md:py-8">

        <h1 class="titulo mb-3">Confirmar contraseña</h1>

        <p class="mb-4 text-sm text-slate-600">
            Estás accediendo a una zona segura de la aplicación. 
            Por seguridad, necesitamos que confirmes tu contraseña antes de continuar.
        </p>

        {{-- Errores --}}
        @if ($errors->any())
            <div class="mb-4 rounded-lg border border-[rgba(185,28,28,0.4)] bg-[rgba(185,28,28,0.04)] px-3 py-2 text-sm text-[var(--baseariete)]">
                <ul class="list-disc ms-4 mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
            @csrf

            {{-- Contraseña actual --}}
            <div class="grid gap-1">
                <label for="password" class="titulo">Contraseña</label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    class="border-2 border-[var(--arietehover)] rounded-lg px-3 py-2 text-sm @error('password') is-invalid @enderror"
                >
                @error('password')
                    <p class="invalid-feedback text-sm text-[var(--baseariete)] mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-5 flex justify-end">
                <button type="submit" class="btn-brand inline-flex justify-center">
                    Confirmar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
