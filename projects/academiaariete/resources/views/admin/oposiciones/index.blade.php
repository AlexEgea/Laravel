@extends('layouts.app')
@section('title','Admin - Gestión de oposiciones')

@section('content')
<section class="matricula-page py-8 bg-slate-50">
  <div class="max-w-6xl mx-auto px-4">

    {{-- Título principal --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4">
      <div>
        <h1 class="titulo mb-1">Gestión de oposiciones</h1>
      </div>
    </div>

    {{-- Mensaje de estado --}}
    @if (session('status'))
      <div
        class="tarifa mt-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 shadow-sm"
        role="status"
        aria-live="polite"
      >
        <span>{{ session('status') }}</span>
      </div>
    @endif

    {{-- Normalización de colecciones para evitar errores si vienen nulas --}}
    @php
      /** @var \Illuminate\Support\Collection|null $secciones */
      /** @var \Illuminate\Support\Collection|null $oposiciones */
      /** @var \Illuminate\Support\Collection|null $subseccionesPorPadre */

      $secciones            = $secciones ?? collect();
      $oposiciones          = $oposiciones ?? collect();
      $subseccionesPorPadre = $subseccionesPorPadre ?? collect();
    @endphp

    {{-- Tarjetas grandes de acción (modo "panel") --}}
    <div class="cards mt-6 grid gap-4 md:grid-cols-2">
      {{-- Crear sección --}}
      <div class="contact-card admin-card h-full flex flex-col justify-between">
        <div>
          <div class="head flex items-center gap-2 mb-1">
            <span class="contact-icon" aria-hidden="true">
              <i class="fa-solid fa-folder-tree" style="color:#850e0e"></i>
            </span>
            <h2 class="text-lg m-0">Crear nueva sección</h2>
          </div>
          <div class="title-underline mb-3"></div>
          <p class="text-sm text-slate-700 leading-7">
            Una <strong>sección</strong> es una familia de oposiciones:
            por ejemplo <em>Fuerzas y Cuerpos de Seguridad</em>,
            <em>Junta de Andalucía</em>, <em>Estado</em>, etc.
          </p>
          <ul class="mt-2 text-sm text-slate-700 leading-6">
            <li>• Solo tiene <strong>nombre</strong>.</li>
            <li>• Agrupa varias oposiciones hijas.</li>
            <li>• En la parte pública muestra sus oposiciones en formato tarjetas.</li>
          </ul>
        </div>
        <div class="card-actions mt-4 flex flex-col gap-2 pt-3 border-t border-slate-100">
          <a href="{{ route('admin.oposiciones.secciones.create') }}"
             class="btn-brand btn-uniform w-full inline-flex justify-center">
            Crear sección
          </a>
        </div>
      </div>

      {{-- Crear oposición --}}
      <div class="contact-card admin-card h-full flex flex-col justify-between">
        <div>
          <div class="head flex items-center gap-2 mb-1">
            <span class="contact-icon" aria-hidden="true">
              <i class="fa-solid fa-file-pen" style="color:#850e0e"></i>
            </span>
            <h2 class="text-lg m-0">Crear nueva oposición</h2>
          </div>
          <div class="title-underline mb-3"></div>
          <p class="text-sm text-slate-700 leading-7">
            Una <strong>oposición</strong> es una ficha concreta:
            <em>Policía Local</em>, <em>Auxiliar Administrativo Junta</em>, etc.
          </p>
          <ul class="mt-2 text-sm text-slate-700 leading-6">
            <li>• Tiene título, resumen y descripción con formato.</li>
            <li>• Se puede asignar a una sección o dejar sin sección.</li>
            <li>• Se puede publicar o dejar en borrador.</li>
          </ul>
        </div>
        <div class="card-actions mt-4 flex flex-col gap-2 pt-3 border-t border-slate-100">
          <a href="{{ route('admin.oposiciones.create') }}"
             class="btn-brand btn-uniform w-full inline-flex justify-center">
            Crear oposición
          </a>
        </div>
      </div>
    </div>

    {{-- Listado de secciones + subsecciones + oposiciones hijas --}}
    <div class="mt-10">
      <h2 class="subtitulo mb-3">Secciones de oposiciones</h2>

      @if($secciones->isEmpty())
        <p class="text-sm text-slate-600">
          Todavía no hay secciones creadas. Empieza creando una sección con el botón
          <strong>“Crear sección”</strong>.
        </p>
      @else
        <div class="cards grid gap-4 md:grid-cols-2 lg:grid-cols-3">
          @foreach($secciones as $seccion)
            @php
              $hijas        = $oposiciones->get($seccion->id) ?? collect();
              $subsecciones = $subseccionesPorPadre->get($seccion->id) ?? collect();
            @endphp

            <article class="contact-card admin-card flex flex-col h-full">
              <div class="flex-1 flex flex-col">
                <div class="head flex items-start justify-between gap-2">
                  <div>
                    <h3 class="text-base md:text-lg m-0">{{ $seccion->titulo }}</h3>
                    <p class="text-xs text-slate-500 mt-1">
                      {{ $hijas->count() }} oposición{{ $hijas->count() === 1 ? '' : 'es' }} en esta sección
                      @if($subsecciones->isNotEmpty())
                        • {{ $subsecciones->count() }} subsección{{ $subsecciones->count() === 1 ? '' : 'es' }}
                      @endif
                    </p>
                  </div>
                  <span class="inline-flex items-center gap-1 rounded-full bg-red-50 px-2 py-1 text-[11px] font-semibold text-red-800 whitespace-nowrap">
                    <i class="fa-solid fa-folder" aria-hidden="true"></i>
                    Sección
                  </span>
                </div>

                <div class="title-underline my-3"></div>

                {{-- Subsecciones (otras secciones hijas) con sus oposiciones --}}
                @if($subsecciones->isNotEmpty())
                  <p class="text-xs font-semibold text-slate-600 mb-1">
                    Subsecciones:
                  </p>
                  <ul class="mt-1 mb-3 space-y-2 text-xs text-slate-700">
                    @foreach($subsecciones as $sub)
                      @php
                        $subOpos = $oposiciones->get($sub->id) ?? collect();
                      @endphp
                      <li class="space-y-1">
                        <div class="flex items-center justify-between gap-2">
                          <span class="truncate">
                            <i class="fa-solid fa-folder-tree text-[10px] text-red-700 mr-1" aria-hidden="true"></i>
                            {{ $sub->titulo }}
                            @if($subOpos->isNotEmpty())
                              <span class="ml-1 text-[10px] text-slate-500">
                                ({{ $subOpos->count() }} opo{{ $subOpos->count() === 1 ? 'sición' : 'siciones' }})
                              </span>
                            @endif
                          </span>
                          <a href="{{ route('admin.oposiciones.edit', $sub) }}"
                             class="inline-flex items-center justify-center rounded-full border border-slate-200 bg-white px-2 py-0.5 text-[10px] text-slate-600 hover:bg-slate-50"
                             title="Editar sección">
                            <i class="fa-solid fa-pen" aria-hidden="true"></i>
                          </a>
                        </div>

                        {{-- Oposiciones dentro de la subsección --}}
                        @if($subOpos->isNotEmpty())
                          <ul class="pl-4 space-y-1">
                            @foreach($subOpos as $subOpo)
                              <li class="flex items-center justify-between gap-2">
                                <span class="truncate">
                                  {{ $subOpo->titulo }}
                                </span>
                                <div class="flex flex-nowrap items-center gap-1">
                                  @if($subOpo->activo)
                                    <span class="inline-flex items-center whitespace-nowrap rounded-full bg-emerald-50 px-2 py-0.5 text-[10px] font-semibold text-emerald-700">
                                      Publicada
                                    </span>
                                  @else
                                    <span class="inline-flex items-center whitespace-nowrap rounded-full bg-slate-100 px-2 py-0.5 text-[10px] font-semibold text-slate-600">
                                      Borrador
                                    </span>
                                  @endif

                                  <a href="{{ route('admin.oposiciones.edit', $subOpo) }}"
                                     class="inline-flex items-center justify-center rounded-full border border-slate-200 bg-white px-2 py-0.5 text-[10px] text-slate-600 hover:bg-slate-50"
                                     title="Editar oposición">
                                    <i class="fa-solid fa-pen" aria-hidden="true"></i>
                                  </a>
                                </div>
                              </li>
                            @endforeach
                          </ul>
                        @else
                          <p class="pl-4 text-[11px] text-slate-500 italic">
                            Sin oposiciones asignadas todavía.
                          </p>
                        @endif
                      </li>
                    @endforeach
                  </ul>
                @endif

                {{-- Lista de oposiciones hijas directas de la sección raíz --}}
                @if($hijas->isEmpty())
                  <p class="text-sm text-slate-500 italic">
                    No hay oposiciones asignadas a esta sección todavía.
                  </p>
                @else
                  <ul class="mt-1 space-y-1 text-sm text-slate-700">
                    @foreach($hijas as $opo)
                      <li class="flex items-center justify-between gap-2">
                        <span class="truncate">
                          {{ $opo->titulo }}
                        </span>
                        <div class="flex flex-nowrap items-center gap-1">
                          @if($opo->activo)
                            <span class="inline-flex items-center whitespace-nowrap rounded-full bg-emerald-50 px-2 py-0.5 text-[10px] font-semibold text-emerald-700">
                              Publicada
                            </span>
                          @else
                            <span class="inline-flex items-center whitespace-nowrap rounded-full bg-slate-100 px-2 py-0.5 text-[10px] font-semibold text-slate-600">
                              Borrador
                            </span>
                          @endif

                          {{-- Botón editar oposición hija --}}
                          <a href="{{ route('admin.oposiciones.edit', $opo) }}"
                             class="inline-flex items-center justify-center rounded-full border border-slate-200 bg-white px-2 py-0.5 text-[10px] text-slate-600 hover:bg-slate-50"
                             title="Editar oposición">
                            <i class="fa-solid fa-pen" aria-hidden="true"></i>
                          </a>
                        </div>
                      </li>
                    @endforeach
                  </ul>
                @endif
              </div>

              {{-- Acciones sección: acceder / editar / eliminar --}}
              <div class="card-actions mt-4 flex flex-col gap-2 pt-3 border-t border-slate-100">
                {{-- Acceder a la sección (vista pública) --}}
                <a href="{{ route('oposiciones.seccion.show', $seccion) }}"
                   target="_blank" rel="noopener"
                   class="btn-brand btn-uniform w-full inline-flex items-center justify-center gap-2 text-xs px-3 py-2">
                  <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i>
                  Acceder a la sección
                </a>

                {{-- Editar sección --}}
                <a href="{{ route('admin.oposiciones.edit', $seccion) }}"
                   class="btn-brand btn-uniform w-full text-xs px-3 py-2 text-center">
                  Editar
                </a>

                {{-- Eliminar sección --}}
                <form action="{{ route('admin.oposiciones.destroy', $seccion) }}"
                      method="POST"
                      class="w-full"
                      onsubmit="return confirm('Si borras esta sección, sus oposiciones pasarán a estar sin sección. ¿Continuar?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit"
                          class="btn-brand btn-uniform w-full bg-red-700 hover:bg-red-800 text-xs px-3 py-2">
                    Eliminar
                  </button>
                </form>
              </div>
            </article>
          @endforeach
        </div>
      @endif
    </div>

    {{-- Oposiciones sin sección --}}
    <div class="mt-10">
      <h2 class="subtitulo mb-3">Oposiciones sin sección</h2>

      @php
        $sinSeccion = $oposiciones->get(null) ?? collect();
      @endphp

      @if($sinSeccion->isEmpty())
        <p class="text-sm text-slate-600">
          No hay oposiciones sin sección. Si borras una sección, sus oposiciones
          pasarán a aparecer aquí.
        </p>
      @else
        <div class="cards grid gap-4 md:grid-cols-2 lg:grid-cols-3">
          @foreach($sinSeccion as $opo)
            <article class="contact-card admin-card flex flex-col h-full">
              <div class="flex-1 flex flex-col">
                <div class="head flex items-start justify-between gap-2">
                  <h3 class="text-base md:text-lg m-0">{{ $opo->titulo }}</h3>
                  <span class="inline-flex items-center rounded-full bg-slate-50 px-2 py-0.5 text-[11px] font-semibold text-slate-700 whitespace-nowrap">
                    Sin sección
                  </span>
                </div>

                <div class="title-underline my-3"></div>

                {{-- Estado --}}
                <div class="mt-1">
                  @if($opo->activo)
                    <span class="inline-flex items-center whitespace-nowrap rounded-full bg-emerald-50 px-2 py-0.5 text-[10px] font-semibold text-emerald-700">
                      Publicada
                    </span>
                  @else
                    <span class="inline-flex items-center whitespace-nowrap rounded-full bg-slate-100 px-2 py-0.5 text-[10px] font-semibold text-slate-600">
                      Borrador
                    </span>
                  @endif
                </div>

                @if($opo->resumen)
                  <p class="text-sm text-slate-700 line-clamp-3 mt-2">
                    {{ $opo->resumen }}
                  </p>
                @endif
              </div>

              {{-- Acciones: acceder / editar / eliminar --}}
              <div class="card-actions mt-4 flex flex-col gap-2 pt-3 border-t border-slate-100">
                {{-- Acceder a la oposición (vista pública) --}}
                <a href="{{ route('oposiciones.show', $opo) }}"
                   target="_blank" rel="noopener"
                   class="btn-brand btn-uniform w-full inline-flex items-center justify-center gap-2 text-xs px-4 py-2">
                  <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i>
                  Acceder a la oposición
                </a>

                {{-- Editar --}}
                <a href="{{ route('admin.oposiciones.edit', $opo) }}"
                   class="btn-brand btn-uniform w-full text-xs px-3 py-2 text-center">
                  Editar
                </a>

                {{-- Eliminar --}}
                <form action="{{ route('admin.oposiciones.destroy', $opo) }}"
                      method="POST"
                      class="w-full"
                      onsubmit="return confirm('¿Seguro que quieres borrar esta oposición?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit"
                          class="btn-brand btn-uniform w-full bg-red-700 hover:bg-red-800 text-xs px-3 py-2">
                    Eliminar
                  </button>
                </form>
              </div>
            </article>
          @endforeach
        </div>
      @endif
    </div>

  </div>
</section>
@endsection
