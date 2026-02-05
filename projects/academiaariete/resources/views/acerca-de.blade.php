@extends('layouts.app')

@section('title', 'Acerca de mí')

@section('content')
<div class="min-h-[60vh] bg-slate-50 py-10">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Título principal --}}
        <div class="mb-8 text-center">
            <h1 class="titulo mb-2">Acerca de mí</h1>
        </div>

        {{-- Grid principal: tu perfil + el instituto/proyecto --}}
        <div class="grid gap-6 md:grid-cols-2">

            {{-- Columna: Sobre mí --}}
            <section class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 md:p-6 flex flex-col gap-4">
                <h2 class="text-lg font-semibold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-user text-[var(--baseariete)]"></i>
                    Sobre mí
                </h2>

                <p class="text-sm text-slate-600">
                    Hola, soy Alejandro Aguilera, un desarrollador web y estudiante de Desarrollo de Aplicaciones Web (DAW) apasionado por la 
                    tecnología y la programación. Actualmente, estoy realizando mis prácticas en Academia Ariete, donde estoy aplicando mis 
                    conocimientos y habilidades para llevar a cabo mi primer proyecto.
                </p>

                <p class="text-sm text-slate-600">
                    <a href="https://github.com/AlexEgea/AlexEgea" class="underline text-[var(--baseariete)]" target="_blank" rel="noopener noreferrer">
                        Aquí os dejo mi GitHub
                    </a>
                </p>

                <dl class="mt-2 space-y-2 text-sm">
                    <div class="flex flex-col">
                        <dt class="font-semibold text-slate-700">Nombre</dt>
                        <dd class="text-slate-600">Alejandro Aguilera</dd>
                    </div>

                    <div class="flex flex-col">
                        <dt class="font-semibold text-slate-700">Rol</dt>
                        <dd class="text-slate-600">Desarrollador web / Estudiante de DAW</dd>
                    </div>

                    <div class="flex flex-col">
                        <dt class="font-semibold text-slate-700">Contacto</dt>
                        <dd class="text-slate-600">aleagu.dev@gmail.com</dd>
                    </div>

                    <div class="flex flex-col">
                        <dt class="font-semibold text-slate-700">Tecnologías utilizadas</dt>
                        <dd class="text-slate-600">
                            Laravel, PHP, MySQL, Tailwind CSS, HTML5, CSS3, JavaScript…
                        </dd>
                    </div>
                </dl>
            </section>

            {{-- Columna: Sobre Academia Ariete / instituto --}}
            <section class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 md:p-6 flex flex-col gap-4">
                <h2 class="text-lg font-semibold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-building-columns text-[var(--baseariete)]"></i>
                    Sobre IES Trassierra
                </h2>

                <p class="text-sm text-slate-600">
                    El I.E.S. (Instituto de Enseñanza Secundaria) “Trassierra” es un centro público dependiente de la Junta de Andalucía. 
                    Fue inaugurado en septiembre de 1983 como centro de Formación Profesional. Es un centro pionero en la capital de la Reforma de las 
                    Enseñanzas Medias y en la aplicación de la L.O.G.S.E..
                </p>

                <dl class="mt-2 space-y-2 text-sm">
                    <div class="flex flex-col">
                        <dt class="font-semibold text-slate-700">Centro</dt>
                        <dd class="text-slate-600">
                            IES Trassierra, Córdoba, España. 
                        </dd>
                    </div>

                    <div class="flex flex-col">
                        <dt class="font-semibold text-slate-700">Contacto</dt>
                        <dd class="text-slate-600">
                            informacion@iestrassierra.com
                        </dd>
                    </div>

                    <div class="flex flex-col">
                        <dt class="font-semibold text-slate-700">Teléfono</dt>
                        <dd class="text-slate-600">
                            957 73 49 00 
                        </dd>
                    </div>

                    <div class="flex flex-col">
                        <dt class="font-semibold text-slate-700">Dirección</dt>
                        <dd class="text-slate-600">
                            Avda. Arroyo del Moro, s/n, 14011, Córdoba (España)
                        </dd>
                    </div>
                </dl>
            </section>
        </div>

        {{-- Bloque final de contexto --}}
        <div class="mt-8 bg-white rounded-2xl border border-slate-200 shadow-sm p-5 md:p-6">
            <h2 class="text-base md:text-lg font-semibold text-slate-800 mb-2">
                Objetivo del proyecto
            </h2>
            <p class="text-sm md:text-base text-slate-600 leading-relaxed">
                El objetivo de este proyecto es desarrollar una página web funcional, intuitiva y moderna para el sitio de prácticas en el que me encuentro,
                que es Academia Ariete. Esta página web servirá para facilitar a los administradores el trabajo, como por ejemplo la creación, edición y gestión de
                noticias, oposiciones, promociones y usuarios.
            </p>
        </div>

    </div>
</div>
@endsection
