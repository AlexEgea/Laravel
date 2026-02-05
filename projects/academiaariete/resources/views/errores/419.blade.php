@extends('layouts.app')
@section('title', 'Página expirada · Ariete')

{{-- Página expirada --}}

@section('content')
<section class="panel-page min-h-[60vh] flex items-center justify-center">
  <div class="w-full max-w-3xl bg-white border border-slate-200 rounded-2xl shadow-xl px-6 py-8 md:px-10 md:py-10 text-center">

    {{-- Icono --}}
    <div class="mb-4">
      <span class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-amber-100 text-amber-600 text-3xl">
        <i class="fa-solid fa-clock-rotate-left"></i>
      </span>
    </div>

    {{-- Código + etiqueta --}}
    <div class="mb-4 text-center flex flex-col items-center justify-center">
      <p class="text-5xl md:text-6xl font-black tracking-[0.2em] text-slate-300 mb-2 select-none">
        419
      </p>
      <p class="text-[11px] md:text-xs uppercase tracking-[0.3em] text-slate-400 mb-3">
        Error 419 · Página expirada
      </p>
    </div>

    <h1 class="titulo mb-3">
      Tu sesión ha expirado
    </h1>

    <p class="text-sm md:text-base text-slate-600 max-w-xl mx-auto mb-6">
      Has estado un tiempo sin actividad o la página ha caducado.  
      Vuelve a intentarlo recargando la página o iniciando sesión de nuevo.
    </p>

    <div class="flex flex-wrap gap-3 justify-center">
      <a href="{{ url()->previous() }}"
         class="btn-brand px-5 py-2.5 text-sm font-semibold">
        <i class="fa-solid fa-rotate-left me-2"></i>
        Volver atrás
      </a>

      <a href="{{ route('inicio') }}"
         class="btn-brand px-5 py-2.5 text-sm font-semibold">
        <i class="fa-solid fa-house me-2"></i>
        Ir al inicio
      </a>

      @guest
        <a href="{{ route('login') }}"
           class="btn-brand px-5 py-2.5 text-sm font-semibold">
          <i class="fa-solid fa-right-to-bracket me-2"></i>
          Iniciar sesión
        </a>
      @endguest
    </div>

    <p class="mt-6 text-[11px] text-slate-400">
      Si el problema persiste, prueba a cerrar el navegador y volver a acceder a la web.
    </p>
  </div>
</section>
@endsection
