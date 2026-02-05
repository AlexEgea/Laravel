@extends('layouts.app')
@section('title', 'Acceso no permitido · Ariete')

{{-- Acceso no permitido --}}

@section('content')
<section class="panel-page min-h-[60vh] flex items-center justify-center">
  <div class="w-full max-w-3xl bg-white border border-slate-200 rounded-2xl shadow-xl px-6 py-8 md:px-10 md:py-10 text-center">

    {{-- Icono / badge superior --}}
    <div class="mb-4">
      <span class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-amber-100 text-amber-600 text-3xl">
        <i class="fa-solid fa-lock"></i>
      </span>
    </div>

    {{-- Código grande + texto de error centrados --}}
    <div class="mb-4 text-center flex flex-col items-center justify-center">
      <p class="text-5xl md:text-6xl font-black tracking-[0.2em] text-slate-300 mb-2 select-none text-center">
        403
      </p>

      <p class="text-[11px] md:text-xs uppercase tracking-[0.3em] text-slate-400 mb-3 text-center">
        Error 403 · Acceso no permitido
      </p>
    </div>

    <h1 class="titulo mb-3">
      No tienes permiso para acceder aquí
    </h1>

    <div class="flex flex-wrap gap-3 justify-center">
      <a href="{{ route('inicio') }}"
         class="btn-brand px-5 py-2.5 text-sm font-semibold">
        <i class="fa-solid fa-house me-2"></i>
        Ir al inicio
      </a>

      @auth
        <a href="{{ route('contacto') }}"
           class="btn-brand px-5 py-2.5 text-sm font-semibold">
          <i class="fa-solid fa-envelope me-2"></i>
          Contactar con la academia
        </a>
      @else
        <a href="{{ route('login') }}"
           class="btn-brand px-5 py-2.5 text-sm font-semibold">
          <i class="fa-solid fa-right-to-bracket me-2"></i>
          Iniciar sesión
        </a>
      @endauth
    </div>
  </div>
</section>
@endsection
