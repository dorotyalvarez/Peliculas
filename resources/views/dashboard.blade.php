@extends('layouts.app')

@section('content')
<!-- Fuerza tema oscuro dentro del dashboard sin tocar el layout -->
<div class="min-h-screen w-full bg-slate-950 text-slate-200">

  <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 py-10">

    {{-- Hero / Bienvenida --}}
    <div class="rounded-2xl border border-white/10 bg-gradient-to-b from-slate-900 to-slate-950 p-7 sm:p-8 shadow-[0_10px_30px_-15px_rgba(0,0,0,0.6)]">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
        <div class="flex items-start gap-4">
          <div class="grid h-12 w-12 place-content-center rounded-xl bg-white/10 text-white text-lg font-semibold">
            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
          </div>
          <div>
            <h1 class="text-2xl font-bold tracking-tight">Bienvenido, {{ Auth::user()->name }}</h1>
            <p class="text-slate-400 text-sm mt-1">Panel principal · limpio, rápido y sin ruido.</p>
          </div>
        </div>
        <div class="flex flex-wrap gap-3">
          <a href="#"
             class="inline-flex items-center gap-2 rounded-xl border border-amber-300/30 bg-amber-400/10 px-4 py-2 text-amber-300 hover:bg-amber-300 hover:text-slate-900 transition">
            Ir al inicio
          </a>
          <a href="#"
             class="inline-flex items-center gap-2 rounded-xl border border-white/15 bg-white/10 px-4 py-2 text-white hover:bg-white hover:text-slate-900 transition">
            Nueva película
          </a>
        </div>
      </div>
    </div>

    {{-- Métricas (3 tarjetas) --}}
    <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-5">
      <div class="rounded-2xl border border-white/10 bg-slate-900/70 p-5 hover:border-amber-300/40 transition">
        <p class="text-slate-400 text-sm">Películas</p>
        <p class="mt-2 text-3xl font-bold">{{ $moviesCount ?? '—' }}</p>
        <a href="#" class="mt-4 inline-block text-sm text-amber-300 hover:text-amber-200">Ver listado →</a>
      </div>

      <div class="rounded-2xl border border-white/10 bg-slate-900/70 p-5 hover:border-emerald-300/40 transition">
        <p class="text-slate-400 text-sm">Series</p>
        <p class="mt-2 text-3xl font-bold">{{ $seriesCount ?? '—' }}</p>
        <a href="#" class="mt-4 inline-block text-sm text-amber-300 hover:text-amber-200">Ver listado →</a>
      </div>

      <div class="rounded-2xl border border-white/10 bg-slate-900/70 p-5 hover:border-sky-300/40 transition">
        <p class="text-slate-400 text-sm">Usuarios</p>
        <p class="mt-2 text-3xl font-bold">{{ $usersCount ?? '—' }}</p>
        <a href="#" class="mt-4 inline-block text-sm text-amber-300 hover:text-amber-200">Administrar →</a>
      </div>
    </div>

    {{-- Acciones rápidas + Actividad --}}
    <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-5">

      {{-- Acciones rápidas --}}
      <div class="lg:col-span-1 rounded-2xl border border-white/10 bg-slate-900/70 p-5">
        <h2 class="text-white font-semibold">Acciones rápidas</h2>
        <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-3">
          <a href="#" class="rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-sm hover:bg-white hover:text-slate-900 transition">Agregar película</a>
          <a href="#" class="rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-sm hover:bg-white hover:text-slate-900 transition">Agregar serie</a>
          <a href="#" class="rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-sm hover:bg-white hover:text-slate-900 transition">Categorías</a>
          <a href="#" class="rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-sm hover:bg-white hover:text-slate-900 transition">Ajustes</a>
        </div>
      </div>

      {{-- Última actividad --}}
      <div class="lg:col-span-2 rounded-2xl border border-white/10 bg-slate-900/70 p-5">
        <h2 class="text-white font-semibold">Última actividad</h2>
        <ul class="mt-4 space-y-3">
          @forelse(($recentActions ?? []) as $action)
            <li class="flex items-start gap-3">
              <span class="mt-1 h-2 w-2 rounded-full bg-amber-300"></span>
              <div>
                <p class="text-slate-200 text-sm">{{ $action['title'] ?? 'Actualización' }}</p>
                <p class="text-slate-500 text-xs">{{ $action['time'] ?? '' }}</p>
              </div>
            </li>
          @empty
            <li class="text-slate-400 text-sm">No hay actividad reciente.</li>
          @endforelse
        </ul>

        {{-- Tips compactos --}}
        <div class="mt-6 rounded-xl border border-white/10 bg-slate-950/60 p-4">
          <h3 class="text-sm font-semibold text-white/90">Consejos rápidos</h3>
          <div class="mt-3 text-sm text-slate-300 space-y-2">
            <p>• Ver rutas: <span class="rounded bg-slate-800 px-2 py-0.5 font-mono text-xs">php artisan route:list</span></p>
            <p>• Reutiliza estilos con <span class="font-mono text-xs">@apply</span> en tu CSS.</p>
            <p>• Optimiza posters para mejorar el desempeño.</p>
          </div>
        </div>
      </div>

    </div>

  </div>
</div>
@endsection
