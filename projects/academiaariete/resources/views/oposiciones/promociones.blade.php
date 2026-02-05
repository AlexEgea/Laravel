@extends('layouts.app')
@section('title','Promociones')

@section('content')
<div class="container py-4" id="oposiciones-promociones">

  {{-- Breadcrumb --}}
  <nav class="mb-4 text-sm text-slate-600" aria-label="Breadcrumb">
    <ol class="flex flex-wrap items-center gap-1">
      <li><a href="{{ route('inicio') }}" class="hover:underline">Inicio</a></li>
      <li aria-hidden="true">/</li>
      <li><a href="{{ route('oposiciones') }}" class="hover:underline">Oposiciones</a></li>
      <li aria-hidden="true">/</li>
      <li class="text-slate-800 font-medium" aria-current="page">Promociones</li>
    </ol>
  </nav>

  <h1 class="titulo">Promociones y acuerdos</h1>
  <p class="text-slate-700 mt-2">
    Descubre nuestros convenios y descuentos activos. Las condiciones se aplican a nuevas altas salvo que se indique lo contrario.
  </p>

  {{-- Tarjetas --}}
  <div class="mt-6 grid gap-5 sm:grid-cols-2">

    {{-- OFERTA USO --}}
    <div class="contact-card h-full rounded-xl border border-slate-200 bg-white p-5 shadow-sm hover:shadow-md hover:border-slate-300 transition">
      <div class="flex items-center justify-between">
        <h2 class="text-lg font-semibold m-0">Oferta USO</h2>
        {{-- Icono: handshake --}}
        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
             viewBox="0 0 24 24" fill="none" stroke="#850e0e" stroke-width="2"
             stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M18 8a3 3 0 0 1 0 6h-1l-5 5-3-3"/>
          <path d="m2 12 5 5c1 1 3 1 4 0l3-3"/>
          <path d="M7 7h.01"/>
          <path d="M22 12 17 7c-1-1-3-1-4 0l-3 3"/>
        </svg>
      </div>
      <div class="title-underline w-16 h-[3px] bg-[var(--baseariete)]/80 rounded-full mt-2 mb-3"></div>

      <p class="mb-2"><strong>USO-Andalucía</strong> y <strong>Academia Ariete</strong> (Córdoba) han firmado un acuerdo especial de colaboración.</p>
      <ul class="list-disc ms-5 space-y-1 mb-3">
        <li>✅ Clases presenciales y online.</li>
      </ul>
      <p class="mb-0">
        ¡Aprovecha! <strong>Matrícula GRATIS</strong> en cualquier curso y <strong>10% de descuento</strong> en todas las mensualidades.
      </p>
    </div>

    {{-- OFERTA BRIGADA* --}}
    <div class="contact-card h-full rounded-xl border border-slate-200 bg-white p-5 shadow-sm hover:shadow-md hover:border-slate-300 transition">
      <div class="flex items-center justify-between">
        <h2 class="text-lg font-semibold m-0">Oferta Brigada <span class="text-slate-500">*</span></h2>
        {{-- Icono: military badge --}}
        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
             viewBox="0 0 24 24" fill="none" stroke="#850e0e" stroke-width="2"
             stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M12 2l7 4v6c0 5-3.5 8.5-7 10-3.5-1.5-7-5-7-10V6l7-4z"/>
          <path d="M9 10l3 3 3-3"/>
        </svg>
      </div>
      <div class="title-underline w-16 h-[3px] bg-[var(--baseariete)]/80 rounded-full mt-2 mb-3"></div>

      <p class="mb-2">
        Si perteneces al <strong>Ejército</strong>, te preparas con nosotros y te presentas a una oposición, tendrás:
      </p>
      <ul class="list-disc ms-5 space-y-1">
        <li><strong>Bonificación 100% de la matrícula.</strong></li>
        <li><strong>40% de descuento</strong> en cursos para acceso a Fuerzas y Cuerpos de Seguridad.</li>
        <li><strong>25% de descuento</strong> en otros cursos: Administrativo, Auxiliar, IIPP, Medioambiente, Correos, SAS, Justicia, Cuerpo de Maestros (Inglés, PT, Infantil, Primaria, Francés…), Profesorado Secundaria o FP.</li>
        <li><strong>50% de bonificación</strong> en material.</li>
      </ul>
      <p class="text-xs text-slate-500 mt-3 mb-0">*Consulta documentación acreditativa en secretaría.</p>
    </div>

    {{-- OFERTA CC.OO. --}}
    <div class="contact-card h-full rounded-xl border border-slate-200 bg-white p-5 shadow-sm hover:shadow-md hover:border-slate-300 transition">
      <div class="flex items-center justify-between">
        <h2 class="text-lg font-semibold m-0">Oferta CC.OO.</h2>
        {{-- Icono: megáfono --}}
        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
             viewBox="0 0 24 24" fill="none" stroke="#850e0e" stroke-width="2"
             stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M3 11v2a4 4 0 0 0 4 4h1"/>
          <path d="M21 8V6a2 2 0 0 0-2-2h-1l-7 4H3v4h8l7 4h1a2 2 0 0 0 2-2v-2"/>
        </svg>
      </div>
      <div class="title-underline w-16 h-[3px] bg-[var(--baseariete)]/80 rounded-full mt-2 mb-3"></div>

      <p class="mb-2">Si estás afiliad@ a <strong>CC.OO.</strong>, ¡enhorabuena!</p>
      <p class="mb-0">
        <strong>Matrícula GRATIS</strong> en cualquier curso y <strong>10% de descuento</strong> en todas las mensualidades, gracias al convenio con Academia Ariete.
      </p>
    </div>

    {{-- OFERTA JUCIL* --}}
    <div class="contact-card h-full rounded-xl border border-slate-200 bg-white p-5 shadow-sm hover:shadow-md hover:border-slate-300 transition">
      <div class="flex items-center justify-between">
        <h2 class="text-lg font-semibold m-0">Oferta JUCIL <span class="text-slate-500">*</span></h2>
        {{-- Icono: shield --}}
        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
             viewBox="0 0 24 24" fill="none" stroke="#850e0e" stroke-width="2"
             stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/>
        </svg>
      </div>
      <div class="title-underline w-16 h-[3px] bg-[var(--baseariete)]/80 rounded-full mt-2 mb-3"></div>

      <p class="mb-2">
        Si eres profesional de la <strong>Guardia Civil</strong> o familiar y te preparas con nosotros:
      </p>
      <ul class="list-disc ms-5 space-y-1">
        <li><strong>Solo Cuerpos y Fuerzas de Seguridad.</strong></li>
        <li><strong>Bonificación 100% de la matrícula.</strong></li>
        <li><strong>40% de descuento</strong> en cursos para acceso a Fuerzas y Cuerpos de Seguridad.</li>
      </ul>
      <p class="text-xs text-slate-500 mt-3">
        *Las ofertas se aplicarán únicamente con <strong>pago único</strong> o <strong>pago en tres plazos</strong>.
      </p>
      <p class="text-xs text-slate-500 mb-0">*Requiere acreditación JUCIL.</p>
    </div>

  </div>

  {{-- CTA inferior opcional --}}
  <div class="mt-8 rounded-lg border border-slate-200 bg-white p-5">
    <p class="m-0">
      ¿Tienes dudas sobre cómo aplicar una de estas promociones a tu matrícula? 
      <a href="{{ route('contacto') }}" class="font-semibold text-[var(--baseariete)] hover:underline">Escríbenos</a> y te ayudamos.
    </p>
  </div>
</div>
@endsection
