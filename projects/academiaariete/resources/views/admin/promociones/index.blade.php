@extends('layouts.app')
@section('title','Admin - Promociones')

@section('content')
<section class="matricula-page">
  <div class="container py-6 max-w-5xl mx-auto">

    {{-- Cabecera + botón crear --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4">
      <h1 class="titulo m-0">Gestión de promociones</h1>

      <a href="{{ route('admin.promociones.create') }}"
         class="btn-brand inline-flex items-center justify-center gap-2 px-4 py-2 text-sm whitespace-nowrap">
        <i class="fa-solid fa-bullhorn text-xs"></i>
        <span>Crear promoción</span>
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

    @if ($promociones->total() === 0)
      <p class="text-slate-600">
        Todavía no hay promociones creadas.
      </p>
    @else
      <div class="overflow-x-auto bg-white border border-slate-200 rounded-xl shadow-sm">
        <table class="min-w-full text-sm table-fixed">
          <thead class="bg-slate-100">
            <tr>
              <th class="px-4 py-2 text-left border-b border-slate-200 text-xs font-semibold uppercase tracking-wide text-slate-500 w-2/6">
                Título
              </th>
              <th class="px-4 py-2 text-left border-b border-slate-200 text-xs font-semibold uppercase tracking-wide text-slate-500 w-2/6">
                Resumen
              </th>
              <th class="px-4 py-2 text-center border-b border-slate-200 text-xs font-semibold uppercase tracking-wide text-slate-500 whitespace-nowrap w-1/12">
                Activa
              </th>
              <th class="px-4 py-2 text-center border-b border-slate-200 text-xs font-semibold uppercase tracking-wide text-slate-500 whitespace-nowrap w-1/12">
                Orden
              </th>
              <th class="px-4 py-2 text-center border-b border-slate-200 text-xs font-semibold uppercase tracking-wide text-slate-500 whitespace-nowrap w-[220px]">
                Acciones
              </th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100">
            @foreach ($promociones as $promocion)
              <tr class="hover:bg-slate-50 align-middle">
                {{-- Título --}}
                <td class="px-4 py-3 align-middle">
                  <div class="font-semibold text-slate-900 truncate max-w-[220px]"
                       title="{{ $promocion->titulo }}">
                    {{ $promocion->titulo }}
                  </div>
                  @if($promocion->enlace_texto && $promocion->enlace_url)
                    <div class="text-[11px] text-slate-500 truncate max-w-[220px]"
                         title="{{ $promocion->enlace_url }}">
                      {{ $promocion->enlace_texto }} → {{ $promocion->enlace_url }}
                    </div>
                  @endif
                </td>

                {{-- Resumen --}}
                <td class="px-4 py-3 align-middle text-xs text-slate-700">
                  <div class="truncate max-w-[260px]" title="{{ $promocion->resumen ?? '' }}">
                    {{ $promocion->resumen }}
                  </div>
                </td>

                {{-- Activa --}}
                <td class="px-4 py-3 align-middle text-xs text-center">
                  @if ($promocion->activo)
                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-[11px] font-semibold bg-emerald-100 text-emerald-800">
                      Sí
                    </span>
                  @else
                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-[11px] font-semibold bg-slate-100 text-slate-600">
                      No
                    </span>
                  @endif
                </td>

                {{-- Orden --}}
                <td class="px-4 py-3 align-middle text-xs text-center">
                  {{ $promocion->orden }}
                </td>

                {{-- Acciones --}}
                <td class="px-4 py-3 w-[220px] text-center align-middle">
                  <div class="flex flex-row flex-wrap md:flex-nowrap items-center justify-center gap-2">

                    {{-- EDITAR --}}
                    <a href="{{ route('admin.promociones.edit', $promocion) }}"
                       class="btn-brand inline-flex items-center justify-center px-3 py-1.5 text-[11px] gap-1 whitespace-nowrap">
                      <i class="fa-solid fa-pen-to-square text-xs"></i>
                      <span>Editar</span>
                    </a>

                    {{-- ELIMINAR --}}
                    <form action="{{ route('admin.promociones.destroy', $promocion) }}"
                          method="POST"
                          onsubmit="return confirm('¿Seguro que quieres eliminar esta promoción?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit"
                              class="btn-brand inline-flex items-center justify-center px-3 py-1.5 text-[11px] gap-1 whitespace-nowrap">
                        <i class="fa-solid fa-trash-can text-xs"></i>
                        <span>Eliminar</span>
                      </button>
                    </form>

                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      {{-- Paginación --}}
      <nav class="mt-4 flex flex-col md:flex-row items-center justify-between gap-3"
           role="navigation"
           aria-label="Paginación de promociones">

        <p class="text-xs text-slate-500">
          Mostrando
          <span class="font-semibold">{{ $promociones->firstItem() }}</span>
          -
          <span class="font-semibold">{{ $promociones->lastItem() }}</span>
          de
          <span class="font-semibold">{{ $promociones->total() }}</span>
          promociones
        </p>

        <div class="inline-flex items-center gap-1">
          {{ $promociones->links() }}
        </div>
      </nav>
    @endif

  </div>
</section>
@endsection
