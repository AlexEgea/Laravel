@extends('layouts.app')
@section('title','Admin - Crear oposición')

@section('content')
<section class="matricula-page">
  <h1 class="titulo">Crear oposición</h1>

  <form action="{{ route('admin.oposiciones.store') }}" method="POST"
        class="form-matricula card p-6 stack"
        novalidate>
    @csrf

    @if ($errors->any())
      <div class="tarifa mb-4" role="alert" aria-live="polite">
        <span>Hay campos con errores. Revísalos por favor.</span>
      </div>
    @endif

    {{-- =======================
         1. DATOS PRINCIPALES
       ======================= --}}
    <h2 class="subtitulo mb-2">Datos principales</h2>
    <div class="grid gap-4 md:grid-cols-1">
      {{-- Nombre / Título --}}
      <div>
        <label for="titulo" class="titulo @error('titulo') error @enderror">
          Nombre de la oposición *
        </label>
        <input id="titulo" name="titulo" type="text" required
               class="mt-1 block w-full @error('titulo') is-invalid @enderror"
               value="{{ old('titulo') }}"
               aria-invalid="@error('titulo') true @else false @enderror"
               aria-describedby="@error('titulo') titulo_error @enderror">
        @error('titulo')
          <div id="titulo_error" class="invalid-feedback">{{ $message }}</div>
        @enderror
        <p class="hint">
          Ejemplo: <em>Policía Local Ayuntamiento de Córdoba</em>.
        </p>
      </div>

      {{-- Resumen --}}
      <div>
        <label for="resumen" class="titulo @error('resumen') error @enderror">
          Resumen (opcional)
        </label>
        <textarea id="resumen" name="resumen" rows="3"
                  class="mt-1 block w-full @error('resumen') is-invalid @enderror"
                  aria-invalid="@error('resumen') true @else false @enderror"
                  aria-describedby="@error('resumen') resumen_error @enderror">{{ old('resumen') }}</textarea>
        <p class="hint">
          Breve entradilla que aparecerá como avance de la oposición en listados.
        </p>
        @error('resumen')
          <div id="resumen_error" class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
    </div>

    {{-- =======================
         2. SECCIÓN (FAMILIA)
       ======================= --}}
    @php
      $parentOld = old('parent_id');
    @endphp

    <div class="mt-8">
      <h2 class="subtitulo mb-2 @error('parent_id') error @enderror">
        Sección de oposiciones (familia)
      </h2>
      <p class="hint">
        Elige una sección existente (por ejemplo
        <em>Fuerzas y Cuerpos de Seguridad</em>) o deja la opción
        <strong>Sin sección</strong> para que la oposición sea de nivel superior.
      </p>

      {{-- Opción: sin sección --}}
      <div class="mt-3">
        <label class="check-row inline-flex items-center gap-2 text-sm bg-slate-50 border border-slate-200 rounded-full px-3 py-1">
          <input
            type="radio"
            name="parent_id"
            value=""
            {{ $parentOld === null || $parentOld === '' ? 'checked' : '' }}
          >
          <span>Sin sección (oposición principal)</span>
        </label>
      </div>

      {{-- Secciones existentes --}}
      @if(isset($secciones) && $secciones->count())
        <div class="mt-3 flex flex-wrap gap-2">
          @foreach ($secciones as $seccion)
            <label
              class="check-row text-sm bg-slate-50 border border-slate-200 rounded-full px-3 py-1 flex items-center gap-2"
            >
              <input
                type="radio"
                name="parent_id"
                value="{{ $seccion->id }}"
                {{ (string)$parentOld === (string)$seccion->id ? 'checked' : '' }}
              >
              <span class="truncate max-w-[180px] md:max-w-[240px]">
                {{ $seccion->titulo }}
              </span>
            </label>
          @endforeach
        </div>
      @else
        <p class="hint mt-2">
          Todavía no hay secciones creadas. Primero crea una sección desde
          <strong>“Crear sección de oposiciones”</strong> en el panel de oposiciones.
        </p>
      @endif

      @error('parent_id')
        <div class="invalid-feedback mt-2">{{ $message }}</div>
      @enderror
    </div>

    {{-- =======================
         3. CONTENIDO PESTAÑAS
       ======================= --}}
    <div class="mt-8 border-t border-slate-200 pt-6">
      <h2 class="subtitulo mb-2">Contenido para las pestañas de la oposición</h2>
      <p class="hint mb-4">
        En la página pública se mostrará un carrusel con las pestañas:
        <strong>Información, Convocatoria anual, Requisitos, Examen, Concurso, Horario y precios, Equipo docente</strong>.
        Cada campo de abajo se corresponde con una de esas pestañas.
      </p>

      {{-- Información general (pestaña "Información") --}}
      <div class="mt-4">
        <div class="flex flex-wrap items-center justify-between gap-2 mb-1">
          <label for="contenido" class="titulo @error('descripcion') error @enderror">
            Información general (pestaña <strong>Información</strong>)
          </label>

          {{-- Botones de formato (igual que en noticias) --}}
          <div class="flex flex-wrap gap-2">
            <button type="button"
                    class="btn-brand px-3 py-1.5 text-xs"
                    onclick="insertSubtitulo()">
              Subtítulo
            </button>

            <button type="button"
                    class="btn-brand px-3 py-1.5 text-xs"
                    onclick="insertNegrita()">
              Negrita
            </button>

            <button type="button"
                    class="btn-brand px-3 py-1.5 text-xs"
                    onclick="insertCursiva()">
              Cursiva
            </button>

            <button type="button"
                    class="btn-brand px-3 py-1.5 text-xs"
                    onclick="insertLista('ul')">
              Lista •
            </button>

            <button type="button"
                    class="btn-brand px-3 py-1.5 text-xs"
                    onclick="insertLista('ol')">
              Lista 1.
            </button>

            <button type="button"
                    class="btn-brand px-3 py-1.5 text-xs"
                    onclick="insertEnlace()">
              Enlace
            </button>
          </div>
        </div>

        {{-- IMPORTANTE: id="contenido" para el JS; name="descripcion" --}}
        <textarea id="contenido" name="descripcion" rows="8"
                  class="mt-1 block w-full @error('descripcion') is-invalid @enderror"
                  aria-invalid="@error('descripcion') true @else false @enderror"
                  aria-describedby="@error('descripcion') descripcion_error @enderror">{{ old('descripcion') }}</textarea>

        <p class="hint">
          Texto de presentación de la oposición (se verá en la primera pestaña del carrusel).
        </p>

        @error('descripcion')
          <div id="descripcion_error" class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      {{-- A partir de aquí: resto de pestañas, texto libre sin botones de formato --}}

      {{-- Convocatoria anual --}}
      <div class="mt-6">
        <label for="convocatoria_anual" class="titulo @error('convocatoria_anual') error @enderror">
          Convocatoria anual
        </label>
        <textarea id="convocatoria_anual"
                  name="convocatoria_anual"
                  rows="4"
                  class="mt-1 block w-full @error('convocatoria_anual') is-invalid @enderror"
                  aria-invalid="@error('convocatoria_anual') true @else false @enderror"
                  aria-describedby="@error('convocatoria_anual') convocatoria_anual_error @enderror">{{ old('convocatoria_anual') }}</textarea>
        <p class="hint">
          Última convocatoria, BOE, plazas, calendario, etc.
        </p>
        @error('convocatoria_anual')
          <div id="convocatoria_anual_error" class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      {{-- Requisitos --}}
      <div class="mt-4">
        <label for="requisitos" class="titulo @error('requisitos') error @enderror">
          Requisitos
        </label>
        <textarea id="requisitos"
                  name="requisitos"
                  rows="4"
                  class="mt-1 block w-full @error('requisitos') is-invalid @enderror"
                  aria-invalid="@error('requisitos') true @else false @enderror"
                  aria-describedby="@error('requisitos') requisitos_error @enderror">{{ old('requisitos') }}</textarea>
        <p class="hint">
          Titulación, edad, permisos, condiciones físicas, otros requisitos...
        </p>
        @error('requisitos')
          <div id="requisitos_error" class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      {{-- Examen --}}
      <div class="mt-4">
        <label for="examen" class="titulo @error('examen') error @enderror">
          Examen
        </label>
        <textarea id="examen"
                  name="examen"
                  rows="4"
                  class="mt-1 block w-full @error('examen') is-invalid @enderror"
                  aria-invalid="@error('examen') true @else false @enderror"
                  aria-describedby="@error('examen') examen_error @enderror">{{ old('examen') }}</textarea>
        <p class="hint">
          Tipo de pruebas, número de ejercicios, pruebas físicas, psicotécnicos...
        </p>
        @error('examen')
          <div id="examen_error" class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      {{-- Concurso --}}
      <div class="mt-4">
        <label for="concurso" class="titulo @error('concurso') error @enderror">
          Concurso
        </label>
        <textarea id="concurso"
                  name="concurso"
                  rows="4"
                  class="mt-1 block w-full @error('concurso') is-invalid @enderror"
                  aria-invalid="@error('concurso') true @else false @enderror"
                  aria-describedby="@error('concurso') concurso_error @enderror">{{ old('concurso') }}</textarea>
        <p class="hint">
          Méritos, experiencia previa, formación complementaria, etc.
        </p>
        @error('concurso')
          <div id="concurso_error" class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      {{-- Horario y precios --}}
      <div class="mt-4">
        <label for="horario_precios" class="titulo @error('horario_precios') error @enderror">
          Horario y precios
        </label>
        <textarea id="horario_precios"
                  name="horario_precios"
                  rows="4"
                  class="mt-1 block w-full @error('horario_precios') is-invalid @enderror"
                  aria-invalid="@error('horario_precios') true @else false @enderror"
                  aria-describedby="@error('horario_precios') horario_precios_error @enderror">{{ old('horario_precios') }}</textarea>
        <p class="hint">
          Turnos, modalidad (online/presencial), cuotas, formas de pago, descuentos...
        </p>
        @error('horario_precios')
          <div id="horario_precios_error" class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      {{-- Equipo docente --}}
      <div class="mt-4">
        <label for="equipo_docente" class="titulo @error('equipo_docente') error @enderror">
          Equipo docente
        </label>
        <textarea id="equipo_docente"
                  name="equipo_docente"
                  rows="4"
                  class="mt-1 block w-full @error('equipo_docente') is-invalid @enderror"
                  aria-invalid="@error('equipo_docente') true @else false @enderror"
                  aria-describedby="@error('equipo_docente') equipo_docente_error @enderror">{{ old('equipo_docente') }}</textarea>
        <p class="hint">
          Perfil del profesorado, experiencia, cuerpos a los que pertenecen, etc.
        </p>
        @error('equipo_docente')
          <div id="equipo_docente_error" class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
    </div>

    {{-- =======================
         4. ESTADO
       ======================= --}}
    @php $estado = old('estado','publicar'); @endphp
    <fieldset class="mt-8">
      <legend class="subtitulo text-center">Estado de la oposición</legend>

      <div class="mt-3 flex justify-center">
        <div class="segmented" role="tablist" aria-label="Estado de la oposición">
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
        Guardar oposición
      </button>
      <a href="{{ route('admin.oposiciones.index') }}"
         class="btn-brand w-full sm:w-auto px-5 py-2.5 text-center">
        Cancelar
      </a>
    </div>

  </form>
</section>
@endsection
