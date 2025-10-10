<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MoviesPremiere')</title>

    <!-- Favicon -->
<link rel="icon" type="image/png" href="{{ asset('img/logo/favicon.png') }}">
<link rel="icon" type="image/x-icon" href="{{ asset('img/logo/favicon.ico') }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Tu CSS personalizado -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    {{-- Header global --}}
    @include('partials.header')

    <main>
        {{-- Aquí se cargará el contenido de cada página --}}
        @yield('content')
    </main>

    {{-- Footer global --}}
    @include('partials.footer')

    <script src="{{ asset('js/app.js') }}"></script><!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>