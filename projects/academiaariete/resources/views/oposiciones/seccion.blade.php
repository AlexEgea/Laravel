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
      @endif

      <p class="mt-2 text-xs">
        <a href="{{ route('oposiciones.index') }}"
           class="underline text-[var(--baseariete)] hover:text-[var(--arietehover)]">
          ← Volver al índice de oposiciones
        </a>
      </p>
    </div>

    @php
      // Combinamos secciones hijas + oposiciones directas manteniendo el orden:
      // primero secciones, luego oposiciones.
      $items = collect();

      if (isset($subsecciones)) {
          foreach ($subsecciones as $sub) {
              $items->push([
                  'tipo'   => 'seccion',
                  'curso'  => $sub,
              ]);
          }
      }

      if (isset($oposiciones)) {
          foreach ($oposiciones as $opo) {
              $items->push([
                  'tipo'   => 'oposicion',
                  'curso'  => $opo,
              ]);
          }
      }
    @endphp

    {{-- =======================================================
         SECCIONES + OPOSICIONES EN LA MISMA REJILLA
       ======================================================= --}}
    @if($items->isNotEmpty())
      <div class="cards grid gap-5 md:grid-cols-2 lg:grid-cols-3">
        @foreach($items as $item)
          @php
            /** @var \App\Models\Curso $curso */
            $curso   = $item['curso'];
            $tipo    = $item['tipo']; // 'seccion' o 'oposicion'
            $titulo  = $curso->titulo ?? 'Curso';
            $resumen = $curso->resumen ?? $curso->descripcion ?? null;

            // Ruta y texto del botón según el tipo
            if ($tipo === 'seccion') {
                $urlBoton   = route('oposiciones.seccion.show', $curso);
                $textoBoton = 'Ver oposiciones de esta sección';
            } else {
                $urlBoton   = route('oposiciones.show', $curso);
                $textoBoton = 'Ver detalles';
            }
          @endphp

          <article class="contact-card admin-card flex flex-col h-full hover:shadow-lg transition-shadow duration-200">
            <div class="flex-1 flex flex-col">
              {{-- TÍTULO --}}
              <h3 class="text-base md:text-lg font-semibold mb-1 text-[var(--baseariete)] leading-snug">
                {{ $titulo }}
              </h3>

              <div class="title-underline mb-3"></div>

              {{-- DESCRIPCIÓN / RESUMEN --}}
              @if($resumen)
                <p class="text-sm text-slate-700 leading-6 mb-3">
                  {{ \Illuminate\Support\Str::limit(strip_tags($resumen), 220) }}
                </p>
              @endif

              {{-- BLOQUE PARA SECCIONES: LISTA DE OPOSICIONES QUE CONTIENE (NOMBRE COMPLETO) --}}
              @if($tipo === 'seccion')
                @php
                  $oposicionesHijas = \App\Models\Curso::where('tipo', 'oposicion')
                      ->where('parent_id', $curso->id)
                      ->where('activo', true)
                      ->orderBy('titulo')
                      ->get();
                @endphp

                @if($oposicionesHijas->isNotEmpty())
                  <div class="mt-2 rounded-xl bg-slate-50 border border-slate-200 px-3 py-2">
                    <p class="text-[11px] font-semibold text-slate-600 mb-1 uppercase tracking-wide">
                      Oposiciones en esta sección
                    </p>
                    <ul class="mt-1 space-y-1 text-[12px] text-slate-700">
                      @foreach($oposicionesHijas as $opoHija)
                        <li class="flex items-start gap-1.5">
                          <span class="mt-1 w-1.5 h-1.5 rounded-full bg-[var(--baseariete)] flex-shrink-0"></span>
                          <span>{{ $opoHija->titulo }}</span>
                        </li>
                      @endforeach
                    </ul>
                  </div>
                @else
                  <p class="mt-1 text-[11px] text-slate-400 italic">
                    Esta sección aún no tiene oposiciones asignadas.
                  </p>
                @endif
              @endif
            </div>

            {{-- BOTÓN --}}
            <div class="mt-4 flex justify-center">
              <a href="{{ $urlBoton }}"
                 class="btn-brand btn-uniform inline-flex items-center justify-center gap-2 text-xs px-4 py-2">
                {{ $textoBoton }}
              </a>
            </div>
          </article>
        @endforeach
      </div>
    @else
      <p class="text-sm text-slate-600">
        Actualmente no hay secciones ni oposiciones publicadas dentro de esta sección.
      </p>
    @endif

  </div>
</section>
@endsection
