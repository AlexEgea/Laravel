@extends('layouts.app')
@section('title','Admin - Crear noticia')

@section('content')
<section class="matricula-page">
  <h1 class="titulo">Crear noticia</h1>

  <form action="{{ route('admin.noticias.store') }}" method="POST"
        class="form-matricula card p-6 stack"
        enctype="multipart/form-data" novalidate>
    @csrf

    @if ($errors->any())
      <div class="tarifa mb-4" role="alert" aria-live="polite">
        <span>Hay campos con errores. Revísalos por favor.</span>
      </div>
    @endif

    <p class="mb-6 text-sm text-slate-600">
      Completa la información de la noticia. Puedes publicarla al momento o dejarla en borrador para editarla más tarde.
    </p>

    {{-- =======================
         DATOS PRINCIPALES
       ======================= --}}
    <div class="grid gap-4 md:grid-cols-1">
      {{-- Título --}}
      <div>
        <label for="titulo" class="titulo @error('titulo') error @enderror">Título *</label>
        <input id="titulo" name="titulo" type="text" required
               class="mt-1 block w-full @error('titulo') is-invalid @enderror"
               value="{{ old('titulo') }}"
               aria-invalid="@error('titulo') true @else false @enderror"
               aria-describedby="@error('titulo') titulo_error @enderror">
        @error('titulo')
          <div id="titulo_error" class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      {{-- Resumen --}}
      <div>
        <label for="resumen" class="titulo @error('resumen') error @enderror">Resumen (opcional)</label>
        <textarea id="resumen" name="resumen" rows="3"
                  class="mt-1 block w-full @error('resumen') is-invalid @enderror"
                  aria-invalid="@error('resumen') true @else false @enderror"
                  aria-describedby="@error('resumen') resumen_error @enderror">{{ old('resumen') }}</textarea>
        <p class="hint">Breve entradilla que aparecerá como avance de la noticia.</p>
        @error('resumen')
          <div id="resumen_error" class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      {{-- Contenido con botones de formato --}}
      <div>
        <div class="flex flex-wrap items-center justify-between gap-2 mb-1">
          <label for="contenido" class="titulo @error('contenido') error @enderror">Contenido *</label>

          <div class="flex flex-wrap gap-2">
            {{-- Subtítulo h3.subtitulo --}}
            <button type="button"
                    class="btn-brand px-3 py-1.5 text-xs"
                    onclick="insertSubtitulo()">
              Subtítulo
            </button>

            {{-- Negrita --}}
            <button type="button"
                    class="btn-brand px-3 py-1.5 text-xs"
                    onclick="insertNegrita()">
              Negrita
            </button>

            {{-- Cursiva --}}
            <button type="button"
                    class="btn-brand px-3 py-1.5 text-xs"
                    onclick="insertCursiva()">
              Cursiva
            </button>

            {{-- Lista desordenada --}}
            <button type="button"
                    class="btn-brand px-3 py-1.5 text-xs"
                    onclick="insertLista('ul')">
              Lista •
            </button>

            {{-- Lista ordenada --}}
            <button type="button"
                    class="btn-brand px-3 py-1.5 text-xs"
                    onclick="insertLista('ol')">
              Lista 1.
            </button>

            {{-- Enlace --}}
            <button type="button"
                    class="btn-brand px-3 py-1.5 text-xs"
                    onclick="insertEnlace()">
              Enlace
            </button>
          </div>
        </div>

        <textarea id="contenido" name="contenido" rows="10" required
                  class="mt-1 block w-full @error('contenido') is-invalid @enderror"
                  aria-invalid="@error('contenido') true @else false @enderror"
                  aria-describedby="@error('contenido') contenido_error @enderror">{{ old('contenido') }}</textarea>

        <p class="hint">
          Puedes usar <strong>HTML básico</strong> (subtítulos, negrita, cursiva, listas, enlaces, etc.).
        </p>

        @error('contenido')
          <div id="contenido_error" class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
    </div>

    {{-- =======================
         IMAGEN DESTACADA
       ======================= --}}
    <div>
      <label class="titulo @error('imagen') error @enderror">
        Imagen destacada (opcional)
      </label>

      <div class="file-card mt-2">
        <div class="file-title">
          <span><strong>Subir imagen (JPG, JPEG, PNG, WEBP)</strong></span>
        </div>

        <input
          id="imagen"
          name="imagen"
          type="file"
          accept="image/*"
          class="file-input-hidden @error('imagen') is-invalid @enderror"
          aria-invalid="@error('imagen') true @else false @enderror"
          aria-describedby="@error('imagen') imagen_error @enderror"
        >
        <div class="file-inline">
          <label for="imagen" class="btn-file" role="button" tabindex="0">Seleccionar archivo</label>
          <span class="file-msg" id="imagen_name">Ningún archivo seleccionado</span>
        </div>

        <p class="hint">
          <strong>Tamaño máx. 2&nbsp;MB.</strong> La imagen se usará como cabecera visual de la noticia.
        </p>

        @error('imagen')
          <div id="imagen_error" class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
    </div>

    {{-- =======================
         CATEGORÍAS
       ======================= --}}
    <div>
      <label class="titulo">Categorías</label>

      {{-- Buscador de categorías --}}
      <div class="mt-2 mb-3">
        <label for="categoria_search" class="titulo block text-sm text-slate-800">
          Buscar categorías
        </label>
        <input
          id="categoria_search"
          type="text"
          placeholder="Escribe para filtrar categorías..."
          autocomplete="off"
          class="mt-1 block w-full border-2 border-[var(--arietehover)] rounded-lg px-3 py-2 text-sm"
        >
        <p class="hint">Empieza a escribir para filtrar las categorías existentes.</p>
      </div>

      {{-- Categorías existentes agrupadas por letra --}}
      @if(isset($categorias) && $categorias->count())
        @php
          $categoriasOrdenadas = $categorias->sortBy(function ($categoria) {
              $nombre = \Illuminate\Support\Str::ascii($categoria->nombre);
              return mb_strtolower($nombre, 'UTF-8');
          });

          $grupos = $categoriasOrdenadas->groupBy(function ($categoria) {
              $nombre = \Illuminate\Support\Str::ascii($categoria->nombre);
              $letra  = mb_substr($nombre, 0, 1, 'UTF-8');
              return mb_strtoupper($letra, 'UTF-8');
          });

          $categoriasSeleccionadas = old('categorias', []);
        @endphp

        <div id="categorias-list" class="space-y-4">
          @foreach ($grupos as $letra => $categoriasGrupo)
            <div class="categoria-group" data-grupo-letra="{{ $letra }}">
              {{-- Cabecera de letra: "A:" + línea completa --}}
              <div class="flex items-center gap-2 mb-2">
                <span class="text-xs font-semibold text-slate-500">{{ $letra }}:</span>
                <span class="flex-1 h-px bg-slate-300"></span>
              </div>

              <div class="flex flex-wrap gap-2">
                @foreach ($categoriasGrupo as $categoria)
                  <label
                    class="categoria-pill check-row text-sm bg-slate-50 border border-slate-200 rounded-full px-3 py-1 flex items-center gap-2"
                    data-categoria-nombre="{{ mb_strtolower(\Illuminate\Support\Str::ascii($categoria->nombre), 'UTF-8') }}"
                  >
                    <input
                      type="checkbox"
                      name="categorias[]"
                      value="{{ $categoria->id }}"
                      {{ in_array($categoria->id, $categoriasSeleccionadas) ? 'checked' : '' }}
                    >
                    <span class="truncate max-w-[160px] md:max-w-[220px]">{{ $categoria->nombre }}</span>

                    {{-- Botón borrar categoría --}}
                    <button
                      type="button"
                      class="text-[10px] text-red-600 hover:text-red-800 ml-1"
                      title="Borrar categoría"
                      data-categoria-id="{{ $categoria->id }}"
                      data-categoria-nombre="{{ $categoria->nombre }}"
                      onclick="handleDeleteCategoria(this)"
                    >
                      ✕
                    </button>
                  </label>
                @endforeach
              </div>
            </div>
          @endforeach
        </div>
      @else
        <p class="hint mt-1">
          Todavía no hay categorías creadas. Puedes añadir nuevas categorías a continuación.
        </p>
      @endif

      {{-- Errores de categorías --}}
      @error('categorias')
        <div class="invalid-feedback mt-2">{{ $message }}</div>
      @enderror
      @error('categorias.*')
        <div class="invalid-feedback mt-2">{{ $message }}</div>
      @enderror

      {{-- Nuevas categorías --}}
      <div class="mt-3">
        <label for="nuevas_categorias" class="titulo @error('nuevas_categorias') error @enderror">
          Nuevas categorías (separadas por comas)
        </label>
        <input id="nuevas_categorias" name="nuevas_categorias" type="text"
               class="mt-1 block w-full @error('nuevas_categorias') is-invalid @enderror"
               value="{{ old('nuevas_categorias') }}"
               placeholder="Ej: Oposiciones, Convocatorias, Noticias internas"
               aria-invalid="@error('nuevas_categorias') true @else false @enderror"
               aria-describedby="@error('nuevas_categorias') nuevas_categorias_error @enderror">
        <p class="hint">Si alguna de las categorías no existe, se creará automáticamente y se asociará a la noticia.</p>
        @error('nuevas_categorias')
          <div id="nuevas_categorias_error" class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
    </div>

    {{-- =======================
         ESTADO (Borrador / Publicar)
       ======================= --}}
    @php $estado = old('estado','publicar'); @endphp
    <fieldset class="mt-6">
      <legend class="subtitulo text-center">Estado de la noticia</legend>

      <div class="mt-3 flex justify-center">
        <div class="segmented" role="tablist" aria-label="Estado de la noticia">
          {{-- Publicar ahora --}}
          <input
            type="radio"
            id="estado_publicar"
            name="estado"
            value="publicar"
            class="segmented-input"
            {{ $estado === 'publicar' ? 'checked' : '' }}
            required
          >
          <label
            for="estado_publicar"
            class="segmented-btn"
            role="tab"
            aria-selected="{{ $estado === 'publicar' ? 'true' : 'false' }}"
            tabindex="{{ $estado === 'publicar' ? '0' : '-1' }}"
          >
            Publicar ahora
          </label>

          {{-- Borrador --}}
          <input
            type="radio"
            id="estado_borrador"
            name="estado"
            value="borrador"
            class="segmented-input"
            {{ $estado === 'borrador' ? 'checked' : '' }}
            required
          >
          <label
            for="estado_borrador"
            class="segmented-btn"
            role="tab"
            aria-selected="{{ $estado === 'borrador' ? 'true' : 'false' }}"
            tabindex="{{ $estado === 'borrador' ? '0' : '-1' }}"
          >
            Borrador
          </label>
        </div>
      </div>

      @error('estado')
        <div class="invalid-feedback mt-2 text-center">{{ $message }}</div>
      @enderror
    </fieldset>

    {{-- =======================
         BOTONES
       ======================= --}}
    <div class="pt-4 text-center flex flex-col sm:flex-row justify-center gap-3">
      <button type="submit" class="btn-brand w-full sm:w-auto px-5 py-2.5">
        Guardar noticia
      </button>
      <a href="{{ route('admin.noticias.index') }}"
         class="btn-brand w-full sm:w-auto px-5 py-2.5 text-center">
        Cancelar
      </a>
    </div>

  </form>
</section>
@endsection
