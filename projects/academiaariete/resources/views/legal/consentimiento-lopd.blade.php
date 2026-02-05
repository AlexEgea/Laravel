@extends('layouts.app')

@section('title','Consentimiento LOPD')
@section('meta_description','Consentimiento expreso para el tratamiento de datos personales (LOPD/RGPD) de Academia Ariete.')

@section('content')
<article class="prose prose-slate max-w-none">
  <h1 class="titulo">Consentimiento LOPD</h1>

  <h2 class="subtitulo">Consentimiento expreso para el tratamiento de datos de carácter personal</h2>

  <p>
    En cumplimiento de la normativa en materia de protección de datos, y según lo establecido en el
    “Reglamento (UE) 2016/679 del Parlamento Europeo y del Consejo, de 27 de abril de 2016, relativo
    a la protección de las personas físicas en lo que respecta al tratamiento de datos personales y a
    la libre circulación de estos datos y por el que se deroga la Directiva 95/46/CE (Reglamento General
    de Protección de Datos – RGPD)”, el titular de los datos da su “consentimiento expreso” para que
    los datos de carácter personal facilitados por usted sean tratados en nuestros ficheros, de forma
    confidencial, con el fin de mantenerle informado, por cualquier medio incluidos los electrónicos,
    sobre los cursos y servicios ofertados por nuestro centro.
  </p>

  <p>
    Así mismo le informamos que usted podrá, en cualquier momento, ejercer los derechos de acceso,
    rectificación o supresión, o limitación de su tratamiento, o a oponerse al tratamiento, así como el
    derecho a la portabilidad de los datos, dirigiéndose por escrito y acompañando copia del DNI a la
    dirección postal o electrónica indicada en el cuadro de información básica que le mostramos a continuación.
  </p>

  <h2 class="subtitulo">INFORMACIÓN BÁSICA SOBRE PROTECCIÓN DE DATOS</h2>

<!-- Tabla de información básica -->
<div class="not-prose">
  <div class="overflow-hidden rounded-xl border border-[var(--baseariete)]/25 shadow-sm">
    <table class="w-full border-collapse">
      <caption class="sr-only">Información básica sobre protección de datos</caption>
      <tbody class="divide-y divide-[var(--baseariete)]/15">
        <tr class="bg-white/90">
          <th scope="row" class="w-56 align-middle p-4 text-left text-sm font-semibold text-[var(--baseariete)]">
            RESPONSABLE DEL TRATAMIENTO
          </th>
          <td class="p-4 text-slate-700">
            <p class="font-medium">ACADEMIA ARIETE</p>
            <p>Plaza de Colón, 23 – Local. 14001 – Córdoba</p>
            <a href="mailto:info@e-forsulting.es" class="underline hover:no-underline">info@e-forsulting.es</a>
          </td>
        </tr>

        <tr>
          <th scope="row" class="w-56 align-middle p-4 text-left text-sm font-semibold text-[var(--baseariete)]">
            FINALIDAD DEL TRATAMIENTO
          </th>
          <td class="p-4 text-slate-700">
            Envío de información sobre la actividad de Academia Ariete, los cursos y servicios que ofrece,
            solicitado por la persona interesada.
          </td>
        </tr>

        <tr class="bg-white/90">
          <th scope="row" class="w-56 align-middle p-4 text-left text-sm font-semibold text-[var(--baseariete)]">
            LEGITIMACIÓN DEL TRATAMIENTO
          </th>
          <td class="p-4 text-slate-700">
            El interesado da su “consentimiento expreso” para el tratamiento de sus datos personales.
          </td>
        </tr>

        <tr>
          <th scope="row" class="w-56 align-middle p-4 text-left text-sm font-semibold text-[var(--baseariete)]">
            DESTINATARIOS (de cesiones o transferencias)
          </th>
          <td class="p-4 text-slate-700">
            No se cederán ni comunicarán datos a terceros, salvo en caso de obligación legal.
          </td>
        </tr>

        <tr class="bg-white/90">
          <th scope="row" class="w-56 align-middle p-4 text-left text-sm font-semibold text-[var(--baseariete)]">
            DERECHOS DE LAS PERSONAS INTERESADAS
          </th>
          <td class="p-4 text-slate-700">
            En cumplimiento del RGPD (UE) 2016/679, 27 abril de 2016, puede ejercitar sus Derechos a acceder,
            y suprimir o rectificar sus datos personales, así como otros derechos, como se explica en la información adicional.
          </td>
        </tr>

        <tr>
          <th scope="row" class="w-56 align-middle p-4 text-left text-sm font-semibold text-[var(--baseariete)]">
            INFORMACIÓN ADICIONAL
          </th>
          <td class="p-4 text-slate-700">
            Puede consultar la información adicional y detallada sobre Protección de Datos solicitando directamente la
            información en la sede de nuestra oficina, o en nuestra página web:
            <a href="https://ariete.org" target="_blank" rel="noopener noreferrer" class="underline hover:no-underline">https://ariete.org</a>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
  <br>
  <a href="{{ route('politica-de-privacidad') }}" class="text-[var(--baseariete)] font-medium underline hover:no-underline">+Info…</a>
  <p class="text-sm mt-6">Última actualización: {{ date('d/m/Y') }}</p>
</article>
@endsection
