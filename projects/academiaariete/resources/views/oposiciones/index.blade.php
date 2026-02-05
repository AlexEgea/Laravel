@extends('layouts.app')
@section('title','Oposiciones - Academia Ariete')

@section('content')
<section class="panel-page">
  <h1 class="titulo">Oposiciones</h1>

  {{-- =======================
       SECCIONES (familias)
     ======================= --}}
  <h2 class="subtitulo mt-8">Secciones de oposiciones</h2>

  @if ($secciones->count())
    <div class="cards mt-4">
      <div class="admin-areas">
        @foreach ($secciones as $seccion)
          <a href="{{ route('oposiciones.seccion.show', $seccion) }}"
             class="contact-card admin-card block focus:outline-none">
            <div class="head">
              <span class="contact-icon" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                     viewBox="0 0 24 24" fill="none" stroke="#850e0e"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M3 7h5l2 3h11v9H3z"/>
                  <path d="M3 7V5h5l2 2h11v3H3z"/>
                </svg>
              </span>
              <h3 class="text-lg m-0">{{ $seccion->titulo }}</h3>
            </div>
            <div class="title-underline"></div>

            @if($seccion->resumen)
              <p class="text-sm text-slate-700 leading-7 mt-2">
                {{ $seccion->resumen }}
              </p>
            @else
              <p class="text-sm text-slate-700 leading-7 mt-2">
                Ver oposiciones de esta sección.
              </p>
            @endif

            <div class="mt-3 text-sm text-[var(--baseariete)] font-semibold">
              Ver oposiciones de {{ $seccion->titulo }} →
            </div>
          </a>
        @endforeach
      </div>
    </div>
  @else
    <p class="mt-4 hint">
      Todavía no hay secciones de oposiciones creadas.
    </p>
  @endif

  {{-- =======================
       OPOSICIONES SIN SECCIÓN
     ======================= --}}
  @if ($oposicionesSueltas->count())
    <h2 class="subtitulo mt-10">Oposiciones generales</h2>

    <div class="cards mt-4">
      <div class="admin-areas">
        @foreach ($oposicionesSueltas as $op)
          <a href="{{ route('oposiciones.show', $op) }}"
             class="contact-card admin-card block focus:outline-none">
            <div class="head">
              <span class="contact-icon" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                     viewBox="0 0 24 24" fill="none" stroke="#850e0e"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                  <path d="M4 4.5A2.5 2.5 0 0 1 6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5z"/>
                </svg>
              </span>
              <h3 class="text-lg m-0">{{ $op->titulo }}</h3>
            </div>
            <div class="title-underline"></div>

            @if($op->resumen)
              <p class="text-sm text-slate-700 leading-7 mt-2">
                {{ $op->resumen }}
              </p>
            @else
              <p class="text-sm text-slate-700 leading-7 mt-2">
                Ver información de la oposición.
              </p>
            @endif
          </a>
        @endforeach
      </div>
    </div>
  @endif
</section>
@endsection
