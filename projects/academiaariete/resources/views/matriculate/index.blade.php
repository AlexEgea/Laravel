@extends('layouts.app')
@section('title','Matricúlate')

@section('content')
<section class="matricula-page">
  <h1 class="titulo">Matrícula</h1>

  {{-- Mensaje de éxito bonito --}}
  @if (session('ok'))
    <div
      class="mt-4 mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-900 flex items-start gap-3"
      role="status"
      aria-live="polite"
    >
      <div class="mt-0.5">
        {{-- Icono check --}}
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
             viewBox="0 0 24 24" fill="none" stroke="currentColor"
             stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
          <polyline points="22 4 12 14.01 9 11.01"/>
        </svg>
      </div>
      <div>
        <p class="font-semibold text-sm md:text-base">
          Matrícula enviada correctamente
        </p>
        <p class="mt-1 text-xs md:text-sm">
          {{ session('ok') }}
        </p>
      </div>
    </div>
  @endif

  <form action="{{ route('matricula.enviar') }}" method="POST"
        class="form-matricula card p-6 stack"
        enctype="multipart/form-data" novalidate>
    @csrf

    @if ($errors->any())
      <div class="tarifa mb-4" role="alert" aria-live="polite">
        <span>Hay campos con errores. Revísalos por favor.</span>
      </div>
    @endif

    <ul class="list-disc ms-5 mb-8">
      <li>El siguiente formulario implica una reserva de plaza en la especialidad escogida. Si finalmente no 
      se comenzara el curso por falta de número mínimo de alumnos o el alumno no quisiera comenzar el curso, 
      se le devolverá el importe de la matrícula abonada <b>(20€ para el curso actual)</b>.</li>
      <li>En el último caso <b>solo se realizará la devolución si se avisa, como mínimo, 
      10 días antes del comienzo de las clases</b>.</li>
      <li>El ingreso de la matrícula se realizará en el siguiente número de cuenta:</li>
      <li class="centrar"><b>ES41 0030 4001 9102 9908 1273</b></li>
      <li>No olvides adjuntar el ingreso del pago en el formulario de la matrícula.</li>
      <li>Aconsejamos contactar con nosotros previamente al envío de la matrícula vía telefónica para 
      conocer todos los detalles del curso elegido.</li>
      <li>Nos pondremos en contacto contigo una vez recibido el formulario y comprobado los datos.</li>
      <li>De igual manera, aconsejamos revisar todos los campos antes de proceder al envío del cuestionario y es 
      muy importante que pases luego por la oficina para <b>firmar la matrícula y formalizarla</b>.</li>
      <li class="centrar"><b>¡MUCHAS GRACIAS POR CONFIAR EN NOSOTROS!</b></li>
    </ul>

    <h1 class="titulo">Matriculación</h1>

    {{-- Curso de matriculación (se carga por JS) --}}
    <div>
      <label for="curso_matriculacion" class="titulo @error('curso_matriculacion') error @enderror">Curso de matriculación</label>
      <select id="curso_matriculacion" name="curso_matriculacion" required
              class="mt-1 block w-full @error('curso_matriculacion') is-invalid @enderror"
              aria-invalid="@error('curso_matriculacion') true @else false @enderror"
              aria-describedby="@error('curso_matriculacion') curso_matriculacion_error @enderror"
              data-initial="{{ old('curso_matriculacion') }}">
        <option value="" disabled {{ old('curso_matriculacion') ? '' : 'selected' }}>Selecciona curso…</option>
      </select>
      @error('curso_matriculacion')
        <div id="curso_matriculacion_error" class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="grid gap-4 md:grid-cols-2">
      <div>
        <label for="nombre" class="titulo @error('nombre') error @enderror">Nombre</label>
        <input id="nombre" name="nombre" type="text" required autocomplete="given-name"
               class="mt-1 block w-full @error('nombre') is-invalid @enderror"
               value="{{ old('nombre') }}"
               aria-invalid="@error('nombre') true @else false @enderror"
               aria-describedby="@error('nombre') nombre_error @enderror">
        @error('nombre')
          <div id="nombre_error" class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div>
        <label for="apellido1" class="titulo @error('apellido1') error @enderror">Primer Apellido</label>
        <input id="apellido1" name="apellido1" type="text" required autocomplete="family-name"
               class="mt-1 block w-full @error('apellido1') is-invalid @enderror"
               value="{{ old('apellido1') }}"
               aria-invalid="@error('apellido1') true @else false @enderror"
               aria-describedby="@error('apellido1') apellido1_error @enderror">
        @error('apellido1')
          <div id="apellido1_error" class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div>
        <label for="apellido2" class="titulo @error('apellido2') error @enderror">Segundo Apellido</label>
        <input id="apellido2" name="apellido2" type="text" required
               class="mt-1 block w-full @error('apellido2') is-invalid @enderror"
               value="{{ old('apellido2') }}"
               aria-invalid="@error('apellido2') true @else false @enderror"
               aria-describedby="@error('apellido2') apellido2_error @enderror">
        @error('apellido2')
          <div id="apellido2_error" class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div>
        <label for="dni" class="titulo @error('dni') error @enderror">DNI</label>
        <input id="dni" name="dni" type="text" required pattern="^[0-9]{8}[A-Za-z]$" placeholder="12345678Z"
               class="mt-1 block w-full uppercase @error('dni') is-invalid @enderror"
               value="{{ old('dni') }}"
               aria-invalid="@error('dni') true @else false @enderror"
               aria-describedby="dni_hint @error('dni') dni_error @enderror">
        <p id="dni_hint" class="hint">Formato: 8 dígitos y una letra.</p>
        @error('dni')
          <div id="dni_error" class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="md:col-span-2">
        <label for="direccion" class="titulo @error('direccion') error @enderror">Dirección</label>
        <input id="direccion" name="direccion" type="text" required autocomplete="street-address"
               class="mt-1 block w-full @error('direccion') is-invalid @enderror"
               value="{{ old('direccion') }}"
               aria-invalid="@error('direccion') true @else false @enderror"
               aria-describedby="@error('direccion') direccion_error @enderror">
        @error('direccion')
          <div id="direccion_error" class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div>
        <label for="cp" class="titulo @error('cp') error @enderror">Código postal</label>
        <input id="cp" name="cp" type="text" inputmode="numeric" pattern="^[0-9]{5}$" maxlength="5" required placeholder="14001"
               class="mt-1 block w-full @error('cp') is-invalid @enderror"
               value="{{ old('cp') }}"
               aria-invalid="@error('cp') true @else false @enderror"
               aria-describedby="@error('cp') cp_error @enderror">
        @error('cp')
          <div id="cp_error" class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div>
        <label for="poblacion" class="titulo @error('poblacion') error @enderror">Población</label>
        <input id="poblacion" name="poblacion" type="text" required
               class="mt-1 block w-full @error('poblacion') is-invalid @enderror"
               value="{{ old('poblacion') }}"
               aria-invalid="@error('poblacion') true @else false @enderror"
               aria-describedby="@error('poblacion') poblacion_error @enderror">
        @error('poblacion')
          <div id="poblacion_error" class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div>
        <label for="provincia" class="titulo @error('provincia') error @enderror">Provincia</label>
        <input id="provincia" name="provincia" type="text" required
               class="mt-1 block w-full @error('provincia') is-invalid @enderror"
               value="{{ old('provincia') }}"
               aria-invalid="@error('provincia') true @else false @enderror"
               aria-describedby="@error('provincia') provincia_error @enderror">
        @error('provincia')
          <div id="provincia_error" class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div>
        <label for="telefono" class="titulo @error('telefono') error @enderror">Teléfono</label>
        <input id="telefono" name="telefono" type="tel" inputmode="numeric" pattern="^[0-9]{9}$" maxlength="9" required
               placeholder="600123123" autocomplete="tel"
               class="mt-1 block w-full @error('telefono') is-invalid @enderror"
               value="{{ old('telefono') }}"
               aria-invalid="@error('telefono') true @else false @enderror"
               aria-describedby="@error('telefono') telefono_error @enderror">
        @error('telefono')
          <div id="telefono_error" class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div>
        <label for="email" class="titulo @error('email') error @enderror">Email</label>
        <input id="email" name="email" type="email" required autocomplete="email" placeholder="tu@correo.com"
               class="mt-1 block w-full @error('email') is-invalid @enderror"
               value="{{ old('email') }}"
               aria-invalid="@error('email') true @else false @enderror"
               aria-describedby="@error('email') email_error @enderror">
        @error('email')
          <div id="email_error" class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div>
        <label for="nacimiento" class="titulo @error('nacimiento') error @enderror">Fecha de nacimiento</label>
        <input id="nacimiento" name="nacimiento" type="date" required
               class="mt-1 block w-full @error('nacimiento') is-invalid @enderror"
               value="{{ old('nacimiento') }}"
               aria-invalid="@error('nacimiento') true @else false @enderror"
               aria-describedby="@error('nacimiento') nacimiento_error @enderror">
        @error('nacimiento')
          <div id="nacimiento_error" class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
    </div>

    {{-- TITULACIÓN (desde BD) --}}
    <div>
      <label for="titulacion_id" class="titulo @error('titulacion_id') error @enderror">Titulación</label>
      <select id="titulacion_id" name="titulacion_id" required
              class="mt-1 block w-full @error('titulacion_id') is-invalid @enderror"
              aria-invalid="@error('titulacion_id') true @else false @enderror"
              aria-describedby="@error('titulacion_id') titulacion_id_error @enderror">
        @php $oldTit = old('titulacion_id'); @endphp
        <option value="" disabled {{ $oldTit ? '' : 'selected' }}>Selecciona tu titulación…</option>

        @foreach ($titulaciones as $tit)
          <option value="{{ $tit->id }}" {{ (string)$oldTit === (string)$tit->id ? 'selected' : '' }}>
            {{ $tit->nombre }}
          </option>
        @endforeach
      </select>
      @error('titulacion_id')
        <div id="titulacion_id_error" class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    {{-- CURSO / MÓDULO DE OPOSICIONES (desde BD, agrupado por sección) --}}
    <div>
      <label for="curso_modulo_id" class="titulo @error('curso_modulo_id') error @enderror">
        Curso / Módulo de oposiciones
      </label>
      <select id="curso_modulo_id" name="curso_modulo_id" required
              class="mt-1 block w-full @error('curso_modulo_id') is-invalid @enderror"
              aria-invalid="@error('curso_modulo_id') true @else false @enderror"
              aria-describedby="@error('curso_modulo_id') curso_modulo_id_error @enderror">
        @php $oldCurso = old('curso_modulo_id'); @endphp
        <option value="" disabled {{ $oldCurso ? '' : 'selected' }}>Selecciona un módulo…</option>

        @foreach ($oposicionesAgrupadas as $grupo => $oposiciones)
          <optgroup label="{{ $grupo }}">
            @foreach ($oposiciones as $op)
              <option value="{{ $op->id }}" {{ (string)$oldCurso === (string)$op->id ? 'selected' : '' }}>
                {{ $op->titulo }}
              </option>
            @endforeach
          </optgroup>
        @endforeach
      </select>
      @error('curso_modulo_id')
        <div id="curso_modulo_id_error" class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    {{-- ¿CÓMO NOS HAS CONOCIDO? (desde BD) --}}
    <div>
      @php
        $oldOrigenId = old('origen_id');
        $origenSeleccionado = $oldOrigenId ? $conocidos->firstWhere('id', (int)$oldOrigenId) : null;
        $mostrarOtros = false;
        if ($origenSeleccionado) {
            $nombreLower = mb_strtolower($origenSeleccionado->nombre, 'UTF-8');
            $mostrarOtros = ($nombreLower === 'otros') || (!is_null($origenSeleccionado->requiere_detalle ?? null) && (int)$origenSeleccionado->requiere_detalle === 1);
        }
      @endphp

      <label for="origen" class="titulo @error('origen_id') error @enderror">
        ¿Cómo nos has conocido?
      </label>
      <select id="origen" name="origen_id" required
              class="mt-1 block w-full @error('origen_id') is-invalid @enderror"
              aria-invalid="@error('origen_id') true @else false @enderror"
              aria-describedby="@error('origen_id') origen_id_error @enderror"
              data-initial="{{ $oldOrigenId }}">
        <option value="" disabled {{ $oldOrigenId ? '' : 'selected' }}>Selecciona una opción…</option>

        @foreach ($conocidos as $conocido)
          <option value="{{ $conocido->id }}"
                  data-nombre="{{ $conocido->nombre }}"
                  data-requiere-detalle="{{ (int)($conocido->requiere_detalle ?? 0) }}"
                  {{ (string)$oldOrigenId === (string)$conocido->id ? 'selected' : '' }}>
            {{ $conocido->nombre }}
          </option>
        @endforeach
      </select>
      @error('origen_id')
        <div id="origen_id_error" class="invalid-feedback">{{ $message }}</div>
      @enderror

      <div id="origen-otros-wrap" class="mt-3 {{ $mostrarOtros ? '' : 'hidden' }}">
        <label for="origen_otros" class="titulo @error('origen_otros') error @enderror">Cuéntanos más</label>
        <input id="origen_otros" name="origen_otros" type="text"
               class="mt-1 block w-full @error('origen_otros') is-invalid @enderror"
               placeholder="Explícalo brevemente…" value="{{ old('origen_otros') }}"
               aria-invalid="@error('origen_otros') true @else false @enderror"
               aria-describedby="@error('origen_otros') origen_otros_error @enderror">
        @error('origen_otros')
          <div id="origen_otros_error" class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
    </div>

    {{-- FORMA DE PAGO (centrado + segmentado) --}}
    @php $fp = old('forma_pago'); @endphp
    <fieldset class="mt-6">
      <legend class="subtitulo text-center">Forma de pago</legend>

      <div class="mt-3 flex justify-center">
        <div class="segmented" role="tablist" aria-label="Forma de pago">
          {{-- Mensual --}}
          <input
            type="radio"
            id="fp_mensual"
            name="forma_pago"
            value="mensual"
            class="segmented-input"
            {{ $fp==='mensual' ? 'checked' : '' }}
            required
          >
          <label
            for="fp_mensual"
            class="segmented-btn"
            role="tab"
            aria-selected="{{ $fp==='mensual' ? 'true' : 'false' }}"
            tabindex="{{ $fp==='mensual' ? '0' : '-1' }}"
          >
            Mensual
          </label>

          {{-- Al contado --}}
          <input
            type="radio"
            id="fp_contado"
            name="forma_pago"
            value="contado"
            class="segmented-input"
            {{ $fp==='contado' ? 'checked' : '' }}
            required
          >
          <label
            for="fp_contado"
            class="segmented-btn"
            role="tab"
            aria-selected="{{ $fp==='contado' ? 'true' : 'false' }}"
            tabindex="{{ $fp==='contado' ? '0' : '-1' }}"
          >
            Al contado
          </label>
        </div>
      </div>

      @error('forma_pago')
        <div class="invalid-feedback mt-2 text-center">{{ $message }}</div>
      @enderror
    </fieldset>

    <div class="tarifa">
      <h3 class="subtitulo">Tarifa actual: <span id="tarifa_value">20€</span></h3>
    </div>

    <div>
      <label for="observaciones" class="titulo @error('observaciones') error @enderror">Observaciones</label>
      <textarea id="observaciones" name="observaciones" rows="4" required
                class="mt-1 block w-full @error('observaciones') is-invalid @enderror"
                placeholder="Añade cualquier detalle relevante…"
                aria-invalid="@error('observaciones') true @else false @enderror"
                aria-describedby="@error('observaciones') observaciones_error @enderror">{{ old('observaciones') }}</textarea>
      @error('observaciones')
        <div id="observaciones_error" class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    {{-- =========================
         CLÁUSULAS
         ========================= --}}
    <fieldset class="clausulas-box">
      <legend class="subtitulo">Cláusulas</legend>

      <p>Ambas partes se comprometen a:</p>
      <ul class="list ms-5 space-y-2">
        <li>1.- ARIETE asignará al alumno un cuadro de profesores, debidamente cualificados y le proporcionará la orientación necesaria en el transcurso de los estudios.</li>
        <li>2.- ARIETE pondrá a disposición del alumno, a través del tablón de anuncios de su sede, la información relativa a las oposiciones del curso en que se encuentre matriculado, que se publiquen en boletines oficiales, incluso una vez finalizado el curso.</li>
        <li>3.- ARIETE se reserva la facultad de no impartir este curso si no hay matriculados un mínimo de 10 alumnos en la fecha prevista de inicio, o suspenderlo si una vez comenzado disminuye el número de alumnos de esta cifra. En estos casos ARIETE devolverá íntegro los importes abonados y no consumidos.</li>
        <li>4.- El alumno admite conocer y recibir las normas de régimen interior establecidas por Ariete, las cuales se adjuntan con este contrato.</li>
        <li>5.- El alumno abonará el importe de los honorarios de enseñanza, de acuerdo con las citadas normas de Régimen Interior. No se podrá reducir el importe de las mensualidades fijadas en el contrato por ningún motivo.</li>
        <li>6.- La baja voluntaria del alumno ha de comunicarse al Centro, de acuerdo con las normas de Régimen Interior.</li>
        <li>7.- Este contrato se resuelve por los motivos que figuran en las normas de Régimen Interior.</li>
        <li>8.- El titular se compromete a comunicar por escrito al Centro cualquier modificación que se produzca en los datos aportados. En cualquier momento podrá ejercer sus derechos de acceso, rectificación o supresión, limitación de su tratamiento, o a oponerse al tratamiento, así como el derecho a la portabilidad de los datos, adjuntando fotocopia de su DNI, dirigida al Responsable del Fichero: FORSULTING, S.L. – Plaza de Colón, 23– 14001 Córdoba. Para ampliar información sobre da9li9iríjase a nuestra sede, o consulte nuestra página web: http://www.forsulting.es</li>
        <li>9.- Para el cumplimiento e interpretación del presente documento las partes se someten de común acuerdo a la Junta Arbitral de Consumo del Ayuntamiento de Córdoba. Sin perjuicio de lo que puedan dictar los tribunales de Córdoba, con renuncia expresa al fuero, que por cualquier causa, a las partes pudiera corresponderle.</li>
      </ul>

      <p class="mt-4">Este conjunto de instrucciones intenta propiciar el adecuado funcionamiento del Centro, así como cada uno de los cursos que en él se organizan y coordinan. Contando siempre con la buena voluntad de las partes.</p>

      <ul class="ms-5 space-y-2 mt-2">
        <li>1.- Se ruega puntualidad en el inicio de las clases, al igual que en el tiempo determinado para el descanso en los cursos que exista. Durante dicho descanso se procurará no entorpecer el trabajo del resto de las clases.</li>
        <li>2.- Está prohibido fumar en cualquier lugar del interior de las instalaciones escolares. En el interior de las Aulas está prohibido comer, beber y entrar con móviles encendidos. (Se permiten botellines y vasos de plástico para agua, siendo retirados por el usuario al acabar la clase).</li>
        <li>3.- Se exige al alumno, el más estricto respeto al profesorado del Centro, así como un comportamiento adecuado dentro y fuera del aula, su incumplimiento será motivo de baja obligatoria en el Centro. Así como el fumar en el interior de las instalaciones escolares.</li>
        <li>4.- Se exigirá responsabilidad, al alumno que haga mal uso del material a disposición de la enseñanza y formación del alumnado.</li>
        <li>5.- Cualquier tipo de certificado ha de ser solicitado con antelación en las oficinas de ARIETE. En caso contrario no se garantiza su entrega puntual.</li>
        <li>6.- Los alumnos que no hayan pagado al contado deberán hacer efectivas las mensualidades en los diez primeros días de cada mes. Si el impago persiste el último día del mes podrá originar, a juicio del Centro, la baja automática del alumno.</li>
        <li>7.- ARIETE dispone de un departamento de atención al alumno. Cualquier duda, crítica o sugerencia debe hacerse a través de él.</li>
        <li>8.- La baja voluntaria del alumno será comunicada y firmada por el interesado en recepción con, al menos 10 días de antelación, siendo efectiva al mes siguiente de haberse comunicado. Sin dicho requisito el Centro seguirá emitiendo los recibos mensuales correspondientes. Si se ve imposibilitado para personarse en nuestras oficinas puede adelantarlo por teléfono. La no asistencia a clase, sin previo aviso, no exime en modo alguno del pago del recibo del mes correspondiente.</li>
        <li>9.- En caso de cancelación del curso por iniciativa de ARIETE, se le ofrecerá al alumno la posibilidad de incorporarse en un curso de nivel similar, si lo hubiera. En caso contrario, habrá de esperar al siguiente periodo en que se abra un curso del mismo nivel que el curso cancelado. En todo caso la cancelación deberá ser comunicada al alumno al menos con 10 días de antelación y ARIETE deberá devolver las cantidades abonadas por los alumnos y no consumidas.</li>
        <li>10.- ARIETE contempla, de forma general, las vacaciones de Navidad, Semana Santa y Feria, dichos días están considerados como no lectivos, no recuperables y abonables. Para los cursos de uno o dos días de clase en semana, ambas partes acuerdan la impartición durante el curso de una media de 4 semanas de clases por mes. En este caso, y si es necesario, ARIETE determinará el día y hora de las recuperaciones.</li>
        <li>11.- El contrato de matrícula se podrá resolver por cualquiera de los motivos tratados en los puntos 3, 4, 6, 8 y 9 de estas normas.</li>
        <li>12.- Las comunicaciones al alumno/a durante el curso de cualquier incidencia se hará, preferentemente, vía correo electrónico.</li>
        <li>13.- El alumno que se incorpore al curso en meses posteriores a su comienzo, deberá abonar 20 euros por cada mes vencido en concepto de material.</li>
        <li>14.- En cumplimiento de lo establecido en el Reglamento (UE) 2016/679 del Parlamento Europeo y del Consejo, le infomamos que sus datos serán objeto de tratamiento automatizado en nuestros ficheros con el fin de mantener las labores docentes y administrativas propias del centro. El alumno consiente expresamente en:
          <div class="mt-2 grid gap-2">
            <label class="check-row">
              <input type="checkbox" name="consiente_info" value="1" {{ old('consiente_info') ? 'checked' : '' }}>
              <span>Que sus datos sean utilizados para remitirle información, por cualquier medio incluido los electrónicos, sobre nuestros cursos y servicios que puedan ser de su interés.</span>
            </label>
            <label class="check-row">
              <input type="checkbox" name="consiente_historico" value="1" {{ old('consiente_historico') ? 'checked' : '' }}>
              <span>Mantener sus datos en nuestros ficheros, una vez extinguida su relación, como histórico, con la finalidad de consultar los datos en posteriores solicitudes de servicios.</span>
            </label>
            <label class="check-row">
              <input type="checkbox" name="consiente_oferta" value="1" {{ old('consiente_oferta') ? 'checked' : '' }}>
              <span>Que una vez finalizada la relación contractual sean utilizados con la finalidad de mantenerle informado de la oferta educativa y de servicios de nuestra empresa.</span>
            </label>
          </div>
          <p class="mt-2">15.- El consentimiento se entenderá prestado en tanto no comunique por escrito la revocación del mismo.</p>
      </ul>

      <div class="mt-3">
        <label class="check-row">
          <input type="checkbox" name="acepta_normas" value="1" required {{ old('acepta_normas') ? 'checked' : '' }}>
          <span><strong>He recibido y quedo enterado/a</strong> de las normas de Régimen interior a que hace referencia el punto 4º del contrato de matrícula que tengo suscrito con Academia Ariete.</span>
        </label>
        @error('acepta_normas')
          <div class="invalid-feedback mt-2">{{ $message }}</div>
        @enderror
      </div>
    </fieldset>
    {{-- ======= FIN CLÁUSULAS ======= --}}

    {{-- === DOCUMENTACIÓN: dos divs independientes, lado a lado === --}}
    <div class="file-grid">

      {{-- === CARD 1: JUSTIFICANTE (obligatorio) === --}}
      <div class="file-card">
        <div class="file-title">
          <label class="titulo @error('justificante') error @enderror">
            <strong>Justificante de pago (PDF/JPG/PNG)</strong>
          </label>
        </div>

        <input
          id="justificante"
          name="justificante"
          type="file"
          required
          accept=".pdf,image/*"
          class="file-input-hidden @error('justificante') is-invalid @enderror"
          aria-invalid="@error('justificante') true @else false @enderror"
          aria-describedby="@error('justificante') justificante_error @enderror"
        >
        <div class="file-inline">
          <label for="justificante" class="btn-file" role="button" tabindex="0">Seleccionar archivo</label>
          <span class="file-msg" id="justificante_name">Ningún archivo seleccionado</span>
        </div>

        <p class="hint"><strong>Tamaño máx. recomendado 5&nbsp;MB.</strong></p>
      </div>

      {{-- === CARD 2: ADJUNTOS OPCIONALES === --}}
      <div class="file-card">
        <div class="file-title">
          <label  class="titulo @error('adjuntos') error @enderror">
            <strong>Adjuntar documentación opcional (PDF/JPG/PNG)</strong>
          </label>
        </div>

        <input
          id="adjuntos"
          name="adjuntos"
          type="file"
          accept=".pdf,image/*"
          multiple
          class="file-input-hidden @error('adjuntos') is-invalid @enderror"
          aria-invalid="@error('adjuntos') true @else false @enderror"
          aria-describedby="@error('adjuntos') adjuntos_error @enderror"
        >
        <div class="file-inline">
          <label for="adjuntos" class="btn-file" role="button" tabindex="0">Seleccionar archivo</label>
          <span class="file-msg" id="adjuntos_name">Ningún archivo seleccionado</span>
        </div>

        <p class="hint"><strong>Puedes adjuntar varias piezas de documentación.</strong></p>

        @error('adjuntos')
          <div id="adjuntos_error" class="invalid-feedback text-xs text-red-600 mt-2" role="alert">
            {{ $message }}
          </div>
        @enderror
      </div>

    </div>
    {{-- === FIN DOCUMENTACIÓN === --}}

    {{-- ⚠️ Error del justificante DEBAJO de las tarjetas --}}
    @error('justificante')
      <div id="justificante_error"
           class="invalid-feedback text-xs text-red-600 mt-2"
           style="grid-column: 1 / -1;"
           role="alert">
        {{ $message }}
      </div>
    @enderror

    {{-- Consentimiento obligatorio antes de enviar --}}
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
        <div class="invalid-feedback d-block">{{ $message }}</div>
      @enderror
    </div>

    <div class="pt-4 text-center">
      <button type="submit" class="btn-brand w-full sm:w-auto px-5 py-2.5">
        Enviar matrícula
      </button>
    </div>

  </form>
</section>
@endsection
