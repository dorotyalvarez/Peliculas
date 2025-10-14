<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Peliculas') }}</title>
<link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v={{ filemtime(public_path('favicon.ico')) }}">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-950 text-slate-200">
    <div class="min-h-screen">

        {{-- NAV / HEADER --}}
        @include('layouts.navigation')

        {{-- Header opcional (solo si una vista define $header) --}}
        @isset($header)
            <header class="bg-slate-900/70 border-b border-white/10">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        {{-- Mini info de rol (si la quieres dejar) --}}
        @auth
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-3">
            <p class="text-xs text-slate-400">Tu rol actual es:
                <span class="font-semibold text-slate-200">{{ auth()->user()->role ?? '—' }}</span>
            </p>
        </div>
        @endauth

        {{-- Page Content --}}
        <main class="min-h-[70vh]">
            @hasSection('content')
                @yield('content')   {{-- para vistas con @extends/@section --}}
            @else
                {{ $slot ?? '' }}   {{-- para componentes <x-app-layout> --}}
            @endif
            
        </main>

        {{-- Footer simple opcional --}}
        <footer class="mt-10 border-t border-white/10 py-6 text-center text-xs text-slate-500">
            {{ config('app.name', 'MoviesPremiere') }} · {{ date('Y') }}
        </footer>
        
    </div>
</body>
</html>
