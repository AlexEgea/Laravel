<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','ARIETE')</title>

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="{{ asset('img/logo_pestana.png') }}">

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- CSS -->
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">

  <!-- CDN -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body id="top" class="min-h-screen bg-slate-50 text-slate-800 flex flex-col">

  <!-- HEADER -->
  <header class="w-full bg-[var(--baseariete)] text-white">
    @php
        $user       = auth()->user();
        $isGuest    = !$user;
        $isAdmin    = $user && $user->hasRole('admin');
        $isProfesor = $user && $user->hasRole('profesor');
        $isAlumno   = $user && $user->hasRole('alumno');
        $roleName   = $user ? $user->getRoleNames()->first() : null;

        // Nombre del rol "bonito"
        if ($roleName) {
            $roleName = match ($roleName) {
                'admin'    => 'Administrador',
                'profesor' => 'Profesor',
                'alumno'   => 'Alumno',
                default    => ucfirst($roleName),
            };
        }

        // Nombre completo: name + apellidos
        $fullName = $user
            ? trim(($user->name ?? '') . ' ' . ($user->apellidos ?? ''))
            : '';

        // Foto de perfil
        if (
            $user &&
            !empty($user->foto) &&
            \Illuminate\Support\Facades\Storage::disk('public')->exists($user->foto)
        ) {
            $avatarPath = asset('storage/' . $user->foto);
        } else {
            $avatarPath = asset('img/user-default.png');
        }
    @endphp

    <nav class="w-full px-2 lg:px-6 py-3 flex items-center gap-3">
      {{-- LOGO --}}
      <a href="{{ route('inicio') }}" class="shrink-0 flex items-center gap-2 font-extrabold tracking-wide">
        <img
          src="{{ asset('img/logo_blanco.png') }}"
          alt="Academia Ariete"
          id="imglogo"
          class="h-[54px] md:h-[64px] w-auto object-contain"
          width="180" height="40"
        >
      </a>

      {{-- MENÚ ESCRITORIO --}}
      <div class="nav-desktop flex-1 justify-center">
        <ul class="flex items-center gap-1 md:gap-2">
          {{-- INICIO --}}
          <li>
            <a href="{{ route('inicio') }}"
               class="group px-2 py-2 rounded-md focus:outline-none focus-visible:ring-2 focus-visible:ring-[#8f1515]/40">
              <span
                class="rounded-md px-2 py-1 transition-colors duración-150 text-center whitespace-nowrap
                       group-hover:bg-[#8f1515] group-hover:text-white
                       {{ request()->routeIs('inicio') ? 'bg-[#8f1515] text-white' : '' }}
                       text-xs md:text-sm lg:text-base font-medium">
                Inicio
              </span>
            </a>
          </li>

          {{-- OPOSICIONES --}}
          <li>
            <a href="{{ route('oposiciones.index') }}"
               class="group px-2 py-2 rounded-md focus:outline-none focus-visible:ring-2 focus-visible:ring-[#8f1515]/40">
              <span
                class="rounded-md px-2 py-1 transición-colors duración-150 text-center whitespace-nowrap
                       group-hover:bg-[#8f1515] group-hover:text-white
                       {{ request()->routeIs('oposiciones.*') ? 'bg-[#8f1515] text-white' : '' }}
                       text-xs md:text-sm lg:text-base font-medium">
                Oposiciones
              </span>
            </a>
          </li>

          {{-- VIGILANTES --}}
          <li>
            <a href="https://vigilantesseguridad.es/" target="_blank" rel="noopener noreferrer"
               class="group px-2 py-2 rounded-md focus:outline-none focus-visible:ring-2 focus-visible:ring-[#8f1515]/40">
              <span class="rounded-md px-2 py-1 transición-colors duración-150 text-center whitespace-nowrap
                           group-hover:bg-[#8f1515] group-hover:text-white
                           text-xs md:text-sm lg:text-base font-medium">
                Vigilantes de seguridad
              </span>
            </a>
          </li>

          {{-- CONTACTAR --}}
          <li>
            <a @if(Route::has('contactar.index')) href="{{ route('contactar.index') }}" @else href="#" @endif
               class="group px-2 py-2 rounded-md focus:outline-none focus-visible:ring-2 focus-visible:ring-[#8f1515]/40">
              <span class="rounded-md px-2 py-1 transición-colors duración-150 text-center whitespace-nowrap
                           group-hover:bg-[#8f1515] group-hover:text-white
                           {{ request()->routeIs('contactar.*') || request()->routeIs('contacto*') ? 'bg-[#8f1515] text-white' : '' }}
                           text-xs md:text-sm lg:text-base font-medium">
                Contactar
              </span>
            </a>
          </li>

          {{-- ACERCA DE --}}
          <li>
            <a @if(Route::has('acerca-de')) href="{{ route('acerca-de') }}" @else href="#" @endif
               class="group px-2 py-2 rounded-md focus:outline-none focus-visible:ring-2 focus-visible:ring-[#8f1515]/40">
              <span class="rounded-md px-2 py-1 transición-colors duración-150 text-center whitespace-nowrap
                           group-hover:bg-[#8f1515] group-hover:text-white
                           {{ request()->routeIs('acerca-de') ? 'bg-[#8f1515] text-white' : '' }}
                           text-xs md:text-sm lg:text-base font-medium">
                Acerca de
              </span>
            </a>
          </li>

          {{-- MATRICÚLATE --}}
          @if ($isGuest || $isAlumno || $isAdmin)
            <li>
              <a @if(Route::has('matriculate')) href="{{ route('matriculate') }}" @else href="#" @endif
                 class="group px-2 py-2 rounded-md focus:outline-none focus-visible:ring-2 focus-visible:ring-[#8f1515]/40">
                <span class="rounded-md px-2 py-1 transición-colors duración-150 text-center whitespace-nowrap
                             group-hover:bg-[#8f1515] group-hover:text-white
                             {{ request()->routeIs('matriculate') ? 'bg-[#8f1515] text-white' : '' }}
                             text-xs md:text-sm lg:text-base font-medium">
                  Matricúlate
                </span>
              </a>
            </li>
          @endif

          {{-- AULA VIRTUAL --}}
          @if ($isAlumno || $isProfesor || $isAdmin)
            <li>
              <a href="https://ariete.org/campus/login/index.php"
                 target="_blank"
                 rel="noopener noreferrer"
                 class="group px-2 py-2 rounded-md focus:outline-none focus-visible:ring-2 focus-visible:ring-[#8f1515]/40">
                <span class="rounded-md px-2 py-1 transición-colors duración-150 text-center whitespace-nowrap
                             group-hover:bg-[#8f1515] group-hover:text-white
                             text-xs md:text-sm lg:text-base font-medium">
                  Aula Virtual
                </span>
              </a>
            </li>
          @endif

          {{-- NOTICIAS --}}
          <li>
            <a @if(Route::has('noticias.index')) href="{{ route('noticias.index') }}" @else href="#" @endif
               class="group px-2 py-2 rounded-md focus:outline-none focus-visible:ring-2 focus-visible:ring-[#8f1515]/40">
              <span class="rounded-md px-2 py-1 transición-colors duración-150 text-center whitespace-nowrap
                           group-hover:bg-[#8f1515] group-hover:text-white
                           {{ request()->routeIs('noticias.*') ? 'bg-[#8f1515] text-white' : '' }}
                           text-xs md:text-sm lg:text-base font-medium">
                Noticias
              </span>
            </a>
          </li>

          {{-- PANEL ADMIN --}}
          @auth
            @if ($isAdmin && Route::has('admin.panel'))
              <li>
                <a href="{{ route('admin.panel') }}"
                   class="group px-2 py-2 rounded-md focus:outline-none focus-visible:ring-2 focus-visible:ring-[#8f1515]/40">
                  <span class="rounded-md px-2 py-1 transición-colors duración-150 text-center whitespace-nowrap
                               group-hover:bg-[#8f1515] group-hover:text-white
                               {{ request()->routeIs('admin.*') ? 'bg-[#8f1515] text-white' : '' }}
                               text-xs md:text-sm lg:text-base font-medium">
                    Panel admin
                  </span>
                </a>
              </li>
            @endif
          @endauth
        </ul>
      </div>

      {{-- BLOQUE DERECHO ESCRITORIO: LOGIN / PERFIL --}}
      <div class="nav-desktop shrink-0 items-center">
        @guest
          <div class="flex items-center gap-3">
            @if (Route::has('login'))
              <a href="{{ route('login') }}"
                 class="group px-2 py-2 rounded-md focus:outline-none focus-visible:ring-2 focus-visible:ring-[#8f1515]/40">
                <span class="rounded-md px-2 py-1 transición-colors duración-150 text-center whitespace-nowrap
                             group-hover:bg-[#8f1515] group-hover:text-white
                             {{ request()->routeIs('login') ? 'bg-[#8f1515] text-white' : '' }}
                             text-xs md:text-sm lg:text-base font-medium">
                  Iniciar sesión
                </span>
              </a>
            @endif

            @if (Route::has('register'))
              <a href="{{ route('register') }}"
                 class="group px-2 py-2 rounded-md focus:outline-none focus-visible:ring-2 focus-visible:ring-[#8f1515]/40">
                <span class="rounded-md px-2 py-1 transición-colors duración-150 text-center whitespace-nowrap
                             group-hover:bg-[#8f1515] group-hover:text-white
                             {{ request()->routeIs('register') ? 'bg-[#8f1515] text-white' : '' }}
                             text-xs md:text-sm lg:text-base font-medium">
                  Registrarse
                </span>
              </a>
            @endif
          </div>
        @endguest

        @auth
          <div class="relative group ml-2">
            <a href="{{ route('perfil.edit') }}"
               class="block px-2 py-2 rounded-md focus:outline-none focus-visible:ring-2 focus-visible:ring-[#8f1515]/40">
              <span class="rounded-md px-2 py-1 transición-colors duración-150 flex items-center gap-2 whitespace-nowrap
                           group-hover:bg-[#8f1515] group-hover:text-white text-xs md:text-sm lg:text-base font-medium">
                <img
                  src="{{ $avatarPath }}"
                  alt="Foto de perfil"
                  class="rounded-full h-8 w-8 object-cover border border-white/40"
                >
                {{-- NOMBRE + ROL EN DOS LÍNEAS --}}
                <span class="flex flex-col leading-tight">
                  <span class="font-semibold truncate max-w-[140px] md:max-w-[180px]">
                    {{ $fullName }}
                  </span>
                  @if($roleName)
                    <span class="text-[0.65rem] md:text-xs text-white/80 uppercase tracking-wide">
                      {{ $roleName }}
                    </span>
                  @endif
                </span>
              </span>
            </a>

            <div
              class="absolute right-0 top-full w-full bg-[#b91c1c] text-white rounded-md shadow-lg ring-1 ring-black/30
                     opacity-0 invisible group-hover:opacity-100 group-hover:visible
                     transición-opacity duración-150 z-50 overflow-hidden"
            >
              <a href="{{ route('perfil.edit') }}"
                 class="block px-3 py-2 text-sm hover:bg-[#8f1515] transición-colors">
                Perfil
              </a>

              <div class="border-t border-white/20"></div>

              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full text-left block px-3 py-2 text-sm hover:bg-[#8f1515] transición-colors">
                  Cerrar sesión
                </button>
              </form>
            </div>
          </div>
        @endauth
      </div>

      {{-- BOTÓN MENÚ MÓVIL (HAMBURGUESA) --}}
      <button type="button"
          class="nav-toggle-mobile md:hidden ml-auto inline-flex items-center justify-center rounded-md border border-white/40 px-2.5 py-2
                 text-sm font-medium bg-white/0 hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white"
          aria-label="Abrir menú"
          aria-expanded="false"
          data-menu-toggle>
          <span class="sr-only">Abrir menú</span>
          <i class="fa-solid fa-bars text-lg"></i>
      </button>
    </nav>

    {{-- PANEL DESPLEGABLE MÓVIL (DERECHA) --}}
    <div
      class="md:hidden fixed inset-y-0 right-0 z-40 w-72 max-w-full bg-white shadow-xl border-l border-slate-200
             transform translate-x-full transición-transform duración-200 ease-out"
      data-menu-panel
      aria-hidden="true">

      <div class="h-full flex flex-col">
        <div class="px-4 py-3 flex items-center justify-between bg-[var(--baseariete)] text-white">
          <span class="font-semibold tracking-wide text-sm uppercase">Menú</span>
          <button type="button"
              class="inline-flex items-center justify-center rounded-md border border-white/40 px-2 py-1.5 text-sm
                     bg-white/0 hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white"
              aria-label="Cerrar menú"
              data-menu-close>
              <i class="fa-solid fa-xmark text-lg"></i>
          </button>
        </div>

        <nav class="px-4 py-4 flex-1 overflow-y-auto">
          <ul class="space-y-1 text-sm">
            <li>
              <a href="{{ route('inicio') }}"
                 class="block rounded-md px-3 py-2 font-semibold text-slate-800 hover:bg-slate-100">
                Inicio
              </a>
            </li>
            <li>
              <a href="{{ route('oposiciones.index') }}"
                 class="block rounded-md px-3 py-2 font-semibold text-slate-800 hover:bg-slate-100">
                Oposiciones
              </a>
            </li>
            <li>
              <a href="https://vigilantesseguridad.es/" target="_blank" rel="noopener noreferrer"
                 class="block rounded-md px-3 py-2 font-semibold text-slate-800 hover:bg-slate-100">
                Vigilantes de seguridad
              </a>
            </li>
            <li>
              <a @if(Route::has('contactar.index')) href="{{ route('contactar.index') }}" @else href="#" @endif
                 class="block rounded-md px-3 py-2 font-semibold text-slate-800 hover:bg-slate-100">
                Contactar
              </a>
            </li>
            <li>
              <a @if(Route::has('acerca-de')) href="{{ route('acerca-de') }}" @else href="#" @endif
                 class="block rounded-md px-3 py-2 font-semibold text-slate-800 hover:bg-slate-100">
                Acerca de
              </a>
            </li>

            @if ($isGuest || $isAlumno || $isAdmin)
              <li>
                <a @if(Route::has('matriculate')) href="{{ route('matriculate') }}" @else href="#" @endif
                   class="block rounded-md px-3 py-2 font-semibold text-slate-800 hover:bg-slate-100">
                  Matricúlate
                </a>
              </li>
            @endif

            @if ($isAlumno || $isProfesor || $isAdmin)
              <li>
                <a href="https://ariete.org/campus/login/index.php"
                   target="_blank" rel="noopener noreferrer"
                   class="block rounded-md px-3 py-2 font-semibold text-slate-800 hover:bg-slate-100">
                  Aula Virtual
                </a>
              </li>
            @endif

            <li>
              <a @if(Route::has('noticias.index')) href="{{ route('noticias.index') }}" @else href="#" @endif
                 class="block rounded-md px-3 py-2 font-semibold text-slate-800 hover:bg-slate-100">
                Noticias
              </a>
            </li>

            @auth
              @if ($isAdmin && Route::has('admin.panel'))
                <li>
                  <a href="{{ route('admin.panel') }}"
                     class="block rounded-md px-3 py-2 font-semibold text-slate-800 hover:bg-slate-100">
                    Panel admin
                  </a>
                </li>
              @endif
            @endauth
          </ul>
        </nav>

        <div class="px-4 pb-4 border-t border-slate-200 space-y-2">
          @guest
            @if (Route::has('login'))
              <a href="{{ route('login') }}"
                 class="block w-full text-center rounded-lg px-3 py-2 text-sm font-semibold
                        text-[var(--baseariete)] bg-slate-100 hover:bg-slate-200">
                Iniciar sesión
              </a>
            @endif

            @if (Route::has('register'))
              <a href="{{ route('register') }}"
                 class="block w-full text-center rounded-lg px-3 py-2 text-sm font-semibold text-white
                        bg-[var(--arietehover)] hover:bg-[#6d0b0b]">
                Registrarse
              </a>
            @endif
          @endguest

          @auth
            <a href="{{ route('perfil.edit') }}"
               class="block w-full text-center rounded-lg px-3 py-2 text-sm font-semibold text-slate-800 bg-slate-100 hover:bg-slate-200">
              Perfil
            </a>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit"
                  class="block w-full text-center rounded-lg px-3 py-2 text-sm font-semibold text-white
                         bg-[var(--arietehover)] hover:bg-[#6d0b0b]">
                Cerrar sesión
              </button>
            </form>
          @endauth
        </div>
      </div>
    </div>

    {{-- FONDO OSCURO DETRÁS DEL PANEL --}}
    <div
      class="md:hidden fixed inset-0 z-30 bg-black/40 opacity-0 pointer-events-none transición-opacity duración-200"
      data-menu-backdrop>
    </div>
  </header>

  <!-- MAIN -->
  <main class="mx-auto max-w-6xl px-4 py-8 w-full flex-1">
    @yield('content')
  </main>

  <!-- FOOTER -->
  <footer class="text-white w-full" role="contentinfo">
    <!-- Zona superior -->
    <div class="bg-[#b91c1c]">
      <div class="mx-auto max-w-6xl px-4 py-10 grid gap-8 md:grid-cols-4">
        <!-- Logo y texto -->
        <div>
          <a href="{{ route('inicio') }}" class="inline-flex items-center gap-3">
            <img src="{{ asset('img/logo_blanco.png') }}" alt="Academia Ariete" class="h-10 w-auto">
            <span class="sr-only">Academia Ariete</span>
          </a>
          <p class="mt-4 text-sm/6 text-white/80">
            Preparación para oposiciones y certificaciones. Formación presencial y online.
          </p>
        </div>

        <!-- LEGAL -->
        <nav aria-label="Legal">
          <h2 class="footer-title">Legal</h2>
          <ul class="footer-links">
            <li>
              @if(Route::has('politica-de-privacidad'))
                <a href="{{ route('politica-de-privacidad') }}">Política de Privacidad</a>
              @else
                <a href="/politica-de-privacidad">Política de Privacidad</a>
              @endif
            </li>
            <li>
              @if(Route::has('aviso-legal'))
                <a href="{{ route('aviso-legal') }}">Aviso Legal</a>
              @else
                <a href="/aviso-legal">Aviso Legal</a>
              @endif
            </li>
            <li>
              @if(Route::has('politica-cookies'))
                <a href="{{ route('politica-cookies') }}">Política de Cookies</a>
              @else
                <a href="/politica-cookies">Política de Cookies</a>
              @endif
            </li>
          </ul>
        </nav>

        <!-- CONTACTO -->
        <div>
          <h2 class="footer-title">Contacto</h2>
          <ul class="footer-links text-sm">
            <li>
              <span class="text-white/60">Teléfono:</span>
              <a class="footer-link" href="tel:+34695576194"> 695 57 61 94</a>
            </li>
            <li>
              <span class="text-white/60">Correo:</span>
              <a class="footer-link" href="mailto:info@ariete.org"> info@ariete.org</a>
            </li>
            <li>
              <span class="text-white/60">Dirección:</span>
              <a
                class="footer-link"
                href="https://www.google.com/maps/search/?api=1&query=Plaza+de+Col%C3%B3n%2C+23%2C+14001+C%C3%B3rdoba"
                target="_blank" rel="noopener noreferrer">
                Plaza de Colón, nº 23 · 14001 Córdoba
              </a>
            </li>
          </ul>
        </div>

        <!-- ENLACES -->
        <div>
          <h2 class="footer-title">Enlaces</h2>
          <ul class="footer-links mb-4">
            <li>
              @if(Route::has('noticias.index'))
                <a href="{{ route('noticias.index') }}">Noticias</a>
              @else
                <a href="#">Noticias</a>
              @endif
            </li>
            <li>
              @if(Route::has('matriculate'))
                <a href="{{ route('matriculate') }}">Matricúlate</a>
              @else
                <a href="#">Matricúlate</a>
              @endif
            </li>
            <li>
              @if(Route::has('acerca-de'))
                <a href="{{ route('acerca-de') }}">Acerca de</a>
              @else
                <a href="#">Acerca de</a>
              @endif
            </li>
            <li>
              <a href="https://vigilantesseguridad.es/" target="_blank" rel="noopener noreferrer">Vigilantes de Seguridad</a>
            </li>
          </ul>

          <div class="flex gap-2 footer-social" aria-label="Redes sociales">
            <!-- Instagram -->
            <a href="https://www.instagram.com/academiaariete/" target="_blank" rel="noopener noreferrer" aria-label="Instagram"
               class="inline-flex h-8 w-8 items-center justify-center rounded-full ring-1 ring-white/30 text-white hover:bg-[var(--arietehover)] transición duración-150">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                   stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <rect width="20" height="20" x="2" y="2" rx="5" ry="5"/>
                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
                <line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/>
              </svg>
            </a>
            <!-- Facebook -->
            <a href="https://www.facebook.com/ArieteOposiciones/" target="_blank" rel="noopener noreferrer" aria-label="Facebook"
               class="inline-flex h-8 w-8 items-center justify-center rounded-full ring-1 ring-white/30 text-white hover:bg-[var(--arietehover)] transición duración-150">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                   stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>
              </svg>
            </a>
            <!-- X -->
            <a href="https://x.com/ACADEMIAARIETE" target="_blank" rel="noopener noreferrer" aria-label="X (Twitter)"
               class="inline-flex h-8 w-8 items-center justify-center rounded-full ring-1 ring-white/30 text-white hover:bg-[var(--arietehover)] transición duración-150">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                   stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"/>
              </svg>
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- Franja inferior -->
    <div class="bg-[#a61b1b] border-t border-white/10">
      <div class="mx-auto max-w-6xl px-4 py-4">
        {{-- En móvil: 1 columna; en escritorio: 3 columnas --}}
        <div class="grid grid-cols-1 md:grid-cols-3 items-center gap-3">
          <div class="justify-self-start">
            <p class="text-white/80 text-xs md:text-sm md:whitespace-nowrap">
              © 2025 Academia Ariete. Todos los derechos reservados.
            </p>
          </div>
          <div class="justify-self-center">
            <p class="text-white/80 text-xs md:text-sm text-center">
              Alejandro Aguilera · IES Trassierra
            </p>
          </div>
          <div class="justify-self-end">
            <a href="#top" aria-label="Volver arriba"
               class="inline-flex items-center justify-center h-7 w-7 rounded-full ring-1 ring-white/20 hover:bg-white/10 transición text-white">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                   viewBox="0 0 24 24" fill="none" stroke="currentColor"
                   stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M9 13a1 1 0 0 0-1-1H5.061a1 1 0 0 1-.75-1.811l6.836-6.835a1.207 1.207 0 0 1 1.707 0l6.835 6.835a1 1 0 0 1-.75 1.811H16a1 1 0 0 0-1 1v6a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1z"/>
              </svg>
            </a>
          </div>
        </div>
      </div>
    </div>

  </footer>

  <!-- JS -->
  <script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
