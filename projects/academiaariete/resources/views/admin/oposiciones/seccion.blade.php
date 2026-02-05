@extends('layouts.app')

@section('title', 'Oposiciones — ' . ($seccion->titulo ?? 'Sección'))

@section('content')
<section class="matricula-page py-8 bg-slate-50">
  <div class="max-w-6xl mx-auto px-4">

    {{-- CABECERA / BREADCRUMB --}}
    <div class="mb-6">
      <p class="text-xs text-slate-500 mb-1">
        <a href="{{ route('oposiciones.index') }}" class="underline hover:text-[var(--baseariete)]">
          Oposiciones
        </a>
        <span class="mx-1">/</span>
        <span>{{ $seccion->titulo }}</span>
      </p>

      <h1 class="titulo mb-1">
        {{ $seccion->titulo }}
      </h1>

      @if($seccion->resumen)
        <p class="text-sm text-slate-700 max-w-3xl mt-2">
          {{ $seccion->resumen }}
        </p>
      @else
        <p class="text-xs text-slate-500 mt-1">
          Estas son las oposiciones incluidas dentro de la sección <strong>{{ $seccion->titulo }}</strong>.
        </p>
      @endif

      <p class="mt-2 text-xs">
        <a href="{{ route('oposiciones.index') }}" class="underline text-[var(--baseariete)] hover:text-[var(--arietehover)]">
          ← Volver al índice de oposiciones
        </a>
      </p>
    </div>

    {{-- =======================================================
         SUBSECCIONES (ej. Maestro dentro de Enseñanza)
       ======================================================= --}}
    @if($subsecciones->isNotEmpty())
      <div class="mb-10">
        <h2 class="text-lg md:text-xl font-bold text-slate-900 mb-3">
          Secciones dentro de
          <span class="text-[var(--baseariete)]">{{ $seccion->titulo }}</span>
        </h2>

        <div class="cards grid gap-4 md:grid-cols-2 lg:grid-cols-3">
          @foreach($subsecciones as $sub)
            @php
              $tituloSub  = $sub->titulo ?? $sub->nombre ?? 'Sección';
              $resumenSub = $sub->resumen ?? $sub->descripcion ?? null;
            @endphp

            <article class="contact-card admin-card flex flex-col h-full">
              <div class="flex-1 flex flex-col">
                <h3 class="text-base md:text-lg font-semibold mb-1 text-[var(--baseariete)]">
                  {{ $tituloSub }}
                </h3>

                <div class="title-underline mb-3"></div>

                @if($resumenSub)
                  <p class="text-sm text-slate-700 leading-6 mb-3">
                    {{ \Illuminate\Support\Str::limit(strip_tags($resumenSub), 160) }}
                  </p>
                @endif
              </div>

              <div class="mt-4 flex justify-center">
                <a href="{{ route('oposiciones.seccion.show', $sub) }}"
                   class="btn-brand btn-uniform inline-flex items-center justify-center gap-2 text-xs px-4 py-2">
                  Ver oposiciones de esta sección
                </a>
              </div>
            </article>
          @endforeach
        </div>
      </div>
    @endif

    {{-- =======================================================
         OPOSICIONES DENTRO DE ESTA SECCIÓN
       ======================================================= --}}
    <div>
      <h2 class="text-lg md:text-xl font-bold text-slate-900 mb-3">
        Oposiciones de
        <span class="text-[var(--baseariete)]">{{ $seccion->titulo }}</span>
      </h2>

      @if($oposiciones->isNotEmpty())
        <div class="cards grid gap-4 md:grid-cols-2 lg:grid-cols-3">
          @foreach($oposiciones as $oposicion)
            @php
              $tituloOpo  = $oposicion->titulo ?? $oposicion->nombre ?? 'Oposición';
              $resumenOpo = $oposicion->resumen ?? $oposicion->descripcion ?? null;
            @endphp

            <article class="contact-card admin-card flex flex-col h-full">
              <div class="flex-1 flex flex-col">
                <h3 class="text-base md:text-lg font-semibold mb-1 text-[var(--baseariete)]">
                  {{ $tituloOpo }}
                </h3>

                <div class="title-underline mb-3"></div>

                @if($resumenOpo)
                  <p class="text-sm text-slate-700 leading-6 mb-3">
                    {{ \Illuminate\Support\Str::limit(strip_tags($resumenOpo), 160) }}
                  </p>
                @endif
              </div>

              <div class="mt-4 flex justify-center">
                <a href="{{ route('oposiciones.show', $oposicion) }}"
                   class="btn-brand btn-uniform inline-flex items-center justify-center gap-2 text-xs px-4 py-2">
                   Ver detalles
                </a>
              </div>
            </article>
          @endforeach
        </div>
      @else
        <p class="text-sm text-slate-600">
          Actualmente no hay oposiciones publicadas dentro de esta sección.
        </p>
      @endif
    </div>

  </div>
</section>
@endsection
