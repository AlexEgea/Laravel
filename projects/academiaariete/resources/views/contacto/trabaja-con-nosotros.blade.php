@extends('layouts.app')
@section('title','Trabaja con nosotros')

@section('content')
<section class="trabaja-page">

  {{-- MENSAJE DE ÉXITO ARRIBA --}}
  @if (session('ok'))
    <div class="mb-4">
      <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 flex items-start gap-3">
        <span class="mt-0.5 inline-flex h-6 w-6 items-center justify-center rounded-full bg-emerald-100">
          <i class="fa-solid fa-check"></i>
        </span>
        <div class="text-left">
          <p class="font-semibold mb-0">Candidatura enviada correctamente</p>
          <p class="mb-0 text-xs md:text-[13px]">
            {{ session('ok') }}
          </p>
        </div>
      </div>
    </div>
  @endif

  {{-- BLOQUE DE ERRORES (sin duplicar "general") --}}
  @if ($errors->any())
    @php
        $mensajesGeneral = $errors->get('general') ?? [];
        $erroresCampos   = collect($errors->all())->diff($mensajesGeneral);
    @endphp

    @if ($erroresCampos->isNotEmpty())
      <div class="mb-4">
        <div class="rounded-xl border border-[rgba(185,28,28,0.4)] bg-[rgba(185,28,28,0.04)] px-4 py-3 text-sm text-[var(--baseariete)]">
          <p class="font-semibold mb-1">Hay campos con errores</p>
          <ul class="mb-0 text-xs md:text-[13px] list-disc list-inside">
            @foreach ($erroresCampos as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      </div>
    @endif
  @endif

  {{-- Error general (si lo usas desde el controlador) --}}
  @error('general')
    <div class="mb-4">
      <div class="rounded-xl border border-[rgba(185,28,28,0.4)] bg-[rgba(185,28,28,0.04)] px-4 py-3 text-sm text-[var(--baseariete)]" role="alert">
        {{ $message }}
      </div>
    </div>
  @enderror

  <h1 class="titulo">Trabaja con nosotros</h1>

  <form action="{{ route('trabajo.enviar') }}" method="POST"
        class="form-trabaja card p-6 stack"
        enctype="multipart/form-data" novalidate>
    @csrf

    {{-- PERFIL --}}
    @php $perfil = old('perfil','docente'); @endphp
    <fieldset class="perfil-fieldset">
      <h2 class="subtitulo">Perfil</h2>

      <div class="perfil-wrap">
        <div class="segmented mt-2" role="tablist" aria-label="Perfil">
          {{-- Docente --}}
          <input
            type="radio"
            id="perfil_docente"
            name="perfil"
            value="docente"
            class="segmented-input"
            {{ $perfil==='docente' ? 'checked' : '' }}
          >
          <label
            for="perfil_docente"
            class="segmented-btn"
            role="tab"
            aria-controls="areas_docente"
            aria-selected="{{ $perfil==='docente' ? 'true' : 'false' }}"
            tabindex="{{ $perfil==='docente' ? '0' : '-1' }}"
          >
            Docente
          </label>

          {{-- No docente --}}
          <input
            type="radio"
            id="perfil_no_docente"
            name="perfil"
            value="no_docente"
            class="segmented-input"
            {{ $perfil==='no_docente' ? 'checked' : '' }}
          >
          <label
            for="perfil_no_docente"
            class="segmented-btn"
            role="tab"
            aria-controls="areas_no_docente"
            aria-selected="{{ $perfil==='no_docente' ? 'true' : 'false' }}"
            tabindex="{{ $perfil==='no_docente' ? '0' : '-1' }}"
          >
            No docente
          </label>
        </div>
      </div>

      @error('perfil')
        <span class="invalid-feedback text-xs text-red-600 mt-2 block" role="alert">
          {{ $message }}
        </span>
      @enderror
    </fieldset>

    {{-- DATOS GENERALES (dos columnas) --}}
    <div class="grid gap-4 md:grid-cols-2">
      {{-- Nombre --}}
      <div>
        <label for="nombre" class="titulo @error('nombre') error @enderror">Nombre</label>
        <input id="nombre" name="nombre" type="text" required autocomplete="given-name"
               class="mt-1 block w-full @error('nombre') is-invalid @enderror"
               value="{{ old('nombre') }}"
               aria-invalid="@error('nombre') true @else false @enderror"
               aria-describedby="@error('nombre') nombre_error @enderror">
        @error('nombre')
          <span id="nombre_error" class="invalid-feedback text-xs text-red-600 mt-1" role="alert">
            {{ $message }}
          </span>
        @enderror
      </div>

      {{-- Apellidos --}}
      <div>
        <label for="apellidos" class="titulo @error('apellidos') error @enderror">Apellidos</label>
        <input id="apellidos" name="apellidos" type="text" required autocomplete="family-name"
               class="mt-1 block w-full @error('apellidos') is-invalid @enderror"
               value="{{ old('apellidos') }}"
               aria-invalid="@error('apellidos') true @else false @enderror"
               aria-describedby="@error('apellidos') apellidos_error @enderror">
        @error('apellidos')
          <span id="apellidos_error" class="invalid-feedback text-xs text-red-600 mt-1" role="alert">
            {{ $message }}
          </span>
        @enderror
      </div>

      {{-- Teléfono --}}
      <div>
        <label for="telefono" class="titulo @error('telefono') error @enderror">Teléfono</label>
        <input id="telefono" name="telefono" type="tel" inputmode="numeric" pattern="^[0-9]{9}$" maxlength="9" required
               placeholder="600123123" autocomplete="tel"
               class="mt-1 block w-full @error('telefono') is-invalid @enderror"
               value="{{ old('telefono') }}"
               aria-invalid="@error('telefono') true @else false @enderror"
               aria-describedby="@error('telefono') telefono_error @enderror">
        @error('telefono')
          <span id="telefono_error" class="invalid-feedback text-xs text-red-600 mt-1" role="alert">
            {{ $message }}
          </span>
        @enderror
      </div>

      {{-- Email --}}
      <div>
        <label for="email" class="titulo @error('email') error @enderror">Email</label>
        <input id="email" name="email" type="email" required autocomplete="email" placeholder="tu@correo.com"
               class="mt-1 block w-full @error('email') is-invalid @enderror"
               value="{{ old('email') }}"
               aria-invalid="@error('email') true @else false @enderror"
               aria-describedby="@error('email') email_error @enderror">
        @error('email')
          <span id="email_error" class="invalid-feedback text-xs text-red-600 mt-1" role="alert">
            {{ $message }}
          </span>
        @enderror
      </div>

      {{-- Población --}}
      <div>
        <label for="poblacion" class="titulo @error('poblacion') error @enderror">Población</label>
        <input id="poblacion" name="poblacion" type="text" required
               class="mt-1 block w-full @error('poblacion') is-invalid @enderror"
               value="{{ old('poblacion') }}"
               aria-invalid="@error('poblacion') true @else false @enderror"
               aria-describedby="@error('poblacion') poblacion_error @enderror">
        @error('poblacion')
          <span id="poblacion_error" class="invalid-feedback text-xs text-red-600 mt-1" role="alert">
            {{ $message }}
          </span>
        @enderror
      </div>

      {{-- Provincia --}}
      <div>
        <label for="provincia" class="titulo @error('provincia') error @enderror">Provincia</label>
        <input id="provincia" name="provincia" type="text" required
               class="mt-1 block w-full @error('provincia') is-invalid @enderror"
               value="{{ old('provincia') }}"
               aria-invalid="@error('provincia') true @else false @enderror"
               aria-describedby="@error('provincia') provincia_error @enderror">
        @error('provincia')
          <span id="provincia_error" class="invalid-feedback text-xs text-red-600 mt-1" role="alert">
            {{ $message }}
          </span>
        @enderror
      </div>

      {{-- Dirección --}}
      <div>
        <label for="direccion" class="titulo @error('direccion') error @enderror">Dirección</label>
        <input id="direccion" name="direccion" type="text" required autocomplete="street-address"
               class="mt-1 block w-full @error('direccion') is-invalid @enderror"
               value="{{ old('direccion') }}"
               aria-invalid="@error('direccion') true @else false @enderror"
               aria-describedby="@error('direccion') direccion_error @enderror">
        @error('direccion')
          <span id="direccion_error" class="invalid-feedback text-xs text-red-600 mt-1" role="alert">
            {{ $message }}
          </span>
        @enderror
      </div>

      {{-- Código postal --}}
      <div>
        <label for="cp" class="titulo @error('cp') error @enderror">Código postal</label>
        <input id="cp" name="cp" type="text" inputmode="numeric" pattern="^[0-9]{5}$" maxlength="5" required placeholder="14001"
               class="mt-1 block w-full @error('cp') is-invalid @enderror"
               value="{{ old('cp') }}"
               aria-invalid="@error('cp') true @else false @enderror"
               aria-describedby="@error('cp') cp_error @enderror">
        @error('cp')
          <span id="cp_error" class="invalid-feedback text-xs text-red-600 mt-1" role="alert">
            {{ $message }}
          </span>
        @enderror
      </div>
    </div>

    {{-- ÁREAS PROFESIONALES --}}
    @php $areasOld = collect(old('areas', [])); @endphp
    <fieldset class="mt-2">
      <legend class="subtitulo">Áreas profesionales (Seleccione las áreas en la que está especializado)</legend>

      {{-- Docente --}}
      <div id="areas_docente" class="mt-3 {{ $perfil==='docente' ? '' : 'hidden' }}">
        <div class="areas-grid grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2">
          @foreach ([
            'Actividades físicas y deportivas',
            'Administración y gestión',
            'Agraria',
            'Artes gráficas',
            'Artes y artesanías',
            'Comercio y marketing',
            'Competencias transversales',
            'Edificación y obra civil',
            'Electricidad y electrónica',
            'Energía y agua',
            'Fabricación mecánica',
            'Formación complementaria',
            'Hostelería y turismo',
            'Imagen personal',
            'Imagen y sonido',
            'Industrias alimentarias',
            'Industrias extractivas',
            'Informática y comunicaciones',
            'Instalación y mantenimiento',
            'Madera, mueble y corcho',
            'Marítimo-pesquera',
            'Química',
            'Sanidad',
            'Seguridad y medioambiente',
            'Servicios socioculturales a la comunidad',
            'Textil, confección y piel',
            'Transporte y mantenimiento de vehículos',
            'Vidrio y cerámica',
            'Vigilante de Seguridad'
          ] as $area)
            <label class="inline-block">
              <input
                type="checkbox"
                name="areas[]"
                value="{{ $area }}"
                class="sr-only peer"
                {{ $areasOld->contains($area) ? 'checked' : '' }}
              >
              <span
                class="relative flex items-center justify-center w-full
                       rounded-md border border-slate-300/40 px-3 py-2 text-sm
                       hover:bg-slate-100/50 hover:border-slate-400/50
                       focus:outline-none focus-visible:ring-2 focus-visible:ring-[var(--arietehover)]/40
                       peer-checked:bg-[var(--arietehover)] peer-checked:text-white
                       peer-checked:border-[var(--arietehover)] transition">

                <svg class="hidden peer-checked:block h-4 w-4 shrink-0 absolute left-2"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                  <polyline points="20 6 9 17 4 12"></polyline>
                </svg>

                <span class="truncate text-center font-semibold">{{ $area }}</span>
              </span>
            </label>
          @endforeach
        </div>
      </div>

      {{-- No docente --}}
      <div id="areas_no_docente" class="mt-3 {{ $perfil==='no_docente' ? '' : 'hidden' }}">
        <div class="areas-grid grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2">
          @foreach (['Administrativo','Informático','Limpieza'] as $area)
            <label class="inline-block">
              <input
                type="checkbox"
                name="areas[]"
                value="{{ $area }}"
                class="sr-only peer"
                {{ $areasOld->contains($area) ? 'checked' : '' }}
              >
              <span
                class="relative flex items-center justify-center w-full
                       rounded-md border border-slate-300/40 px-3 py-2 text-sm
                       hover:bg-slate-100/50 hover:border-slate-400/50
                       focus:outline-none focus-visible:ring-2 focus-visible:ring-[var(--arietehover)]/40
                       peer-checked:bg-[var(--arietehover)] peer-checked:text-white
                       peer-checked:border-[var(--arietehover)] transition">

                <svg class="hidden peer-checked:block h-4 w-4 shrink-0 absolute left-2"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                  <polyline points="20 6 9 17 4 12"></polyline>
                </svg>

                <span class="truncate text-center font-semibold">{{ $area }}</span>
              </span>
            </label>
          @endforeach
        </div>
      </div>

      @error('areas')
        <span class="invalid-feedback text-xs text-red-600 mt-2 block" role="alert">
          {{ $message }}
        </span>
      @enderror
    </fieldset>

    {{-- MENSAJE --}}
    <div>
      <label for="mensaje" class="titulo @error('mensaje') error @enderror">Mensaje de presentación</label>
      <textarea id="mensaje" name="mensaje" rows="4" required
                class="mt-1 block w-full @error('mensaje') is-invalid @enderror"
                placeholder="Cuéntanos brevemente tu perfil, experiencia, disponibilidad, etc."
                aria-invalid="@error('mensaje') true @else false @enderror"
                aria-describedby="@error('mensaje') mensaje_error @enderror">{{ old('mensaje') }}</textarea>
      @error('mensaje')
        <span id="mensaje_error" class="invalid-feedback text-xs text-red-600 mt-1" role="alert">
          {{ $message }}
        </span>
      @enderror
    </div>
    
    {{-- CURRÍCULUM --}}
    <div class="mt-4">
      <div class="rounded-lg border border-slate-200 bg-white/50 shadow-sm p-4">
        <div class="mb-2">
          <label class="titulo @error('cv') error @enderror">
            <strong>Currículum (PDF/DOC/DOCX)</strong>
          </label>
        </div>

        <input
          id="cv"
          name="cv"
          type="file"
          accept=".pdf,.doc,.docx"
          class="file-input-hidden @error('cv') is-invalid @enderror"
          aria-invalid="@error('cv') true @else false @enderror"
          aria-describedby="@error('cv') cv_error @enderror"
          onchange="
            const el = document.getElementById('cv_name');
            const name = this.files?.length ? Array.from(this.files).map(f => f.name).join(', ') : 'Ningún archivo seleccionado';
            el.textContent = name;
            el.title = name;
          "
        >

        <div class="file-inline" aria-live="polite">
          <label for="cv" class="btn-file" role="button" tabindex="0">Seleccionar archivo</label>
          <span class="file-msg" id="cv_name">Ningún archivo seleccionado</span>
        </div>

        <p class="hint mt-2"><strong>Formato recomendado: PDF. Tamaño máx. 5&nbsp;MB.</strong></p>

        @error('cv')
          <span id="cv_error" class="invalid-feedback text-xs text-red-600 mt-2" role="alert">
            {{ $message }}
          </span>
        @enderror
      </div>
    </div>

    {{-- CONSENTIMIENTO --}}
    <div class="mt-4">
      <label class="check-row">
        <input type="checkbox" name="acepta_privacidad" value="1" required
               {{ old('acepta_privacidad') ? 'checked' : '' }}>
        <span>
          Al hacer click en «Enviar» Acepto la
          <a href="{{ route('politica-de-privacidad') }}" class="fw-bold link-ariete-hover" style="color: var(--arietehover)"><strong>política de privacidad</strong></a>
          y doy mi consentimiento expreso para el
          <a href="{{ route('consentimiento-lopd') }}" class="fw-bold link-ariete-hover" style="color: var(--arietehover)"><strong>tratamiento de datos de carácter personal</strong></a>.
        </span>
      </label>
      @error('acepta_privacidad')
        <span class="invalid-feedback text-xs text-red-600 mt-1 block" role="alert">
          {{ $message }}
        </span>
      @enderror
    </div>
    
    {{-- BOTÓN --}}
    <div class="pt-2 text-center">
      <button type="submit" class="btn-brand w-full sm:w-auto px-5 py-2.5">
        Enviar solicitud
      </button>
    </div>
  </form>
</section>
@endsection
