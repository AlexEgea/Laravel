@extends('layouts.app')
@section('title','Contactar')

@section('content')
<div class="container py-4 contacto-index">

  {{-- Mensajes arriba --}}
  @if (session('ok'))
    <div class="mb-4">
      <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 flex items-start gap-3">
        <span class="mt-0.5 inline-flex h-6 w-6 items-center justify-center rounded-full bg-emerald-100">
          <i class="fa-solid fa-check"></i>
        </span>
        <div class="text-left">
          <p class="font-semibold mb-0">Operación correcta</p>
          <p class="mb-0 text-xs md:text-[13px]">
            {{ session('ok') }}
          </p>
        </div>
      </div>
    </div>
  @endif

  @if ($errors->any())
    <div class="mb-4">
      <div class="rounded-xl border border-[rgba(185,28,28,0.4)] bg-[rgba(185,28,28,0.04)] px-4 py-3 text-sm text-[var(--baseariete)]">
        <p class="font-semibold mb-1">Hay campos con errores</p>
        <p class="mb-0 text-xs md:text-[13px]">Revísalos por favor.</p>
      </div>
    </div>
  @endif

  <h1 class="titulo">¿En qué podemos ayudarte?</h1>

  {{-- Tarjetas de opciones --}}
  <div class="row cards mt-3" style="--bs-gutter-x:1.25rem; --bs-gutter-y:1.25rem;">

    {{-- Contacto --}}
    <div class="col-12 col-md-4 mb-4 mb-md-0">
      <a class="card-link text-decoration-none d-block h-100" href="{{ route('contacto') }}">
        <div class="contact-card text-center h-100">
          <div class="head d-flex align-items-center justify-content-center gap-2 mb-2">
            <span class="contact-icon" aria-hidden="true">
              {{-- Icono --}}
              <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                   viewBox="0 0 24 24" fill="none" stroke="#850e0e" stroke-width="2"
                   stroke-linecap="round" stroke-linejoin="round"
                   class="lucide lucide-id-card-icon lucide-id-card">
                <path d="M16 10h2"/>
                <path d="M16 14h2"/>
                <path d="M6.17 15a3 3 0 0 1 5.66 0"/>
                <circle cx="9" cy="11" r="2"/>
                <rect x="2" y="5" width="20" height="14" rx="2"/>
              </svg>
            </span>
            <h3 class="text-lg m-0">Contacto</h3>
          </div>
          <div class="title-underline mx-auto mb-3"></div>
          <p class="text-slate-700 leading-7 font-semibold mb-0">
            Formulario de contacto y dudas generales.
          </p>
        </div>
      </a>
    </div>

    {{-- Trabaja con nosotros --}}
    <div class="col-12 col-md-4 mb-4 mb-md-0">
      <a class="card-link text-decoration-none d-block h-100" href="{{ route('trabaja.index') }}">
        <div class="contact-card text-center h-100">
          <div class="head d-flex align-items-center justify-content-center gap-2 mb-2">
            <span class="contact-icon" aria-hidden="true">
              {{-- Icono --}}
              <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                   viewBox="0 0 24 24" fill="none" stroke="#850e0e" stroke-width="2"
                   stroke-linecap="round" stroke-linejoin="round"
                   class="lucide lucide-briefcase-business-icon lucide-briefcase-business">
                <path d="M12 12h.01"/>
                <path d="M16 6V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/>
                <path d="M22 13a18.15 18.15 0 0 1-20 0"/>
                <rect width="20" height="14" x="2" y="6" rx="2"/>
              </svg>
            </span>
            <h3 class="text-lg m-0">Trabaja con nosotros</h3>
          </div>
          <div class="title-underline mx-auto mb-3"></div>
          <p class="text-slate-700 leading-7 font-semibold mb-0">
            Envía tu candidatura y únete al equipo.
          </p>
        </div>
      </a>
    </div>

    {{-- Términos y condiciones --}}
    <div class="col-12 col-md-4 mb-4 mb-md-0">
      <a class="card-link text-decoration-none d-block h-100" href="{{ route('contacto.terminos') }}">
        <div class="contact-card text-center h-100">
          <div class="head d-flex align-items-center justify-content-center gap-2 mb-2">
            <span class="contact-icon" aria-hidden="true">
              {{-- Icono --}}
              <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                   viewBox="0 0 24 24" fill="none" stroke="#850e0e" stroke-width="2"
                   stroke-linecap="round" stroke-linejoin="round"
                   class="lucide lucide-file-lock2-icon lucide-file-lock-2">
                <path d="M4 22h14a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v1"/>
                <path d="M14 2v4a2 2 0 0 0 2 2h4"/>
                <rect width="8" height="5" x="2" y="13" rx="1"/>
                <path d="M8 13v-2a2 2 0 1 0-4 0v2"/>
              </svg>
            </span>
            <h3 class="text-lg m-0">Términos y condiciones</h3>
          </div>
          <div class="title-underline mx-auto mb-3"></div>
          <p class="text-slate-700 leading-7 font-semibold mb-0">
            Consulta las condiciones de uso y políticas.
          </p>
        </div>
      </a>
    </div>

  </div>
</div>
@endsection
