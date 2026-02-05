@extends('layouts.app')
@section('title', $oposicion->titulo . ' - Oposiciones')

@section('content')
<section class="panel-page">
  {{-- Migas de pan mínimas --}}
  <nav class="text-xs mb-3" aria-label="Ruta de navegación">
    <a href="{{ route('oposiciones.index') }}" class="text-[var(--baseariete)] underline">
      ← Volver a oposiciones
    </a>
    @if($seccion)
      <span> · </span>
      <a href="{{ route('oposiciones.seccion.show', $seccion) }}"
         class="text-[var(--baseariete)] underline">
        {{ $seccion->titulo }}
      </a>
    @endif
  </nav>

  <h1 class="titulo">{{ $oposicion->titulo }}</h1>

  @if($seccion)
    <p class="mt-2 text-xs uppercase tracking-wide text-slate-500">
      Sección: <strong>{{ $seccion->titulo }}</strong>
    </p>
  @endif

  {{-- =======================
       CARRUSEL / PESTAÑAS
     ======================= --}}
  <div class="mt-6" data-oposicion-tabs>
    {{-- Botones --}}
    <div class="flex flex-wrap justify-center gap-2 md:gap-3"
         role="tablist"
         aria-label="Información de la oposición">

      {{-- Información (descripcion general) --}}
      <button
        type="button"
        id="tab-info"
        class="px-4 py-2 rounded-full bg-[var(--baseariete)] text-white text-xs md:text-sm font-semibold hover:bg-[var(--arietehover)] duration-150 data-[active=false]:bg-slate-100 data-[active=false]:text-slate-700"
        data-tab-button
        data-target="panel-info"
        data-active="true"
        role="tab"
        aria-selected="true"
        aria-controls="panel-info"
        tabindex="0"
      >
        Información
      </button>

      <button
        type="button"
        id="tab-convocatoria"
        class="px-4 py-2 rounded-full bg-[var(--baseariete)] text-white text-xs md:text-sm font-semibold hover:bg-[var(--arietehover)] duration-150 data-[active=false]:bg-slate-100 data-[active=false]:text-slate-700"
        data-tab-button
        data-target="panel-convocatoria"
        data-active="false"
        role="tab"
        aria-selected="false"
        aria-controls="panel-convocatoria"
        tabindex="-1"
      >
        Convocatoria anual
      </button>

      <button
        type="button"
        id="tab-requisitos"
        class="px-4 py-2 rounded-full bg-[var(--baseariete)] text-white text-xs md:text-sm font-semibold hover:bg-[var(--arietehover)] duration-150 data-[active=false]:bg-slate-100 data-[active=false]:text-slate-700"
        data-tab-button
        data-target="panel-requisitos"
        data-active="false"
        role="tab"
        aria-selected="false"
        aria-controls="panel-requisitos"
        tabindex="-1"
      >
        Requisitos
      </button>

      <button
        type="button"
        id="tab-examen"
        class="px-4 py-2 rounded-full bg-[var(--baseariete)] text-white text-xs md:text-sm font-semibold hover:bg-[var(--arietehover)] duration-150 data-[active=false]:bg-slate-100 data-[active=false]:text-slate-700"
        data-tab-button
        data-target="panel-examen"
        data-active="false"
        role="tab"
        aria-selected="false"
        aria-controls="panel-examen"
        tabindex="-1"
      >
        Examen
      </button>

      <button
        type="button"
        id="tab-concurso"
        class="px-4 py-2 rounded-full bg-[var(--baseariete)] text-white text-xs md:text-sm font-semibold hover:bg-[var(--arietehover)] duration-150 data-[active=false]:bg-slate-100 data-[active=false]:text-slate-700"
        data-tab-button
        data-target="panel-concurso"
        data-active="false"
        role="tab"
        aria-selected="false"
        aria-controls="panel-concurso"
        tabindex="-1"
      >
        Concurso
      </button>

      <button
        type="button"
        id="tab-horarios"
        class="px-4 py-2 rounded-full bg-[var(--baseariete)] text-white text-xs md:text-sm font-semibold hover:bg-[var(--arietehover)] duration-150 data-[active=false]:bg-slate-100 data-[active=false]:text-slate-700"
        data-tab-button
        data-target="panel-horarios"
        data-active="false"
        role="tab"
        aria-selected="false"
        aria-controls="panel-horarios"
        tabindex="-1"
      >
        Horario y precios
      </button>

      <button
        type="button"
        id="tab-equipo"
        class="px-4 py-2 rounded-full bg-[var(--baseariete)] text-white text-xs md:text-sm font-semibold hover:bg-[var(--arietehover)] duration-150 data-[active=false]:bg-slate-100 data-[active=false]:text-slate-700"
        data-tab-button
        data-target="panel-equipo"
        data-active="false"
        role="tab"
        aria-selected="false"
        aria-controls="panel-equipo"
        tabindex="-1"
      >
        Equipo docente
      </button>
    </div>

    {{-- Panel descriptivo --}}
    <div class="mt-4 bg-white rounded-2xl shadow-sm p-4 md:p-6 border border-slate-100">
      {{-- Información (descripcion general) --}}
      <div id="panel-info"
           data-tab-panel
           role="tabpanel"
           aria-labelledby="tab-info">
        <h2 class="text-base md:text-lg font-semibold mb-2">Información general</h2>
        <div class="prose max-w-none text-sm md:text-base">
          @if($oposicion->descripcion)
            {!! $oposicion->descripcion !!}
          @else
            <p class="text-slate-600">
              Próximamente añadiremos más información sobre esta oposición.
            </p>
          @endif
        </div>

        {{-- CTA --}}
        <div class="mt-6 flex flex-wrap gap-3 justify-center">
          <a href="{{ route('matriculate') }}"
             target="_blank"
             rel="noopener noreferrer"
             class="btn-brand px-5 py-2.5 text-sm font-semibold text-center">
            Matricúlate
          </a>
          <a href="{{ route('contactar.index') }}"
             target="_blank"
             rel="noopener noreferrer"
             class="btn-brand px-5 py-2.5 text-sm font-semibold text-center">
            Contáctanos
          </a>
        </div>
      </div>

      {{-- Convocatoria --}}
      <div id="panel-convocatoria"
           data-tab-panel
           class="hidden"
           role="tabpanel"
           aria-labelledby="tab-convocatoria">
        <h2 class="text-base md:text-lg font-semibold mb-2">Convocatoria anual</h2>
        <div class="prose max-w-none text-sm md:text-base">
          @if($oposicion->convocatoria_anual)
            {!! nl2br(e($oposicion->convocatoria_anual)) !!}
          @else
            <p class="text-slate-600">Información disponible próximamente.</p>
          @endif
        </div>

        <div class="mt-6 flex flex-wrap gap-3 justify-center">
          <a href="{{ route('matriculate') }}"
             target="_blank"
             rel="noopener noreferrer"
             class="btn-brand px-5 py-2.5 text-sm font-semibold text-center">
            Matricúlate
          </a>
          <a href="{{ route('contactar.index') }}"
             target="_blank"
             rel="noopener noreferrer"
             class="btn-brand px-5 py-2.5 text-sm font-semibold text-center">
            Contáctanos
          </a>
        </div>
      </div>

      {{-- Requisitos --}}
      <div id="panel-requisitos"
           data-tab-panel
           class="hidden"
           role="tabpanel"
           aria-labelledby="tab-requisitos">
        <h2 class="text-base md:text-lg font-semibold mb-2">Requisitos</h2>
        <div class="prose max-w-none text-sm md:text-base">
          @if($oposicion->requisitos)
            {!! nl2br(e($oposicion->requisitos)) !!}
          @else
            <p class="text-slate-600">Información disponible próximamente.</p>
          @endif
        </div>

        <div class="mt-6 flex flex-wrap gap-3 justify-center">
          <a href="{{ route('matriculate') }}"
             target="_blank"
             rel="noopener noreferrer"
             class="btn-brand px-5 py-2.5 text-sm font-semibold text-center">
            Matricúlate
          </a>
          <a href="{{ route('contactar.index') }}"
             target="_blank"
             rel="noopener noreferrer"
             class="btn-brand px-5 py-2.5 text-sm font-semibold text-center">
            Contáctanos
          </a>
        </div>
      </div>

      {{-- Examen --}}
      <div id="panel-examen"
           data-tab-panel
           class="hidden"
           role="tabpanel"
           aria-labelledby="tab-examen">
        <h2 class="text-base md:text-lg font-semibold mb-2">Examen</h2>
        <div class="prose max-w-none text-sm md:text-base">
          @if($oposicion->examen)
            {!! nl2br(e($oposicion->examen)) !!}
          @else
            <p class="text-slate-600">Información disponible próximamente.</p>
          @endif
        </div>

        <div class="mt-6 flex flex-wrap gap-3 justify-center">
          <a href="{{ route('matriculate') }}"
             target="_blank"
             rel="noopener noreferrer"
             class="btn-brand px-5 py-2.5 text-sm font-semibold text-center">
            Matricúlate
          </a>
          <a href="{{ route('contactar.index') }}"
             target="_blank"
             rel="noopener noreferrer"
             class="btn-brand px-5 py-2.5 text-sm font-semibold text-center">
            Contáctanos
          </a>
        </div>
      </div>

      {{-- Concurso --}}
      <div id="panel-concurso"
           data-tab-panel
           class="hidden"
           role="tabpanel"
           aria-labelledby="tab-concurso">
        <h2 class="text-base md:text-lg font-semibold mb-2">Concurso</h2>
        <div class="prose max-w-none text-sm md:text-base">
          @if($oposicion->concurso)
            {!! nl2br(e($oposicion->concurso)) !!}
          @else
            <p class="text-slate-600">Información disponible próximamente.</p>
          @endif
        </div>

        <div class="mt-6 flex flex-wrap gap-3 justify-center">
          <a href="{{ route('matriculate') }}"
             target="_blank"
             rel="noopener noreferrer"
             class="btn-brand px-5 py-2.5 text-sm font-semibold text-center">
            Matricúlate
          </a>
          <a href="{{ route('contactar.index') }}"
             target="_blank"
             rel="noopener noreferrer"
             class="btn-brand px-5 py-2.5 text-sm font-semibold text-center">
            Contáctanos
          </a>
        </div>
      </div>

      {{-- Horario y precios --}}
      <div id="panel-horarios"
           data-tab-panel
           class="hidden"
           role="tabpanel"
           aria-labelledby="tab-horarios">
        <h2 class="text-base md:text-lg font-semibold mb-2">Horario y precios</h2>
        <div class="prose max-w-none text-sm md:text-base">
          @if($oposicion->horario_precios)
            {!! nl2br(e($oposicion->horario_precios)) !!}
          @else
            <p class="text-slate-600">Información disponible próximamente.</p>
          @endif
        </div>

        <div class="mt-6 flex flex-wrap gap-3 justify-center">
          <a href="{{ route('matriculate') }}"
             target="_blank"
             rel="noopener noreferrer"
             class="btn-brand px-5 py-2.5 text-sm font-semibold text-center">
            Matricúlate
          </a>
          <a href="{{ route('contactar.index') }}"
             target="_blank"
             rel="noopener noreferrer"
             class="btn-brand px-5 py-2.5 text-sm font-semibold text-center">
            Contáctanos
          </a>
        </div>
      </div>

      {{-- Equipo docente --}}
      <div id="panel-equipo"
           data-tab-panel
           class="hidden"
           role="tabpanel"
           aria-labelledby="tab-equipo">
        <h2 class="text-base md:text-lg font-semibold mb-2">Equipo docente</h2>
        <div class="prose max-w-none text-sm md:text-base">
          @if($oposicion->equipo_docente)
            {!! nl2br(e($oposicion->equipo_docente)) !!}
          @else
            <p class="text-slate-600">Información disponible próximamente.</p>
          @endif
        </div>

        <div class="mt-6 flex flex-wrap gap-3 justify-center">
          <a href="{{ route('matriculate') }}"
             target="_blank"
             rel="noopener noreferrer"
             class="btn-brand px-5 py-2.5 text-sm font-semibold text-center">
            Matricúlate
          </a>
          <a href="{{ route('contactar.index') }}"
             target="_blank"
             rel="noopener noreferrer"
             class="btn-brand px-5 py-2.5 text-sm font-semibold text-center">
            Contáctanos
          </a>
        </div>
      </div>
    </div>
  </div>

  {{-- RESUMEN GENERAL --}}
  @if($oposicion->resumen)
    <p class="mt-8 text-base text-slate-700 max-w-2xl">
      {{ $oposicion->resumen }}
    </p>
  @endif
</section>
@endsection
