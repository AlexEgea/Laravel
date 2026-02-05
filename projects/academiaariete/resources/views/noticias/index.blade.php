@extends('layouts.app')
@section('title', 'Noticias')

@section('content')
<section class="matricula-page">

  {{-- Título --}}
  <h1 class="titulo mb-4">Noticias</h1>

  {{-- Buscador y categoría activa --}}
  <div class="mb-6">
    {{-- Buscador --}}
    <form method="GET"
          action="{{ route('noticias.index') }}"
          class="w-full flex flex-col md:flex-row items-stretch gap-2">
      <label for="q" class="sr-only">Buscar noticias</label>

      <input
        type="text"
        id="q"
        name="q"
        value="{{ request('q') }}"
        placeholder="Buscar por título o contenido..."
        class="flex-1 border-2 border-[var(--arietehover)] rounded-lg px-3 py-2 text-sm"
      >

      @if(request()->has('categoria'))
        <input type="hidden" name="categoria" value="{{ request('categoria') }}">
      @endif

      <button type="submit"
              class="btn-brand px-4 py-2 text-sm w-full md:w-auto text-center">
        Buscar
      </button>
    </form>

    {{-- Categoría activa (si hay filtro) --}}
    @if(isset($categoriaActiva) && $categoriaActiva)
      <div class="mt-2 text-xs md:text-sm text-slate-600 flex flex-wrap items-center gap-2">
        <span>Filtrando por categoría:</span>
        <span class="inline-flex items-center px-3 py-0.5 rounded-full text-[11px] font-semibold
                     border border-[var(--baseariete)] text-[var(--baseariete)] bg-white">
          {{ $categoriaActiva->nombre }}
        </span>
        <a href="{{ route('noticias.index', ['q' => request('q')]) }}"
           class="text-[var(--baseariete)] hover:underline">
          Quitar filtro
        </a>
      </div>
    @endif
  </div>

  {{-- Listado de noticias --}}
  @if($noticias->count())
    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
      @foreach($noticias as $noticia)
        @php
          $tieneImagen = !empty($noticia->imagen);
          $imagenSrc = $tieneImagen
              ? asset('storage/'.$noticia->imagen)
              : asset('img/ariete.png'); // logo por defecto
        @endphp

        <article class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm flex flex-col">
          {{-- Imagen (con logo por defecto si no hay imagen) --}}
          <a href="{{ route('noticias.show', $noticia) }}" class="block">
            <div class="w-full h-44 bg-white flex items-center justify-center overflow-hidden">
              <img
                src="{{ $imagenSrc }}"
                alt="{{ $tieneImagen ? 'Imagen de '.$noticia->titulo : 'Logo de Academia Ariete' }}"
                class="{{ $tieneImagen ? 'w-full h-44 object-cover' : 'max-h-40 w-auto object-contain' }}"
              >
            </div>
          </a>

          <div class="p-4 flex flex-col gap-2 flex-1">
            {{-- Categorías (máx. 5) --}}
            @if($noticia->categorias && $noticia->categorias->isNotEmpty())
              @php
                $categoriasMostrar = $noticia->categorias->take(5);
              @endphp
              <div class="flex flex-wrap gap-1 mb-1">
                @foreach($categoriasMostrar as $categoria)
                  <a
                    href="{{ route('noticias.index', ['categoria' => $categoria->id, 'q' => request('q')]) }}"
                    class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold
                           border border-[var(--baseariete)] text-[var(--baseariete)]
                           bg-white hover:bg-[var(--baseariete)] hover:text-white
                           transition-colors duration-150"
                  >
                    {{ $categoria->nombre }}
                  </a>
                @endforeach
              </div>
            @endif

            {{-- Título --}}
            <h2 class="font-bold text-base text-slate-900 leading-tight line-clamp-2">
              <a href="{{ route('noticias.show', $noticia) }}" class="hover:underline">
                {{ $noticia->titulo }}
              </a>
            </h2>

            {{-- Meta --}}
            <p class="text-[11px] text-slate-500">
              {{ ($noticia->publicado_en ?? $noticia->created_at)->format('d/m/Y') }}
              @if($noticia->autor)
                · {{ $noticia->autor->name }}
              @endif
            </p>

            {{-- Resumen (si existe) --}}
            @if($noticia->resumen)
              <p class="text-sm text-slate-700 line-clamp-3">
                {{ $noticia->resumen }}
              </p>
            @endif

            <div class="mt-auto pt-2">
              <a href="{{ route('noticias.show', $noticia) }}" class="btn-brand px-4 py-2 text-sm">
                Leer más
              </a>
            </div>
          </div>
        </article>
      @endforeach
    </div>

    {{-- Paginación personalizada con colores Ariete --}}
    <div class="mt-6 flex flex-col md:flex-row items-center justify-between gap-3">
      <p class="text-xs text-slate-500">
        Mostrando
        <span class="font-semibold">{{ $noticias->firstItem() }}</span>
        -
        <span class="font-semibold">{{ $noticias->lastItem() }}</span>
        de
        <span class="font-semibold">{{ $noticias->total() }}</span>
        noticias
      </p>

      @if ($noticias->lastPage() > 1)
        <nav class="flex items-center gap-2" role="navigation" aria-label="Paginación de noticias">
          {{-- Anterior --}}
          @if ($noticias->onFirstPage())
            <span class="inline-flex items-center px-3 py-1.5 rounded-md border text-xs font-semibold
                         border-slate-200 text-slate-300 cursor-default select-none">
              ‹ Anterior
            </span>
          @else
            <a href="{{ $noticias->previousPageUrl() }}"
               class="inline-flex items-center px-3 py-1.5 rounded-md border text-xs font-semibold
                      border-[var(--baseariete)] text-[var(--baseariete)] bg-white
                      hover:bg-[var(--baseariete)] hover:text-white transition-colors duration-150">
              ‹ Anterior
            </a>
          @endif

          {{-- Números de página --}}
          @foreach ($noticias->getUrlRange(1, $noticias->lastPage()) as $page => $url)
            @if ($page == $noticias->currentPage())
              <span class="inline-flex items-center px-3 py-1.5 rounded-md border text-xs font-semibold
                           bg-[var(--baseariete)] border-[var(--baseariete)] text-white cursor-default select-none">
                {{ $page }}
              </span>
            @else
              <a href="{{ $url }}"
                 class="inline-flex items-center px-3 py-1.5 rounded-md border text-xs font-semibold
                        border-[var(--baseariete)] text-[var(--baseariete)] bg-white
                        hover:bg-[var(--baseariete)] hover:text-white transition-colors duration-150">
                {{ $page }}
              </a>
            @endif
          @endforeach

          {{-- Siguiente --}}
          @if ($noticias->hasMorePages())
            <a href="{{ $noticias->nextPageUrl() }}"
               class="inline-flex items-center px-3 py-1.5 rounded-md border text-xs font-semibold
                      border-[var(--baseariete)] text-[var(--baseariete)] bg-white
                      hover:bg-[var(--baseariete)] hover:text-white transition-colors duration-150">
              Siguiente ›
            </a>
          @else
            <span class="inline-flex items-center px-3 py-1.5 rounded-md border text-xs font-semibold
                         border-slate-200 text-slate-300 cursor-default select-none">
              Siguiente ›
            </span>
          @endif
        </nav>
      @endif
    </div>
  @else
    <p class="text-slate-600 text-sm">
      No se han encontrado noticias que coincidan con los criterios de búsqueda.
    </p>
  @endif

</section>
@endsection
