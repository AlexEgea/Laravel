@extends('layouts.app')
@section('title','Admin - Usuarios')

@section('content')
<section class="matricula-page">
  <div class="container py-6 max-w-5xl mx-auto">

    {{-- Cabecera + botón crear --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4">
      <h1 class="titulo m-0">Gestión de usuarios</h1>

      <a href="{{ route('admin.users.create') }}"
         class="btn-brand inline-flex items-center justify-center gap-2 px-4 py-2 text-sm whitespace-nowrap">
        <i class="fa-solid fa-user-plus text-xs"></i>
        <span>Crear usuario</span>
      </a>
    </div>

    {{-- Mensajes de estado --}}
    @if (session('ok'))
      <div class="tarifa mb-4" role="alert" aria-live="polite">
        <span>{{ session('ok') }}</span>
      </div>
    @endif

    @if (session('error'))
      <div class="tarifa mb-4" role="alert" aria-live="polite">
        <span>{{ session('error') }}</span>
      </div>
    @endif

    {{-- Buscador --}}
    <div class="mb-4">
      <form method="GET"
            action="{{ route('admin.users.index') }}"
            class="w-full flex flex-col md:flex-row items-stretch gap-2">

        <label for="q" class="sr-only">Buscar usuarios</label>

        {{-- Input de búsqueda --}}
        <input
          type="text"
          id="q"
          name="q"
          value="{{ request('q') }}"
          placeholder="Buscar por nombre, apellidos o email…"
          class="flex-1 border-2 border-[var(--arietehover)] rounded-lg px-3 py-2 text-sm"
        >

        {{-- Botón buscar --}}
        <button
          type="submit"
          class="btn-brand px-4 py-2 text-sm flex items-center justify-center gap-2 whitespace-nowrap"
        >
          <i class="fa-solid fa-magnifying-glass text-xs"></i>
          <span>Buscar</span>
        </button>

        {{-- Botón limpiar (solo si hay término de búsqueda) --}}
        @if(request('q'))
          <a href="{{ route('admin.users.index') }}"
             class="text-xs px-3 py-2 rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-100 whitespace-nowrap flex items-center justify-center">
            Limpiar
          </a>
        @endif
      </form>
    </div>

    @if ($users->isEmpty())
      <p class="text-slate-600">
        @if(request('q'))
          No se han encontrado usuarios que coincidan con “{{ request('q') }}”.
        @else
          Todavía no hay usuarios registrados.
        @endif
      </p>
    @else
      <div class="overflow-x-auto bg-white border border-slate-200 rounded-xl shadow-sm">
        <table class="min-w-full text-sm table-fixed">
          <thead class="bg-slate-100">
            <tr>
              <th class="px-4 py-2 text-left border-b border-slate-200 text-xs font-semibold uppercase tracking-wide text-slate-500 w-2/6">
                Nombre
              </th>
              <th class="px-4 py-2 text-left border-b border-slate-200 text-xs font-semibold uppercase tracking-wide text-slate-500 w-2/6">
                Email
              </th>
              <th class="px-4 py-2 text-center border-b border-slate-200 text-xs font-semibold uppercase tracking-wide text-slate-500 whitespace-nowrap w-1/6">
                Rol
              </th>
              <th class="px-4 py-2 text-center border-b border-slate-200 text-xs font-semibold uppercase tracking-wide text-slate-500 whitespace-nowrap w-1/6">
                Registrado
              </th>
              <th class="px-4 py-2 text-center border-b border-slate-200 text-xs font-semibold uppercase tracking-wide text-slate-500 whitespace-nowrap w-[220px]">
                Acciones
              </th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100">
            @php
              $currentAdminId = auth()->id();
            @endphp

            @foreach ($users as $user)
              @php
                $rol            = $user->roles->pluck('name')->first() ?? 'sin rol';
                // En BD se guarda algo tipo: 'perfiles/archivo.jpg'
                $fotoPath       = $user->foto ?? $user->foto_perfil ?? $user->profile_photo_path;
                $nombreCompleto = trim($user->name.' '.($user->apellidos ?? ''));
              @endphp

              <tr class="hover:bg-slate-50 align-top">
                {{-- Nombre + foto --}}
                <td class="px-4 py-3 align-top">
                  <div class="flex items-center gap-3">
                    {{-- Avatar --}}
                    <div class="shrink-0">
                      @if ($fotoPath)
                        <img
                          src="{{ asset('storage/' . $fotoPath) }}"
                          alt="Foto de {{ $nombreCompleto }}"
                          class="w-10 h-10 rounded-full object-cover border border-slate-200"
                        >
                      @else
                        @php
                          $iniciales = mb_substr($user->name ?? '', 0, 1);
                          if (!empty($user->apellidos)) {
                            $iniciales .= mb_substr($user->apellidos, 0, 1);
                          }
                          $iniciales = strtoupper($iniciales ?: 'AA');
                        @endphp
                        <div class="w-10 h-10 rounded-full bg-[var(--baseariete)] text-white flex items-center justify-center text-xs font-semibold">
                          {{ $iniciales }}
                        </div>
                      @endif
                    </div>

                    {{-- Nombre + ID --}}
                    <div class="leading-tight min-w-0">
                      <div
                        class="font-semibold text-slate-900 truncate max-w-[180px]"
                        title="{{ $nombreCompleto }}"
                      >
                        {{ $nombreCompleto }}
                      </div>
                      <div class="text-[11px] text-slate-500">
                        ID #{{ $user->id }}
                      </div>
                    </div>
                  </div>
                </td>

                {{-- Email (con ...) --}}
                <td class="px-4 py-3 align-top text-xs text-slate-700">
                  <div class="truncate max-w-[220px]" title="{{ $user->email }}">
                    {{ $user->email }}
                  </div>
                </td>

                {{-- Rol --}}
                <td class="px-4 py-3 align-top text-xs text-center">
                  @if ($rol === 'admin')
                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-[11px] font-semibold bg-red-100 text-red-800">
                      Admin
                    </span>
                  @elseif ($rol === 'profesor')
                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-[11px] font-semibold bg-blue-100 text-blue-800">
                      Profesor
                    </span>
                  @elseif ($rol === 'alumno')
                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-[11px] font-semibold bg-emerald-100 text-emerald-800">
                      Alumno
                    </span>
                  @else
                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-[11px] font-semibold bg-slate-100 text-slate-600">
                      {{ $rol }}
                    </span>
                  @endif
                </td>

                {{-- Fecha de registro --}}
                <td class="px-4 py-3 align-top text-xs text-slate-600 text-center whitespace-nowrap">
                  {{ $user->created_at?->format('d/m/Y H:i') }}
                </td>

                {{-- Acciones --}}
                <td class="px-4 py-3 align-top w-[220px]">
                  <div class="flex flex-row flex-wrap md:flex-nowrap justify-end gap-2">

                    {{-- EDITAR --}}
                    @if ($user->id === 1)
                      @if ($currentAdminId === 1)
                        {{-- Solo el admin 1 puede editar al usuario 1 --}}
                        <a href="{{ route('admin.users.edit', $user) }}"
                           class="btn-brand inline-flex items-center justify-center px-3 py-1.5 text-[11px] gap-1 whitespace-nowrap">
                          <i class="fa-solid fa-pen-to-square text-xs"></i>
                          <span>Editar</span>
                        </a>
                      @else
                        {{-- Resto de admins ven solo que está bloqueado --}}
                        <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-slate-100 text-[11px] text-slate-500 cursor-not-allowed">
                          <i class="fa-solid fa-lock text-xs"></i>
                          Admin principal
                        </span>
                      @endif
                    @else
                      {{-- Cualquier admin puede editar al resto de usuarios --}}
                      <a href="{{ route('admin.users.edit', $user) }}"
                         class="btn-brand inline-flex items-center justify-center px-3 py-1.5 text-[11px] gap-1 whitespace-nowrap">
                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                        <span>Editar</span>
                      </a>
                    @endif

                    {{-- ELIMINAR (nunca para el usuario con ID 1) --}}
                    @if ($user->id !== 1)
                      <form action="{{ route('admin.users.destroy', $user) }}"
                            method="POST"
                            onsubmit="return confirm('¿Seguro que quieres eliminar este usuario?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="btn-brand inline-flex items-center justify-center px-3 py-1.5 text-[11px] gap-1 whitespace-nowrap">
                          <i class="fa-solid fa-trash-can text-xs"></i>
                          <span>Eliminar</span>
                        </button>
                      </form>
                    @endif

                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      {{-- Paginación SIEMPRE visible --}}
      <nav class="mt-4 flex flex-col md:flex-row items-center justify-between gap-3"
           role="navigation"
           aria-label="Paginación de usuarios">

        <p class="text-xs text-slate-500">
          Mostrando
          <span class="font-semibold">{{ $users->firstItem() }}</span>
          -
          <span class="font-semibold">{{ $users->lastItem() }}</span>
          de
          <span class="font-semibold">{{ $users->total() }}</span>
          usuarios
        </p>

        <div class="inline-flex items-center gap-1">

          {{-- Anterior --}}
          @if ($users->onFirstPage())
            <span class="px-3 py-1.5 text-xs rounded-lg border border-slate-200 text-slate-400 bg-slate-50 cursor-not-allowed">
              Anterior
            </span>
          @else
            <a href="{{ $users->previousPageUrl() }}"
               class="px-3 py-1.5 text-xs rounded-lg border border-[var(--baseariete)] text-[var(--baseariete)] bg-white hover:bg-[var(--baseariete)] hover:text-white transition-colors">
              Anterior
            </a>
          @endif

          {{-- Números de página --}}
          @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
            @if ($page == $users->currentPage())
              <span class="px-3 py-1.5 text-xs rounded-lg bg-[var(--baseariete)] text-white font-semibold">
                {{ $page }}
              </span>
            @else
              <a href="{{ $url }}"
                 class="px-3 py-1.5 text-xs rounded-lg border border-slate-200 text-slate-700 hover:border-[var(--baseariete)] hover:text-[var(--baseariete)] transition-colors">
                {{ $page }}
              </a>
            @endif
          @endforeach

          {{-- Siguiente --}}
          @if ($users->hasMorePages())
            <a href="{{ $users->nextPageUrl() }}"
               class="px-3 py-1.5 text-xs rounded-lg border border-[var(--baseariete)] text-[var(--baseariete)] bg-white hover:bg-[var(--baseariete)] hover:text-white transition-colors">
              Siguiente
            </a>
          @else
            <span class="px-3 py-1.5 text-xs rounded-lg border border-slate-200 text-slate-400 bg-slate-50 cursor-not-allowed">
              Siguiente
            </span>
          @endif

        </div>
      </nav>
    @endif

  </div>
</section>
@endsection
