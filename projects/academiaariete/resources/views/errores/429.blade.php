@extends('layouts.app')
@section('title', 'Demasiadas peticiones · Ariete')

{{-- Demasiadas peticiones --}}

@section('content')
<section class="panel-page min-h-[60vh] flex items-center justify-center">
  <div class="w-full max-w-3xl bg-white border border-slate-200 rounded-2xl shadow-xl px-6 py-8 md:px-10 md:py-10 text-center">

    {{-- Icono --}}
    <div class="mb-4">
      <span class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-amber-100 text-amber-600 text-3xl">
        <i class="fa-solid fa-gauge-high"></i>
      </span>
    </div>

    {{-- Código + etiqueta --}}
    <div class="mb-4 text-center flex flex-col items-center justify-center">
      <p class="text-5xl md:text-6xl font-black tracking-[0.2em] text-slate-300 mb-2 select-none">
        429
      </p>
      <p class="text-[11px] md:text-xs uppercase tracking-[0.3em] text-slate-400 mb-3">
        Error 429 · Demasiadas peticiones
      </p>
    </div>

    <h1 class="titulo mb-3">
      Has hecho demasiadas solicitudes en poco tiempo
    </h1>

    <p class="text-sm md:text-base text-slate-600 max-w-xl mx-auto mb-6">
      Para proteger el sistema, hemos limitado temporalmente el número de peticiones.
      Espera unos segundos y vuelve a intentarlo.
    </p>

    <div class="flex flex-wrap gap-3 justify-center">
      <a href="{{ route('inicio') }}"
         class="btn-brand px-5 py-2.5 text-sm font-semibold">
        <i class="fa-solid fa-house me-2"></i>
        Ir al inicio
      </a>

      <a href="{{ route('contacto') }}"
         class="btn-brand px-5 py-2.5 text-sm font-semibold">
        <i class="fa-solid fa-envelope me-2"></i>
        Contactar con la academia
      </a>
    </div>

    <p class="mt-6 text-[11px] text-slate-400">
      Si el mensaje aparece con frecuencia, escríbenos indicando qué estabas haciendo.
    </p>
  </div>
</section>
@endsection
