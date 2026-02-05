@extends('layouts.app')

@section('title','Contacto')
@section('meta_description','Contacto de Academia Ariete: teléfonos, dirección, correo y formulario.')

@section('content')
<section class="contacto-page">

  {{-- Mensaje de éxito --}}
  @if (session('ok'))
    <div class="mb-4">
      <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 flex items-start gap-3">
        <span class="mt-0.5 inline-flex h-6 w-6 items-center justify-center rounded-full bg-emerald-100">
          <i class="fa-solid fa-check"></i>
        </span>
        <div class="text-left">
          <p class="font-semibold mb-0">Mensaje enviado correctamente</p>
          <p class="mb-0 text-xs md:text-[13px]">
            {{ session('ok') }}
          </p>
        </div>
      </div>
    </div>
  @endif

  {{-- Resumen de errores (sin duplicar "general") --}}
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

  {{-- Error general desde el controlador --}}
  @error('general')
    <div class="mb-4">
      <div class="rounded-xl border border-[rgba(185,28,28,0.4)] bg-[rgba(185,28,28,0.04)] px-4 py-3 text-sm text-[var(--baseariete)]" role="alert">
        {{ $message }}
      </div>
    </div>
  @enderror

  <h1 class="titulo">Contacto</h1>

  {{-- Tarjetas de contacto --}}
  <div class="cards mt-6">
    {{-- Teléfonos --}}
    <div class="contact-card">
      <div class="head">
        <span class="contact-icon" aria-hidden="true">
          {{-- Icono teléfono --}}
          <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
               viewBox="0 0 24 24" fill="none" stroke="#850e0e" stroke-width="2"
               stroke-linecap="round" stroke-linejoin="round">
            <path d="M13 2a9 9 0 0 1 9 9"/>
            <path d="M13 6a5 5 0 0 1 5 5"/>
            <path d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384"/>
          </svg>
        </span>
        <h3 class="text-lg">LLÁMANOS</h3>
      </div>
      <div class="title-underline"></div>
      <p class="text-slate-700 leading-7 font-semibold">
        <a href="tel:+34695576194" class="underline hover:no-underline">695 57 61 94</a>
        &nbsp;–&nbsp;
        <a href="tel:+34957482068" class="underline hover:no-underline">957 48 20 68</a>
      </p>
    </div>

    {{-- Dirección --}}
    <a
      class="card-link"
      href="https://www.google.com/maps/search/?api=1&query=Plaza+de+Col%C3%B3n%2C+23%2C+14001+C%C3%B3rdoba"
      target="_blank" rel="noopener noreferrer"
      aria-label="Abrir ubicación en Google Maps"
    >
      <div class="contact-card">
        <div class="head">
          <span class="contact-icon" aria-hidden="true">
            {{-- Icono mapa --}}
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                 viewBox="0 0 24 24" fill="none" stroke="#850e0e" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round">
              <path d="M18 8c0 3.613-3.869 7.429-5.393 8.795a1 1 0 0 1-1.214 0C9.87 15.429 6 11.613 6 8a6 6 0 0 1 12 0"/>
              <circle cx="12" cy="8" r="2"/>
              <path d="M8.714 14h-3.71a1 1 0 0 0-.948.683l-2.004 6A1 1 0 0 0 3 22h18a1 1 0 0 0 .948-1.316l-2-6a1 1 0 0 0-.949-.684h-3.712"/>
            </svg>
          </span>
          <h3 class="text-lg">DIRECCIÓN</h3>
        </div>
        <div class="title-underline"></div>
        <p class="text-slate-700 leading-7 font-semibold">
          Plaza de Colón, nº 23 &nbsp;–&nbsp; 14001 Córdoba
        </p>
      </div>
    </a>

    {{-- Correo --}}
    <a class="card-link" href="mailto:info@ariete.org" aria-label="Enviar correo a info@ariete.org">
      <div class="contact-card">
        <div class="head">
          <span class="contact-icon" aria-hidden="true">
            {{-- Icono correo --}}
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                 viewBox="0 0 24 24" fill="none" stroke="#850e0e" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round">
              <path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"/>
              <rect x="2" y="4" width="20" height="16" rx="2"/>
            </svg>
          </span>
          <h3 class="text-lg">CORREO</h3>
        </div>
        <div class="title-underline"></div>
        <p class="text-slate-700 leading-7 font-semibold">info@ariete.org</p>
      </div>
    </a>
  </div>

  {{-- Mapa --}}
  <div class="map-wrap mt-8">
    <iframe
      title="Mapa - Academia Ariete"
      width="100%" height="380" style="border:0;"
      loading="lazy" allowfullscreen
      referrerpolicy="no-referrer-when-downgrade"
      src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3172.541821786614!2d-4.7878201!3d37.8882346!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd6cdf2f0a0f9f6f%3A0x0000000000000000!2sPlaza%20de%20Col%C3%B3n%2C%2023%2C%2014001%20C%C3%B3rdoba!5e0!3m2!1ses!2ses!4v1700000000000">
    </iframe>
  </div>

  <h1 class="titulo mt-6">Escríbenos</h1>

  <form class="contact-form mt-3"
        action="{{ route('contacto.enviar') }}"
        method="POST"
        enctype="multipart/form-data"
        novalidate>
    @csrf

    {{-- GRID de campos --}}
    <div class="grid gap-4 md:grid-cols-2">

      {{-- Nombre --}}
      <div class="form-group">
        <label for="nombre" class="titulo @error('nombre') error @enderror">
          Nombre <span class="text-red-500">*</span>
        </label>
        <input
          id="nombre"
          name="nombre"
          type="text"
          required
          class="mt-1 block w-full @error('nombre') is-invalid @enderror"
          value="{{ old('nombre') }}"
          aria-invalid="@error('nombre') true @else false @enderror"
          aria-describedby="@error('nombre') nombre_error @enderror"
        >
        @error('nombre')
          <span id="nombre_error" class="invalid-feedback text-xs text-red-600 mt-1" role="alert">
            {{ $message }}
          </span>
        @enderror
      </div>

      {{-- Apellidos --}}
      <div class="form-group">
        <label for="apellidos" class="titulo @error('apellidos') error @enderror">
          Apellidos <span class="text-red-500">*</span>
        </label>
        <input
          id="apellidos"
          name="apellidos"
          type="text"
          required
          class="mt-1 block w-full @error('apellidos') is-invalid @enderror"
          value="{{ old('apellidos') }}"
          aria-invalid="@error('apellidos') true @else false @enderror"
          aria-describedby="@error('apellidos') apellidos_error @enderror"
        >
        @error('apellidos')
          <span id="apellidos_error" class="invalid-feedback text-xs text-red-600 mt-1" role="alert">
            {{ $message }}
          </span>
        @enderror
      </div>

      {{-- Email --}}
      <div class="form-group">
        <label for="email" class="titulo @error('email') error @enderror">
          Correo electrónico <span class="text-red-500">*</span>
        </label>
        <input
          id="email"
          name="email"
          type="email"
          required
          class="mt-1 block w-full @error('email') is-invalid @enderror"
          value="{{ old('email') }}"
          placeholder="tucorreo@ejemplo.com"
          aria-invalid="@error('email') true @else false @enderror"
          aria-describedby="@error('email') email_error @enderror"
        >
        @error('email')
          <span id="email_error" class="invalid-feedback text-xs text-red-600 mt-1" role="alert">
            {{ $message }}
          </span>
        @enderror
      </div>

      {{-- Teléfono --}}
      <div class="form-group">
        <label for="telefono" class="titulo @error('telefono') error @enderror">
          Teléfono <span class="text-red-500">*</span>
        </label>
        <input
          id="telefono"
          name="telefono"
          type="tel"
          inputmode="numeric"
          pattern="^[0-9]{9}$"
          maxlength="9"
          required
          placeholder="600123123"
          class="mt-1 block w-full @error('telefono') is-invalid @enderror"
          value="{{ old('telefono') }}"
          aria-invalid="@error('telefono') true @else false @enderror"
          aria-describedby="@error('telefono') telefono_error @enderror"
        >
        @error('telefono')
          <span id="telefono_error" class="invalid-feedback text-xs text-red-600 mt-1" role="alert">
            {{ $message }}
          </span>
        @enderror
      </div>

      {{-- Asunto --}}
      <div class="md:col-span-2 form-group">
        <label for="asunto" class="titulo @error('asunto') error @enderror">
          Asunto <span class="text-red-500">*</span>
        </label>
        <input
          id="asunto"
          name="asunto"
          type="text"
          required
          class="mt-1 block w-full @error('asunto') is-invalid @enderror"
          value="{{ old('asunto') }}"
          aria-invalid="@error('asunto') true @else false @enderror"
          aria-describedby="@error('asunto') asunto_error @enderror"
        >
        @error('asunto')
          <span id="asunto_error" class="invalid-feedback text-xs text-red-600 mt-1" role="alert">
            {{ $message }}
          </span>
        @enderror
      </div>

      {{-- Mensaje --}}
      <div class="md:col-span-2 form-group">
        <label for="mensaje" class="titulo @error('mensaje') error @enderror">
          Mensaje <span class="text-red-500">*</span>
        </label>
        <textarea
          id="mensaje"
          name="mensaje"
          rows="6"
          required
          class="mt-1 block w-full @error('mensaje') is-invalid @enderror"
          placeholder="Cuéntanos cómo podemos ayudarte…"
          aria-invalid="@error('mensaje') true @else false @enderror"
          aria-describedby="@error('mensaje') mensaje_error @enderror"
        >{{ old('mensaje') }}</textarea>
        @error('mensaje')
          <span id="mensaje_error" class="invalid-feedback text-xs text-red-600 mt-1" role="alert">
            {{ $message }}
          </span>
        @enderror
      </div>

      {{-- Adjuntar archivo --}}
      <div class="md:col-span-2 file-wrap form-group">
        <label class="titulo @error('adjunto') error @enderror" for="adjunto">
          Adjuntar archivo (opcional)
        </label>
        <div class="mt-2">
          {{-- Botón personalizado --}}
          <label for="adjunto" class="file-trigger btn-brand btn-uniform cursor-pointer inline-block">
            Seleccionar archivo
          </label>

          {{-- Input nativo oculto --}}
          <input
            id="adjunto"
            name="adjunto"
            type="file"
            accept=".pdf,image/*"
            class="file-input-hidden @error('adjunto') is-invalid @enderror"
            aria-invalid="@error('adjunto') true @else false @enderror"
            aria-describedby="@error('adjunto') adjunto_error @enderror"
          >

          {{-- Nombre del archivo seleccionado (lo rellena tu JS) --}}
          <span id="fileName" class="file-name">
            <strong>Ningún archivo seleccionado</strong>
          </span>
        </div>

        <p class="hint mt-2">
          <strong>Formatos permitidos: PDF/JPG/PNG. Tamaño máx. recomendado 5&nbsp;MB.</strong>
        </p>

        @error('adjunto')
          <span id="adjunto_error" class="invalid-feedback text-xs text-red-600 mt-1" role="alert">
            {{ $message }}
          </span>
        @enderror
      </div>
    </div> {{-- cierre GRID --}}

    {{-- Consentimiento --}}
    <div class="consent-box rounded-lg p-3 mt-2 form-group">
      <label class="inline-flex items-start gap-2">
        <input
          type="checkbox"
          name="acepto"
          value="1"
          required
          class="mt-1 @error('acepto') is-invalid @enderror"
          aria-invalid="@error('acepto') true @else false @enderror"
          aria-describedby="@error('acepto') acepto_error @enderror"
        >
        <strong>
          <span class="text-sm leading-6">
            Al hacer click en «Enviar» acepto la
            <a class="underline hover:no-underline"
               href="{{ route('politica-de-privacidad') }}"
               target="_blank" rel="noopener">
              política de privacidad
            </a>
            y doy mi consentimiento expreso para el
            <a class="underline hover:no-underline"
               href="{{ route('consentimiento-lopd') }}"
               target="_blank" rel="noopener">
              tratamiento de datos de carácter personal
            </a>.
          </span>
        </strong>
      </label>
      @error('acepto')
        <span id="acepto_error" class="invalid-feedback text-xs text-red-600 mt-1" role="alert">
          {{ $message }}
        </span>
      @enderror
    </div>

    {{-- Acciones: botón centrado --}}
    <div class="form-actions pt-4 text-center">
      <button type="submit" class="btn-brand btn-uniform">
        Enviar
      </button>
    </div>
  </form>
</section>
@endsection
