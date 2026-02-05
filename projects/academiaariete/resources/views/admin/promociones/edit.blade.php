@extends('layouts.app')

@section('title', 'Editar promoción · Ariete')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center">
    <div class="w-full max-w-3xl bg-white border border-slate-200 rounded-2xl shadow-xl px-6 py-6 md:px-8 md:py-8">
        <h1 class="titulo mb-2">Editar promoción</h1>
        <p class="text-sm text-slate-600 mb-4">
            Modifica el contenido y el estado de esta promoción.
        </p>

        @if ($errors->any())
            <div class="mb-4 rounded-lg border border-[rgba(185,28,28,0.4)] bg-[rgba(185,28,28,0.04)] px-3 py-2 text-sm text-[var(--baseariete)]">
                <ul class="list-disc ms-4 mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST"
              action="{{ route('admin.promociones.update', $promocion) }}"
              class="space-y-5">
            @csrf
            @method('PUT')

            {{-- Título --}}
            <div class="grid gap-1">
                <label for="titulo" class="titulo @error('titulo') error @enderror">
                    Título *
                </label>
                <input
                    id="titulo"
                    type="text"
                    name="titulo"
                    value="{{ old('titulo', $promocion->titulo) }}"
                    required
                    class="border-2 border-[var(--arietehover)] rounded-lg px-3 py-2 text-sm @error('titulo') is-invalid @enderror"
                    aria-invalid="@error('titulo') true @else false @enderror"
                    aria-describedby="@error('titulo') titulo_error @enderror"
                >
                @error('titulo')
                    <p id="titulo_error" class="invalid-feedback">{{ $message }}</p>
                @enderror
            </div>

            {{-- Resumen --}}
            <div class="grid gap-1">
                <label for="resumen" class="titulo @error('resumen') error @enderror">
                    Texto / resumen
                </label>
                <textarea
                    id="resumen"
                    name="resumen"
                    rows="4"
                    class="border-2 border-[var(--arietehover)] rounded-lg px-3 py-2 text-sm @error('resumen') is-invalid @enderror"
                    placeholder="Texto que aparecerá en la tarjeta de la promoción…"
                    aria-invalid="@error('resumen') true @else false @enderror"
                    aria-describedby="@error('resumen') resumen_error @enderror"
                >{{ old('resumen', $promocion->resumen) }}</textarea>
                <p class="text-[11px] text-slate-500">
                    Máx. 1000 caracteres. Usa un texto claro y directo.
                </p>
                @error('resumen')
                    <p id="resumen_error" class="invalid-feedback">{{ $message }}</p>
                @enderror
            </div>

            {{-- Enlace --}}
            <div class="grid md:grid-cols-2 gap-4">
                <div class="grid gap-1">
                    <label for="enlace_texto" class="titulo @error('enlace_texto') error @enderror">
                        Texto del botón (opcional)
                    </label>
                    <input
                        id="enlace_texto"
                        type="text"
                        name="enlace_texto"
                        value="{{ old('enlace_texto', $promocion->enlace_texto) }}"
                        class="border-2 border-[var(--arietehover)] rounded-lg px-3 py-2 text-sm @error('enlace_texto') is-invalid @enderror"
                        placeholder="Ej: Ver más, Matricúlate…"
                        aria-invalid="@error('enlace_texto') true @else false @enderror"
                        aria-describedby="@error('enlace_texto') enlace_texto_error @enderror"
                    >
                    @error('enlace_texto')
                        <p id="enlace_texto_error" class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid gap-1">
                    <label for="enlace_url" class="titulo @error('enlace_url') error @enderror">
                        URL del botón (opcional)
                    </label>
                    <input
                        id="enlace_url"
                        type="text"
                        name="enlace_url"
                        value="{{ old('enlace_url', $promocion->enlace_url) }}"
                        class="border-2 border-[var(--arietehover)] rounded-lg px-3 py-2 text-sm @error('enlace_url') is-invalid @enderror"
                        placeholder="/matriculate, /oposiciones o https://…"
                        aria-invalid="@error('enlace_url') true @else false @enderror"
                        aria-describedby="@error('enlace_url') enlace_url_error @enderror"
                    >
                    <p class="text-[11px] text-slate-500">
                        Si es un enlace externo, incluye <strong>http://</strong> o <strong>https://</strong>.
                    </p>
                    @error('enlace_url')
                        <p id="enlace_url_error" class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Orden + Activa --}}
            <div class="grid md:grid-cols-[1fr,auto] gap-4 items-center">
                <div class="grid gap-1">
                    <label for="orden" class="titulo @error('orden') error @enderror">
                        Orden
                    </label>
                    <input
                        id="orden"
                        type="number"
                        name="orden"
                        min="0"
                        value="{{ old('orden', $promocion->orden) }}"
                        class="border-2 border-[var(--arietehover)] rounded-lg px-3 py-2 text-sm @error('orden') is-invalid @enderror"
                        aria-invalid="@error('orden') true @else false @enderror"
                        aria-describedby="@error('orden') orden_error @enderror"
                    >
                    @error('orden')
                        <p id="orden_error" class="invalid-feedback">{{ $message }}</p>
                    @enderror
                    <p class="text-[11px] text-slate-500">
                        Se mostrarán en la portada ordenadas por este número (de menor a mayor).
                    </p>
                </div>

                <div class="flex items-center gap-2 mt-2 md:mt-6">
                    <input
                        id="activo"
                        type="checkbox"
                        name="activo"
                        value="1"
                        {{ old('activo', $promocion->activo) ? 'checked' : '' }}
                        class="h-4 w-4 rounded border-slate-300"
                    >
                    <label for="activo" class="text-sm text-slate-700">
                        Promoción activa
                    </label>
                </div>
            </div>

            <div class="pt-4 flex justify-center gap-3">
                <a href="{{ route('admin.promociones.index') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-slate-300 bg-white text-sm text-slate-700 hover:bg-slate-100 hover:border-slate-400 transition">
                    <i class="fa-solid fa-arrow-left-long text-xs"></i>
                    <span>Cancelar</span>
                </a>

                <button type="submit"
                        class="btn-brand inline-flex items-center justify-center gap-2">
                    <i class="fa-solid fa-floppy-disk text-xs"></i>
                    <span>Guardar cambios</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
