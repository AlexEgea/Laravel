@extends('layouts.app')

@section('title', 'Panel de administración')

@section('content')
<section class="panel-page">
  {{-- TÍTULO PRINCIPAL --}}
  <h1 class="titulo">Panel de administración</h1>

  {{-- TARJETA: USUARIO ACTUAL --}}
  <div class="cards mt-6">
    <div class="contact-card user-card">
      <div class="head">
        <span class="contact-icon" aria-hidden="true">
          {{-- Icono usuario --}}
          <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
               viewBox="0 0 24 24" fill="none" stroke="#850e0e"
               stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 12a4 4 0 1 0-4-4 4 4 0 0 0 4 4Z"/>
            <path d="M6 20a6 6 0 0 1 12 0"/>
          </svg>
        </span>
        <h3 class="text-lg">Resumen de tu cuenta</h3>
      </div>
      <div class="title-underline"></div>

      <p class="text-slate-700 leading-7">
        Bienvenido/a,
        <strong>{{ Auth::user()->name }}</strong><br>
        <span class="text-sm text-slate-500">{{ Auth::user()->email }}</span>
      </p>

      <p class="mt-3 text-xs font-semibold text-slate-500 uppercase tracking-wide">
        Rol(es) asignado(s)
      </p>
      <p class="mt-1 text-sm">
        @forelse (Auth::user()->getRoleNames() as $role)
          <span class="inline-block px-2 py-1 rounded-full bg-red-50 text-[11px] font-semibold text-red-800 mr-1 mb-1">
            {{ $role }}
          </span>
        @empty
          <span class="text-slate-400 italic">Sin rol asignado</span>
        @endforelse
      </p>
    </div>
  </div>

  {{-- ÁREAS DE ADMINISTRACIÓN --}}
  <h2 class="subtitulo">Áreas de administración</h2>

  <div class="cards mt-6 space-y-6">
    {{-- FILA 1: Usuarios + Oposiciones --}}
    <div class="grid gap-6 md:grid-cols-2">
      {{-- Gestión de usuarios --}}
      <div class="contact-card admin-card">
        <div class="head">
          <span class="contact-icon" aria-hidden="true">
            {{-- Icono usuarios --}}
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                 viewBox="0 0 24 24" fill="none" stroke="#850e0e"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
              <circle cx="9" cy="7" r="3"/>
              <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
              <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
          </span>
          <h3 class="text-lg">Gestión de usuarios</h3>
        </div>
        <div class="title-underline"></div>

        <p class="text-sm text-slate-700 leading-7 mt-2">
          Administra los usuarios registrados: revisa sus datos, asigna roles y gestiona
          el restablecimiento de contraseñas.
        </p>

        <ul class="mt-3 text-sm text-slate-700 leading-6">
          <li>• Ver listado de usuarios.</li>
          <li>• Asignar y cambiar roles (Spatie).</li>
          <li>• Forzar reseteo/restablecimiento de contraseña.</li>
        </ul>

        <div class="card-actions mt-4 flex justify-center">
          <a href="{{ route('admin.users.index') }}"
             class="btn-brand btn-uniform">
            Gestionar usuarios
          </a>
        </div>
      </div>

      {{-- Gestión de oposiciones --}}
      <div class="contact-card admin-card">
        <div class="head">
          <span class="contact-icon" aria-hidden="true">
            {{-- Icono libro --}}
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                 viewBox="0 0 24 24" fill="none" stroke="#850e0e"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
              <path d="M4 4.5A2.5 2.5 0 0 1 6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5z"/>
            </svg>
          </span>
          <h3 class="text-lg">Gestión de oposiciones</h3>
        </div>
        <div class="title-underline"></div>

        <p class="text-sm text-slate-700 leading-7 mt-2">
          Crea y organiza secciones, subsecciones y oposiciones que se mostrarán
          en la parte pública de la web.
        </p>

        <ul class="mt-3 text-sm text-slate-700 leading-6">
          <li>• Crear secciones principales y subsecciones.</li>
          <li>• Crear oposiciones y asignarlas a su sección.</li>
          <li>• Ver dentro de cada sección sus subsecciones y oposiciones.</li>
          <li>• Cambiar el estado de cada oposición (publicada / borrador).</li>
        </ul>

        <div class="card-actions mt-4 flex justify-center">
          <a href="{{ route('admin.oposiciones.index') }}"
             class="btn-brand btn-uniform">
            Gestionar oposiciones
          </a>
        </div>
      </div>
    </div>

    {{-- FILA 2: Promociones + Noticias --}}
    <div class="grid gap-6 md:grid-cols-2">
      {{-- Gestión de promociones --}}
      <div class="contact-card admin-card">
        <div class="head">
          <span class="contact-icon" aria-hidden="true">
            {{-- Icono megáfono / promociones --}}
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                 viewBox="0 0 24 24" fill="none" stroke="#850e0e"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M3 11v2a4 4 0 0 0 4 4h1"/>
              <path d="M12 6v12"/>
              <path d="M18 8a3 3 0 0 1 0 8"/>
              <path d="M12 6 5 9H3v6h2l7 3"/>
            </svg>
          </span>
          <h3 class="text-lg">Gestión de promociones</h3>
        </div>
        <div class="title-underline"></div>

        <p class="text-sm text-slate-700 leading-7 mt-2">
          Configura las promociones y avisos destacados que aparecerán en la página de inicio:
          matrículas, descuentos, cambios de horario, etc.
        </p>

        <ul class="mt-3 text-sm text-slate-700 leading-6">
          <li>• Crear nuevas promociones.</li>
          <li>• Editar texto y enlaces.</li>
          <li>• Activar / desactivar promociones visibles.</li>
        </ul>

        <div class="card-actions mt-4 flex justify-center">
          <a href="{{ route('admin.promociones.index') }}"
             class="btn-brand btn-uniform">
            Gestionar promociones
          </a>
        </div>
      </div>

      {{-- Gestión de noticias --}}
      <div class="contact-card admin-card">
        <div class="head">
          <span class="contact-icon" aria-hidden="true">
            {{-- Icono noticias --}}
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                 viewBox="0 0 24 24" fill="none" stroke="#850e0e"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M4 19h16"/>
              <path d="M5 4h14a1 1 0 0 1 1 1v14H4a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1z"/>
              <path d="M8 8h8"/>
              <path d="M8 12h5"/>
            </svg>
          </span>
          <h3 class="text-lg">Gestión de noticias</h3>
        </div>
        <div class="title-underline"></div>

        <p class="text-sm text-slate-700 leading-7 mt-2">
          Publica y actualiza las noticias de la Academia Ariete que se mostrarán
          en la parte pública de la web.
        </p>

        <ul class="mt-3 text-sm text-slate-700 leading-6">
          <li>• Crear nuevas noticias.</li>
          <li>• Editar noticias existentes.</li>
          <li>• Publicar / despublicar noticias.</li>
        </ul>

        <div class="card-actions mt-4 flex justify-center">
          <a href="{{ route('admin.noticias.index') }}"
             class="btn-brand btn-uniform">
            Gestionar noticias
          </a>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
