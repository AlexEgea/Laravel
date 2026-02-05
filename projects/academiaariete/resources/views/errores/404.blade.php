@extends('layouts.app')
@section('title', 'Página no encontrada · Ariete')

{{-- Página no encontrada --}}

@section('content')
<section class="panel-page min-h-[60vh] flex items-center justify-center">
  <div class="w-full max-w-3xl bg-white border border-slate-200 rounded-2xl shadow-xl px-6 py-8 md:px-10 md:py-10 text-center">

    {{-- Icono / badge superior --}}
    <div class="mb-4">
      <span class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-[var(--baseariete)]/10 text-[var(--baseariete)] text-3xl">
        <i class="fa-solid fa-triangle-exclamation"></i>
      </span>
    </div>

    {{-- Código grande + etiqueta centrados --}}
    <div class="mb-4 text-center flex flex-col items-center justify-center">
      <p class="text-5xl md:text-6xl font-black tracking-[0.2em] text-slate-300 mb-2 select-none text-center">
        404
      </p>

      <p class="text-[11px] md:text-xs uppercase tracking-[0.3em] text-slate-400 mb-3 text-center">
        Error 404 · Página no encontrada
      </p>
    </div>


    <h1 class="titulo mb-3">
      No hemos encontrado esta página
    </h1>

    {{-- Botones de acción --}}
    <div class="flex flex-wrap gap-3 justify-center">
      <a href="{{ route('inicio') }}"
         class="btn-brand px-5 py-2.5 text-sm font-semibold">
        <i class="fa-solid fa-house me-2"></i>
        Ir a la página de inicio
      </a>

      <a href="{{ route('oposiciones.index') }}"
         class="btn-brand px-5 py-2.5 text-sm font-semibold">
        <i class="fa-solid fa-list-check me-2"></i>
        Ver oposiciones
      </a>

      <a href="{{ route('contacto') }}"
         class="btn-brand px-5 py-2.5 text-sm font-semibold">
        <i class="fa-solid fa-envelope me-2"></i>
        Contactar con la academia
      </a>
    </div>
  </div>
</section>
@endsection
