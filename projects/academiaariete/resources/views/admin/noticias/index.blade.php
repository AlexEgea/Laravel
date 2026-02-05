@extends('layouts.app')
@section('title','Admin - Noticias')

@section('content')
<section class="matricula-page">
  <div class="container py-6 max-w-6xl mx-auto">

    {{-- CABECERA SUPERIOR --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between mb-6">
      <div>
        <h1 class="titulo mb-1">Gestión de noticias</h1>
        <p class="text-xs md:text-sm text-slate-500">
          Revisa, edita y publica las noticias de la Academia Ariete.
        </p>
      </div>

      <div class="flex flex-row gap-2 justify-start sm:justify-end">
        {{-- Botón crear principal --}}
        <a href="{{ route('admin.noticias.create') }}"
           class="btn-brand px-4 py-2 text-sm inline-flex items-center justify-center gap-2">
          <i class="fa-solid fa-plus text-xs"></i>
          <span>Crear nueva noticia</span>
        </a>
      </div>
    </div>

    {{-- MENSAJE DE ESTADO --}}
    @if (session('status'))
      <div class="tarifa mb-4" role="alert" aria-live="polite">
        <span>{{ session('status') }}</span>
      </div>
    @endif

    {{-- BLOQUE BUSCADOR --}}
    <div class="mb-5">
      <form method="GET"
            action="{{ route('admin.noticias.index') }}"
            class="bg-white border border-slate-200 rounded-xl shadow-sm px-4 py-3 md:px-5 md:py-4 flex flex-col md:flex-row md:items-center gap-3">

        <div class="flex-1">
          <label for="q" class="sr-only">Buscar noticias</label>
          <div class="relative">
            <span class="absolute inset-y-0 left-3 flex items-center text-slate-400 text-xs">
              <i class="fa-solid fa-magnifying-glass"></i>
            </span>
            <input
              type="text"
              id="q"
              name="q"
              value="{{ request('q') }}"
              placeholder="Buscar por título, resumen o contenido…"
              class="w-full border border-slate-300 rounded-lg pl-8 pr-3 py-2 text-sm
                     focus:outline-none focus:ring-2 focus:ring-[var(--baseariete)] focus:border-[var(--baseariete)]"
            >
          </div>
          @if(request('q'))
            <p class="mt-1 text-[11px] text-slate-500">
              Resultados para: <span class="font-semibold">“{{ request('q') }}”</span>
            </p>
          @endif
        </div>

        <div class="flex flex-row flex-wrap gap-2 justify-stretch md:justify-end">
          {{-- Botón buscar --}}
          <button
            type="submit"
            class="btn-brand px-4 py-2 text-sm flex-1 md:flex-none flex items-center justify-center gap-2 whitespace-nowrap"
          >
            <i class="fa-solid fa-magnifying-glass text-xs"></i>
            <span>Buscar</span>
          </button>

          {{-- Botón limpiar (solo si hay término de búsqueda) --}}
          @if(request('q'))
            <a href="{{ route('admin.noticias.index') }}"
               class="px-3 py-2 text-xs rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-50
                      whitespace-nowrap flex-1 md:flex-none flex items-center justify-center gap-1">
              <i class="fa-solid fa-eraser text-[11px]"></i>
              <span>Limpiar</span>
            </a>
          @endif
        </div>
      </form>
    </div>

    {{-- LISTADO --}}
    @if ($noticias->isEmpty())
      <div class="bg-white border border-slate-200 rounded-xl p-8 text-center shadow-sm">
        <p class="text-slate-600 text-sm">
          @if(request('q'))
            No se han encontrado noticias que coincidan con
            <span class="font-semibold">“{{ request('q') }}”</span>.
          @else
            Todavía no hay noticias creadas. Usa el botón
            <span class="font-semibold">“Crear nueva noticia”</span> para añadir la primera.
          @endif
        </p>
      </div>
    @else
      {{-- Contenedor tabla --}}
      <div class="overflow-x-auto bg-white border border-slate-200 rounded-xl shadow-sm">
        <table class="min-w-full text-sm table-auto">
          <thead class="bg-slate-50">
            <tr>
              <th class="px-4 py-3 text-left border-b border-slate-200 text-xs font-semibold uppercase tracking-wide text-slate-500">
                Título
              </th>
              <th class="px-4 py-3 text-center border-b border-slate-200 text-xs font-semibold uppercase tracking-wide text-slate-500 whitespace-nowrap">
                Estado
              </th>
              <th class="px-4 py-3 text-center border-b border-slate-200 text-xs font-semibold uppercase tracking-wide text-slate-500 whitespace-nowrap">
                Fecha
              </th>
              <th class="px-4 py-3 text-left border-b border-slate-200 text-xs font-semibold uppercase tracking-wide text-slate-500">
                Categorías
              </th>
              <th class="px-4 py-3 text-center border-b border-slate-200 text-xs font-semibold uppercase tracking-wide text-slate-500 whitespace-nowrap w-[260px]">
                Acciones
              </th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100">
            @foreach ($noticias as $noticia)
              @php
                $categoriasLista = $noticia->categorias && $noticia->categorias->count()
                    ? $noticia->categorias->pluck('nombre')->join(', ')
                    : null;
              @endphp

              <tr class="hover:bg-slate-50 align-top">
                {{-- Título --}}
                <td class="px-4 py-3 align-top">
                  <div class="font-semibold text-slate-900 leading-snug line-clamp-2">
                    {{ $noticia->titulo }}
                  </div>
                  <div class="mt-1 text-[11px] text-slate-500 flex flex-wrap items-center gap-1">
                    @if ($noticia->autor)
                      <span>Por {{ $noticia->autor->name }}</span>
                    @else
                      <span class="italic text-slate-400">Sin autor asignado</span>
                    @endif
                  </div>
                </td>

                {{-- Estado --}}
                <td class="px-4 py-3 align-top whitespace-nowrap text-center">
                  @if ($noticia->publicado_en)
                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-[11px] font-semibold bg-emerald-100 text-emerald-800">
                      <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span>
                      Publicada
                    </span>
                  @else
                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-[11px] font-semibold bg-amber-100 text-amber-800">
                      <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1.5"></span>
                      Borrador
                    </span>
                  @endif
                </td>

                {{-- Fecha --}}
                <td class="px-4 py-3 align-top text-xs text-slate-600 whitespace-nowrap text-center">
                  @if ($noticia->publicado_en)
                    {{ $noticia->publicado_en->format('d/m/Y H:i') }}
                  @else
                    {{ $noticia->created_at->format('d/m/Y H:i') }}
                  @endif
                </td>

                {{-- Categorías --}}
                <td class="px-4 py-3 align-top text-xs text-slate-600">
                  @if ($categoriasLista)
                    <span
                      class="inline-block max-w-[260px] overflow-hidden text-ellipsis whitespace-nowrap align-middle"
                      title="{{ $categoriasLista }}"
                    >
                      {{ $categoriasLista }}
                    </span>
                  @else
                    <span class="text-slate-400">Sin categorías</span>
                  @endif
                </td>

                {{-- Acciones --}}
                <td class="px-4 py-3 align-top w-[260px]">
                  <div class="flex flex-row flex-wrap md:flex-nowrap justify-end gap-2">

                    {{-- Ver pública (si está publicada) --}}
                    @if ($noticia->publicado_en)
                      <a href="{{ route('noticias.show', $noticia) }}"
                         target="_blank"
                         class="btn-brand inline-flex items-center justify-center px-3 py-1.5 text-[11px] gap-1 whitespace-nowrap">
                        <i class="fa-solid fa-eye text-xs"></i>
                        <span>Ver</span>
                      </a>
                    @endif

                    {{-- EDITAR --}}
                    <a href="{{ route('admin.noticias.edit', $noticia) }}"
                       class="btn-brand inline-flex items-center justify-center px-3 py-1.5 text-[11px] gap-1 whitespace-nowrap">
                      <i class="fa-solid fa-pen-to-square text-xs"></i>
                      <span>Editar</span>
                    </a>

                    {{-- ELIMINAR --}}
                    <form action="{{ route('admin.noticias.destroy', $noticia) }}"
                          method="POST"
                          onsubmit="return confirm('¿Seguro que quieres eliminar esta noticia?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit"
                              class="btn-brand inline-flex items-center justify-center px-3 py-1.5 text-[11px] gap-1 whitespace-nowrap">
                        <i class="fa-solid fa-trash-can text-xs"></i>
                        <span>Eliminar</span>
                      </button>
                    </form>

                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      {{-- PAGINACIÓN PERSONALIZADA --}}
      <div class="mt-4 flex flex-col md:flex-row items-center justify-between gap-3">
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
          <nav class="flex flex-wrap items-center gap-1" role="navigation" aria-label="Paginación de noticias (admin)">
            {{-- Anterior --}}
            @if ($noticias->onFirstPage())
              <span class="inline-flex items-center px-3 py-1.5 rounded-md border text-xs font-semibold
                           border-slate-200 text-slate-300 cursor-default select-none mr-1">
                ‹ Anterior
              </span>
            @else
              <a href="{{ $noticias->previousPageUrl() }}"
                 class="inline-flex items-center px-3 py-1.5 rounded-md border text-xs font-semibold mr-1
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
                          border-slate-200 text-slate-700 bg-white
                          hover:border-[var(--baseariete)] hover:text-[var(--baseariete)] hover:bg-slate-50 transition-colors duration-150">
                  {{ $page }}
                </a>
              @endif
            @endforeach

            {{-- Siguiente --}}
            @if ($noticias->hasMorePages())
              <a href="{{ $noticias->nextPageUrl() }}"
                 class="inline-flex items-center px-3 py-1.5 rounded-md border text-xs font-semibold ml-1
                        border-[var(--baseariete)] text-[var(--baseariete)] bg-white
                        hover:bg-[var(--baseariete)] hover:text-white transition-colors duration-150">
                Siguiente ›
              </a>
            @else
              <span class="inline-flex items-center px-3 py-1.5 rounded-md border text-xs font-semibold ml-1
                           border-slate-200 text-slate-300 cursor-default select-none">
                Siguiente ›
              </span>
            @endif
          </nav>
        @endif
      </div>
    @endif

  </div>
</section>
@endsection
