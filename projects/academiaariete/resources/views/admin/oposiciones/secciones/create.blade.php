@extends('layouts.app')
@section('title','Admin - Crear sección de oposiciones')

@section('content')
<section class="matricula-page">
  <h1 class="titulo">Crear sección de oposiciones</h1>

  <p class="mb-6 text-sm text-slate-600 max-w-2xl">
    Una <strong>sección</strong> es una familia de oposiciones, como
    <em>Fuerzas y Cuerpos de Seguridad</em>, <em>Junta de Andalucía</em>,
    <em>Estado</em>, etc. También puedes crear <strong>subsecciones</strong>
    eligiendo una sección padre.
  </p>

  <form action="{{ route('admin.oposiciones.secciones.store') }}" method="POST"
        class="form-matricula card p-6 stack"
        novalidate>
    @csrf

    @if ($errors->any())
      <div class="tarifa mb-4" role="alert" aria-live="polite">
        <span>Hay campos con errores. Revísalos por favor.</span>
      </div>
    @endif

    <div class="grid gap-4 md:grid-cols-1">

      {{-- NOMBRE DE LA SECCIÓN --}}
      <div>
        <label for="titulo" class="titulo @error('titulo') error @enderror">
          Nombre de la sección *
        </label>
        <input
          id="titulo"
          name="titulo"
          type="text"
          required
          class="mt-1 block w-full @error('titulo') is-invalid @enderror"
          value="{{ old('titulo') }}"
          aria-invalid="@error('titulo') true @else false @enderror"
          aria-describedby="@error('titulo') titulo_error @enderror"
        >
        <p class="hint">
          Ejemplos: <em>Fuerzas y Cuerpos de Seguridad</em>,
          <em>Junta de Andalucía</em>, <em>Estado</em>, <em>Corporaciones Locales</em>…
        </p>
        @error('titulo')
          <div id="titulo_error" class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      {{-- SECCIÓN PADRE OPCIONAL --}}
      <div>
        <label for="parent_id" class="titulo @error('parent_id') error @enderror">
          Sección padre (opcional)
        </label>
        <select
          id="parent_id"
          name="parent_id"
          class="mt-1 block w-full @error('parent_id') is-invalid @enderror"
          aria-invalid="@error('parent_id') true @else false @enderror"
          aria-describedby="@error('parent_id') parent_id_error @enderror"
        >
          <option value="">Sin sección padre (nivel raíz)</option>

          @isset($seccionesPadre)
            @foreach ($seccionesPadre as $seccion)
              @php
                // En este contexto las secciones vienen de Curso, que tiene "titulo"
                $tituloSeccion = $seccion->titulo ?: "Sección #{$seccion->id}";
              @endphp
              <option
                value="{{ $seccion->id }}"
                {{ (string) old('parent_id') === (string) $seccion->id ? 'selected' : '' }}
              >
                {{ $tituloSeccion }}
              </option>
            @endforeach
          @endisset
        </select>
        <p class="hint">
          Déjalo vacío para crear una sección principal. Selecciona una sección para crear una subsección dentro de ella.
        </p>
        @error('parent_id')
          <div id="parent_id_error" class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
    </div>

    {{-- BOTONES --}}
    <div class="pt-4 text-center flex flex-col sm:flex-row justify-center gap-3">
      <button type="submit" class="btn-brand w-full sm:w-auto px-5 py-2.5">
        Guardar sección
      </button>
      <a href="{{ route('admin.oposiciones.index') }}"
         class="btn-brand w-full sm:w-auto px-5 py-2.5 text-center">
        Cancelar
      </a>
    </div>
  </form>
</section>
@endsection
