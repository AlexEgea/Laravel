@extends('layouts.app')

@section('title', 'Verifica tu correo · Ariete')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center">
    <div class="w-full max-w-xl bg-white border border-slate-200 rounded-2xl shadow-xl px-6 py-6 md:px-8 md:py-8">

        <h1 class="titulo mb-3">Confirma tu correo electrónico</h1>

        <p class="mb-4 text-sm text-slate-600">
            Gracias por registrarte en <strong>Academia Ariete</strong>. 
            Antes de empezar a usar tu cuenta, necesitamos que verifiques tu dirección de correo
            haciendo clic en el enlace que te hemos enviado.
        </p>

        <p class="mb-6 text-sm text-slate-600">
            Si no has recibido el correo, puedes solicitar que te enviemos otro mensaje de verificación.
        </p>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-3 py-2 text-sm text-emerald-700">
                Hemos enviado un nuevo enlace de verificación al correo electrónico que indicaste en el registro.
            </div>
        @endif

        <div class="mt-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            {{-- Reenviar correo de verificación --}}
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <button type="submit" class="btn-brand inline-flex justify-center">
                    Enviar de nuevo el correo de verificación
                </button>
            </form>

            {{-- Cerrar sesión --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit"
                        class="text-sm text-slate-600 underline hover:text-slate-900 rounded-md focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[var(--baseariete)]">
                    Cerrar sesión
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
