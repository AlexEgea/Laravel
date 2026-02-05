@extends('layouts.app')
@section('title','Academia Ariete — Inicio')

@section('content')
<section class="space-y-12">

  {{-- =======================================================
      1) HERO — Tarjeta grande con imagen (public/img/inicio.jpg)
      ======================================================= --}}
  <div class="rounded-2xl bg-white ring-1 ring-slate-200 p-6 md:p-10 shadow-sm">
    <div class="grid lg:grid-cols-2 gap-8 items-center">
      <div class="order-2 lg:order-1">
        <h1 class="text-3xl md:text-5xl font-extrabold leading-tight text-slate-900">
          Prepárate tus <span class="text-[var(--baseariete)]">oposiciones</span> con Ariete
        </h1>
        <p class="mt-4 text-lg md:text-xl text-slate-700">
          Formación presencial y online, temarios actualizados, simulacros y preparación de pruebas físicas.
          Te acompañamos de principio a fin.
        </p>
        <div class="mt-6 flex flex-wrap gap-3">
          <a href="{{ route('matriculate') }}"
             class="btn-brand inline-flex items-center justify-center px-5 py-3 text-base font-semibold text-center">
            Matricúlate
          </a>
          {{-- Botón de promociones igual que el de Matricúlate --}}
          <a href="#promociones"
             class="btn-brand inline-flex items-center justify-center px-5 py-3 text-base font-semibold text-center">
            Promociones
          </a>
        </div>
      </div>
      <div class="order-1 lg:order-2">
        <img
          src="{{ asset('img/inicio.jpg') }}"
          alt="Alumnado preparando oposiciones en Academia Ariete"
          class="w-full h-[320px] md:h-[420px] rounded-xl object-cover ring-1 ring-slate-200"
          loading="lazy" decoding="async" fetchpriority="low">
      </div>
    </div>
  </div>

  {{-- =======================================================
      2) CARRUSEL — 4 tarjetas (Aula virtual, Clases, Contacto, RRSS)
      ======================================================= --}}
  <div class="relative">
    <div
      id="homeCarousel"
      class="overflow-hidden rounded-2xl ring-1 ring-slate-200 bg-white shadow-sm"
      role="region"
      aria-roledescription="carrusel"
      aria-label="Destacados de inicio"
      aria-live="polite"
      data-paused="false"
    >
      <div class="flex transition-transform duration-500 will-change-transform" data-carousel-track>

        {{-- Slide 1: Aula Virtual --}}
        <div class="min-w-full p-6 md:p-10" role="group" aria-roledescription="diapositiva" aria-label="1 de 4">
          <a href="https://ariete.org/campus/login/index.php"
             target="_blank"
             rel="noopener noreferrer"
             class="grid md:grid-cols-2 gap-6 items-center group focus:outline-none focus:ring-2 focus:ring-[var(--baseariete)] rounded-xl">
            <img
              src="{{ asset('img/aula-virtual.jpg') }}"
              alt="Acceso al Aula Virtual"
              class="w-full h-64 md:h-80 object-cover rounded-xl ring-1 ring-slate-200"
              loading="lazy" decoding="async">
            <div>
              <h2 class="text-2xl md:text-3xl font-bold text-slate-900 flex items-center gap-2">
                Aula Virtual
              </h2>
              <p class="mt-3 text-slate-700 text-lg">
                Accede a clases, materiales y evaluaciones desde cualquier lugar. Todo centralizado y a tu ritmo.
              </p>
            </div>
          </a>
        </div>

        {{-- Slide 2: Clases presenciales y online --}}
        <div class="min-w-full p-6 md:p-10" role="group" aria-roledescription="diapositiva" aria-label="2 de 4">
          <div class="grid md:grid-cols-2 gap-6 items-center">
            <img
              src="{{ asset('img/clases.jpg') }}"
              alt="Clases presenciales y online"
              class="w-full h-64 md:h-80 object-cover rounded-xl ring-1 ring-slate-200"
              loading="lazy" decoding="async">
            <div>
              <h2 class="text-2xl md:text-3xl font-bold text-slate-900">Clases presenciales y online</h2>
              <p class="mt-3 text-slate-700 text-lg">
                Grupos reducidos, seguimiento docente y tutorías. Elige modalidad presencial u online en directo.
              </p>
            </div>
          </div>
        </div>

        {{-- Slide 3: Contacto (con imagen contacto.jpg) --}}
        <div class="min-w-full p-6 md:p-10" role="group" aria-roledescription="diapositiva" aria-label="3 de 4">
          <a href="{{ route('contactar.index') }}" class="block focus:outline-none focus:ring-2 focus:ring-[var(--baseariete)] rounded-xl">
            <div class="grid md:grid-cols-2 gap-6 items-center">
              <img
                src="{{ asset('img/contacto.jpg') }}"
                alt="Contacto con Academia Ariete"
                class="w-full h-64 md:h-80 object-cover rounded-xl ring-1 ring-slate-200"
                loading="lazy" decoding="async">
              <div>
                <h2 class="text-2xl md:text-3xl font-bold text-slate-900">¿Tienes dudas? Hablemos</h2>
                <p class="mt-3 text-slate-700 text-lg">
                  Te orientamos sobre grupos, horarios, temarios y tasas. Respuesta rápida.
                </p>
                <span class="mt-4 inline-flex items-center gap-2 text-[var(--arietehover)] font-semibold">
                  Ir a contacto <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                </span>
              </div>
            </div>
          </a>
        </div>

        {{-- Slide 4: Redes sociales + WhatsApp --}}
        <div class="min-w-full p-6 md:p-10" role="group" aria-roledescription="diapositiva" aria-label="4 de 4">
          <div class="grid md:grid-cols-2 gap-6 items-center">
            {{-- Panel visual --}}
            <div class="rounded-xl ring-1 ring-slate-200 h-64 md:h-80 overflow-hidden relative">
              <div class="absolute inset-0 bg-gradient-to-br from-[#b91c1c]/15 via-white to-[#8f1515]/15"></div>
              <div class="absolute inset-0 grid place-items-center">
                <div class="flex gap-5">
                  <span class="h-14 w-14 rounded-2xl ring-1 ring-slate-200 grid place-items-center bg-white/80">
                    <i class="fa-brands fa-instagram text-2xl" aria-hidden="true"></i>
                  </span>
                  <span class="h-14 w-14 rounded-2xl ring-1 ring-slate-200 grid place-items-center bg-white/80">
                    <i class="fa-brands fa-facebook-f text-2xl" aria-hidden="true"></i>
                  </span>
                  <span class="h-14 w-14 rounded-2xl ring-1 ring-slate-200 grid place-items-center bg-white/80">
                    <i class="fa-brands fa-x-twitter text-2xl" aria-hidden="true"></i>
                  </span>
                  <span class="h-14 w-14 rounded-2xl ring-1 ring-slate-200 grid place-items-center bg-white/80">
                    <i class="fa-brands fa-whatsapp text-2xl" aria-hidden="true"></i>
                  </span>
                </div>
              </div>
            </div>

            {{-- Texto + CTAs --}}
            <div>
              <h2 class="text-2xl md:text-3xl font-bold text-slate-900">¡Síguenos en nuestras redes sociales!</h2>

              <div class="mt-4 grid sm:grid-cols-2 gap-3">
                <a href="https://www.instagram.com/academiaariete/" target="_blank" rel="noopener"
                   class="btn-brand inline-flex items-center justify-center gap-2 px-4 py-2 font-bold text-center"
                   aria-label="Abrir Instagram de Academia Ariete">
                  <i class="fa-brands fa-instagram" aria-hidden="true"></i> Instagram
                </a>
                <a href="https://www.facebook.com/ArieteOposiciones/" target="_blank" rel="noopener"
                   class="btn-brand inline-flex items-center justify-center gap-2 px-4 py-2 font-bold text-center"
                   aria-label="Abrir Facebook de Academia Ariete">
                  <i class="fa-brands fa-facebook-f" aria-hidden="true"></i> Facebook
                </a>
                <a href="https://x.com/ACADEMIAARIETE" target="_blank" rel="noopener"
                   class="btn-brand inline-flex items-center justify-center gap-2 px-4 py-2 font-bold text-center"
                   aria-label="Abrir X (Twitter) de Academia Ariete">
                  <i class="fa-brands fa-x-twitter" aria-hidden="true"></i> 
                </a>
                <a href="https://whatsapp.com/channel/0029VbAm8YK0LKZAuIRw2v3e" target="_blank" rel="noopener"
                   class="btn-brand inline-flex items-center justify-center gap-2 px-4 py-2 font-bold text-center"
                   aria-label="Abrir canal de WhatsApp de Academia Ariete">
                  <i class="fa-brands fa-whatsapp" aria-hidden="true"></i> WhatsApp
                </a>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>

    {{-- Controles del carrusel principal (FUERA de la tarjeta) --}}
    <div class="mt-4 flex items-center justify-between">
      {{-- Dots izquierda --}}
      <div class="flex items-center gap-2" data-carousel-dots aria-label="Selector de diapositiva" role="tablist">
        <button class="dot h-2.5 w-2.5 rounded-full bg-[var(--arietehover)]"
                aria-label="Diapositiva 1" aria-selected="true" role="tab"></button>
        <button class="dot h-2.5 w-2.5 rounded-full bg-slate-300"
                aria-label="Diapositiva 2" aria-selected="false" role="tab"></button>
        <button class="dot h-2.5 w-2.5 rounded-full bg-slate-300"
                aria-label="Diapositiva 3" aria-selected="false" role="tab"></button>
        <button class="dot h-2.5 w-2.5 rounded-full bg-slate-300"
                aria-label="Diapositiva 4" aria-selected="false" role="tab"></button>
      </div>

      {{-- Flechas derecha --}}
      <div class="flex gap-2">
        <button
          class="h-9 w-9 rounded-full grid place-items-center
                 bg-[var(--baseariete)] text-white shadow-sm hover:shadow-md hover:scale-105
                 transition"
          data-carousel-prev aria-label="Anterior">
          <i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
        </button>
        <button
          class="h-9 w-9 rounded-full grid place-items-center
                 bg-[var(--baseariete)] text-white shadow-sm hover:shadow-md hover:scale-105
                 transition"
          data-carousel-next aria-label="Siguiente">
          <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
        </button>
      </div>
    </div>
  </div>

  {{-- =======================================================
      3) PROMOCIONES — Carrusel dinámico desde BD
      ======================================================= --}}
  @php
      /** @var \Illuminate\Support\Collection|\App\Models\Promocion[] $promociones */
      $promociones = $promociones
          ?? \App\Models\Promocion::orderByDesc('created_at')->get();
  @endphp

  @if ($promociones->isNotEmpty())
    {{-- Tarjeta de promociones --}}
    <div id="promociones" class="rounded-2xl bg-white ring-1 ring-slate-200 p-6 md:p-10 shadow-sm">
      <div class="flex items-baseline justify-between gap-3 mb-5">
        <h2 class="subtitulo">
          Promociones y avisos destacados
        </h2>
        <a href="{{ route('matriculate') }}"
           class="hidden md:inline-flex items-center gap-1 text-xs text-[var(--baseariete)] hover:text-[var(--arietehover)] underline-offset-2 hover:underline">
          <i class="fa-solid fa-circle-info text-[11px]"></i>
          <span>Información de matrícula</span>
        </a>
      </div>

      <div class="relative mt-4">
        <div
          id="promosCarousel"
          class="overflow-hidden rounded-xl"
          role="region"
          aria-roledescription="carrusel"
          aria-label="Promociones y avisos"
        >
          <div class="flex transition-transform duration-500 will-change-transform" data-promos-track>
            @foreach ($promociones as $promo)
              <article class="min-w-full p-4 md:p-6">
                <div class="contact-card admin-card flex flex-col h-full">
                  <div class="flex-1 flex flex-col">
                    {{-- título de la promo en rojo Ariete --}}
                    <h3 class="text-base md:text-lg font-semibold text-[var(--baseariete)] mb-1">
                      {{ $promo->titulo }}
                    </h3>

                    <div class="title-underline mb-3"></div>

                    @if($promo->resumen)
                      <p class="text-sm text-slate-700 leading-6 mb-3">
                        {{ $promo->resumen }}
                      </p>
                    @endif

                    @if($promo->enlace_texto && $promo->enlace_url)
                      <p class="text-xs text-slate-500 mb-2 truncate" title="{{ $promo->enlace_url }}">
                        {{ $promo->enlace_texto }} → {{ $promo->enlace_url }}
                      </p>
                    @endif
                  </div>

                  @if($promo->enlace_texto && $promo->enlace_url)
                    <div class="mt-4 flex justify-center">
                      <a href="{{ $promo->enlace_url }}"
                         class="btn-brand btn-uniform inline-flex items-center justify-center gap-2 text-xs px-4 py-2"
                         @if(\Illuminate\Support\Str::startsWith($promo->enlace_url, ['http://','https://']))
                             target="_blank" rel="noopener"
                         @endif
                      >
                        <i class="fa-solid fa-arrow-right-long text-[11px]"></i>
                        <span>{{ $promo->enlace_texto }}</span>
                      </a>
                    </div>
                  @endif
                </div>
              </article>
            @endforeach
          </div>
        </div>
      </div>
    </div>

    {{-- Controles del carrusel de promociones (FUERA de la tarjeta) --}}
    <div class="mt-3 flex items-center justify-between">
      <div class="flex items-center gap-2" data-promos-dots aria-label="Selector de promoción" role="tablist">
        @foreach ($promociones as $idx => $promo)
          <button
            class="promo-dot h-2.5 w-2.5 rounded-full {{ $idx === 0 ? 'bg-[var(--arietehover)]' : 'bg-slate-300' }}"
            aria-label="Promoción {{ $idx + 1 }}"
            aria-selected="{{ $idx === 0 ? 'true' : 'false' }}"
            role="tab"
          ></button>
        @endforeach
      </div>
      <div class="flex gap-2">
        <button
          class="h-8 w-8 rounded-full grid place-items-center
                 bg-[var(--baseariete)] text-white text-xs
                 shadow-sm hover:shadow-md hover:scale-105
                 transition"
          data-promos-prev
          aria-label="Promoción anterior"
        >
          <i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
        </button>
        <button
          class="h-8 w-8 rounded-full grid place-items-center
                 bg-[var(--baseariete)] text-white text-xs
                 shadow-sm hover:shadow-md hover:scale-105
                 transition"
          data-promos-next
          aria-label="Promoción siguiente"
        >
          <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
        </button>
      </div>
    </div>
  @endif

  {{-- =======================================================
      4) SECCIONES Y OPOSICIONES SIN SECCIÓN (MISMA GRID)
      ======================================================= --}}
  @php
      use App\Models\Curso;

      // Secciones de oposiciones (ramas principales)
      $secciones = $secciones
          ?? Curso::query()
              ->where('tipo', 'seccion')
              ->whereNull('parent_id')
              ->orderBy('id', 'asc')
              ->get();

      // Oposiciones sin sección (tipo oposicion y sin parent_id)
      $oposicionesSueltas = $oposicionesSueltas
          ?? Curso::query()
              ->where('tipo', 'oposicion')
              ->whereNull('parent_id')
              ->orderBy('id', 'asc')
              ->get();

      // Colección combinada: primero secciones, luego oposiciones sueltas
      $bloquesOposiciones = $secciones->concat($oposicionesSueltas);
  @endphp

  @if ($bloquesOposiciones->isNotEmpty())
    <div class="rounded-2xl bg-white ring-1 ring-slate-200 p-6 md:p-10 shadow-sm">
      <div class="flex items-baseline justify-between gap-3 mb-5">
        <h2 class="subtitulo">
          Oposiciones
        </h2>
        <a href="{{ route('oposiciones.index') }}"
           class="hidden md:inline-flex items-center gap-1 text-xs text-[var(--baseariete)] hover:text-[var(--arietehover)] underline-offset-2 hover:underline">
          <i class="fa-solid fa-list text-[11px]"></i>
          <span>Ver todas las oposiciones</span>
        </a>
      </div>

      <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
        @foreach ($bloquesOposiciones as $bloque)
          @php
            $esSeccion   = $bloque->tipo === 'seccion';
            $titulo      = $bloque->nombre ?? $bloque->titulo ?? ($esSeccion ? 'Sección' : 'Oposición');
            $resumen     = $bloque->resumen ?? $bloque->descripcion ?? null;
            $rutaDetalle = $esSeccion
                ? route('oposiciones.seccion.show', $bloque->id)
                : route('oposiciones.show', $bloque->id);
            $textoBoton  = $esSeccion ? 'Accede a estas oposiciones' : 'Accede a estas oposiciones';
          @endphp

          <article class="contact-card admin-card flex flex-col h-full">
            <div class="flex-1 flex flex-col">
              {{-- Título en rojo Ariete --}}
              <h3 class="text-base md:text-lg font-semibold text-[var(--baseariete)] mb-1">
                {{ $titulo }}
              </h3>

              <div class="title-underline mb-3"></div>

              @if($resumen)
                <p class="text-sm text-slate-700 leading-6 mb-3">
                  {{ \Illuminate\Support\Str::limit(strip_tags($resumen), 140) }}
                </p>
              @endif
            </div>

            <div class="mt-4 flex justify-center">
              <a href="{{ $rutaDetalle }}"
                 class="btn-brand btn-uniform inline-flex items-center justify-center gap-2 text-xs px-4 py-2">
                <span>{{ $textoBoton }}</span>
              </a>
            </div>
          </article>
        @endforeach
      </div>
    </div>
  @endif

</section>
@endsection
