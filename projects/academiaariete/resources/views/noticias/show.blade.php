@extends('layouts.app')
@section('title', $noticia->titulo)

@section('content')
<section class="matricula-page">

  {{-- Breadcrumb --}}
  <nav class="mb-3 text-sm text-slate-600" aria-label="Breadcrumb">
    <ol class="flex flex-wrap items-center gap-1">
      <li><a href="{{ route('inicio') }}" class="hover:underline">Inicio</a></li>
      <li aria-hidden="true">/</li>
      <li><a href="{{ route('noticias.index') }}" class="hover:underline">Noticias</a></li>
      <li aria-hidden="true">/</li>
      <li aria-current="page" class="text-slate-800 font-medium truncate max-w-[180px] md:max-w-xs">
        {{ $noticia->titulo }}
      </li>
    </ol>
  </nav>

  {{-- Título --}}
  <h1 class="titulo mb-1">{{ $noticia->titulo }}</h1>

  {{-- Meta --}}
  <p class="text-xs text-slate-500">
    Publicado el
    {{ ($noticia->publicado_en ?? $noticia->created_at)->format('d/m/Y') }}
    @if($noticia->autor)
      · por {{ $noticia->autor->name }}
    @endif
  </p>

  {{-- Imagen fuera del recuadro --}}
  @if($noticia->imagen)
    <div class="mt-4 mb-3">
      <img
        src="{{ asset('storage/' . $noticia->imagen) }}"
        alt="Imagen de {{ $noticia->titulo }}"
        class="w-full max-h-[420px] object-cover rounded-xl shadow-md"
      >
    </div>
  @endif

  {{-- Categorías debajo de la imagen, clicables --}}
  @if($noticia->categorias && $noticia->categorias->isNotEmpty())
    <div class="mb-4 flex flex-wrap gap-2">
      @foreach($noticia->categorias as $categoria)
        <a
          href="{{ route('noticias.index', ['categoria' => $categoria->id]) }}"
          class="inline-flex items-center px-3 py-0.5 rounded-full text-[11px] font-semibold
                 border border-[var(--baseariete)] text-[var(--baseariete)]
                 bg-white hover:bg-[var(--baseariete)] hover:text-white
                 transition-colors duration-150"
        >
          {{ $categoria->nombre }}
        </a>
      @endforeach
    </div>
  @endif

  {{-- Contenido en recuadro tipo matrícula --}}
  <article class="form-matricula card p-6 stack contenido-noticia">
    @if($noticia->resumen)
      <p class="text-sm text-slate-700 mb-4">
        {{ $noticia->resumen }}
      </p>
      <hr class="my-4">
    @endif

    <div class="prose max-w-none text-slate-800">
      {!! $noticia->contenido !!}
    </div>
  </article>

</section>
@endsection
