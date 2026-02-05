{{-- resources/views/perfil/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Mi perfil · Ariete')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center">
    <div class="w-full max-w-5xl bg-white border border-slate-200 rounded-2xl shadow-xl px-6 py-6 md:px-10 md:py-8">
        <div class="grid gap-8 md:grid-cols-[260px,1fr]">
            @php
                $roleName = method_exists($user, 'getRoleNames') ? $user->getRoleNames()->first() : null;
                $esAdmin  = method_exists($user, 'hasRole') && $user->hasRole('admin');
            @endphp

            {{-- Columna izquierda: info general + avatar --}}
            <div class="space-y-6 border-b md:border-b-0 md:border-r border-slate-200 pb-6 md:pb-0 md:pr-8">
                <div>
                    <h1 class="titulo mb-2">Mi perfil</h1>
                    <p class="text-sm text-slate-600">
                        Gestiona tu información personal y tu acceso al Aula Virtual.
                    </p>
                </div>

                {{-- Avatar + info rápida --}}
                <div class="flex flex-col items-center text-center gap-3">
                    <div class="relative">
                        <div class="h-28 w-28 rounded-full overflow-hidden border-2 border-[var(--baseariete)] shadow-md bg-slate-100 flex items-center justify-center">
                            @php
                                $avatarUrl = null;
                                if (!empty($user->foto)) {
                                    // user->foto = "perfiles/xxxx.jpg"
                                    $avatarUrl = asset('storage/' . $user->foto);
                                }
                            @endphp

                            @if ($avatarUrl)
                                <img src="{{ $avatarUrl }}" alt="Foto de perfil" class="h-full w-full object-cover">
                            @else
                                <span class="text-3xl font-semibold text-[var(--baseariete)]">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="space-y-1">
                        <p class="font-semibold text-slate-800">{{ $user->name }}</p>

                        {{-- ID SOLO PARA ADMIN --}}
                        @if ($esAdmin)
                            <p class="text-xs text-slate-500">ID usuario: {{ $user->id }}</p>
                        @endif

                        @if($roleName)
                            <p class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-rose-50 text-[11px] font-semibold text-[var(--baseariete)] uppercase tracking-wide">
                                <i class="fa-solid fa-user-shield text-[12px]"></i>
                                {{ $roleName }}
                            </p>
                        @endif
                    </div>

                    <p class="text-xs text-slate-500 max-w-xs">
                        Sube una imagen cuadrada (recomendado 400×400 px) para que se vea mejor en el Aula Virtual.
                    </p>
                </div>
            </div>

            {{-- Columna derecha: formulario --}}
            <div>
                {{-- Mensaje de éxito --}}
                @if (session('status'))
                    <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-3 py-2 text-sm text-emerald-700">
                        {{ session('status') }}
                    </div>
                @endif

                {{-- Errores --}}
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
                      action="{{ route('perfil.update') }}"
                      class="space-y-5"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- ID solo lectura (SOLO PARA ADMIN) --}}
                    @if ($esAdmin)
                        <div class="grid gap-1">
                            <label class="titulo" for="user_id">ID de usuario</label>
                            <input
                                id="user_id"
                                type="text"
                                value="{{ $user->id }}"
                                readonly
                                class="border border-slate-200 rounded-lg bg-slate-50 px-3 py-2 text-sm text-slate-600 cursor-not-allowed"
                            >
                        </div>
                    @endif

                    {{-- Nombre + Apellidos --}}
                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="grid gap-1">
                            <label for="name" class="titulo">Nombre</label>
                            <input
                                id="name"
                                type="text"
                                name="name"
                                value="{{ old('name', $user->name) }}"
                                required
                                class="border-2 border-[var(--arietehover)] rounded-lg px-3 py-2 text-sm @error('name') is-invalid @enderror"
                            >
                            @error('name')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid gap-1">
                            <label for="apellidos" class="titulo">Apellidos</label>
                            <input
                                id="apellidos"
                                type="text"
                                name="apellidos"
                                value="{{ old('apellidos', $user->apellidos ?? '') }}"
                                class="border-2 border-[var(--arietehover)] rounded-lg px-3 py-2 text-sm @error('apellidos') is-invalid @enderror"
                            >
                            @error('apellidos')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Email + Teléfono --}}
                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="grid gap-1">
                            <label for="email" class="titulo">Correo electrónico</label>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email', $user->email) }}"
                                required
                                class="border-2 border-[var(--arietehover)] rounded-lg px-3 py-2 text-sm @error('email') is-invalid @enderror"
                            >
                            @error('email')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid gap-1">
                            <label for="telefono" class="titulo">Teléfono</label>
                            <input
                                id="telefono"
                                type="text"
                                name="telefono"
                                value="{{ old('telefono', $user->telefono ?? '') }}"
                                class="border-2 border-[var(--arietehover)] rounded-lg px-3 py-2 text-sm @error('telefono') is-invalid @enderror"
                            >
                            @error('telefono')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Dirección --}}
                    <div class="grid gap-1">
                        <label for="direccion" class="titulo">Dirección</label>
                        <input
                            id="direccion"
                            type="text"
                            name="direccion"
                            value="{{ old('direccion', $user->direccion ?? '') }}"
                            class="border-2 border-[var(--arietehover)] rounded-lg px-3 py-2 text-sm @error('direccion') is-invalid @enderror"
                        >
                        @error('direccion')
                            <p class="invalid-feedback">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Rol (solo lectura desde Spatie) --}}
                    <div class="grid gap-1">
                        <label class="titulo">Rol</label>
                        <input
                            type="text"
                            value="{{ $roleName ?? 'Sin rol asignado' }}"
                            readonly
                            class="border border-slate-200 rounded-lg bg-slate-50 px-3 py-2 text-sm text-slate-600 cursor-not-allowed"
                        >
                    </div>

                    {{-- Contraseña --}}
                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="grid gap-1">
                            <label for="password" class="titulo">Nueva contraseña</label>
                            <input
                                id="password"
                                type="password"
                                name="password"
                                class="border-2 border-[var(--arietehover)] rounded-lg px-3 py-2 text-sm @error('password') is-invalid @enderror"
                                placeholder="Déjala en blanco para mantener la actual"
                            >
                            @error('password')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="grid gap-1">
                            <label for="password_confirmation" class="titulo">Confirmar contraseña</label>
                            <input
                                id="password_confirmation"
                                type="password"
                                name="password_confirmation"
                                class="border-2 border-[var(--arietehover)] rounded-lg px-3 py-2 text-sm"
                                placeholder="Repítela solo si la cambias"
                            >
                        </div>
                    </div>

                    {{-- Foto --}}
                    <div class="grid gap-1">
                        <label for="foto" class="titulo">Foto de perfil</label>
                        <input
                            id="foto"
                            type="file"
                            name="foto"
                            accept="image/*"
                            class="block w-full text-sm text-slate-600
                                   file:mr-4 file:py-2 file:px-4
                                   file:rounded-md file:border-0
                                   file:text-sm file:font-semibold
                                   file:bg-[var(--baseariete)] file:text-white
                                   hover:file:bg-[var(--arietehover)]"
                        >
                        @error('foto')
                            <p class="invalid-feedback">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-4 flex justify-end">
                        <button type="submit" class="btn-brand inline-flex justify-center">
                            Guardar cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
