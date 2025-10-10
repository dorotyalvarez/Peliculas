@extends('layouts.app')

@section('content')
<div class="container py-5 text-center">
    <h1 class="text-warning fw-bold">🎬 Bienvenido al panel</h1>
    <p class="text-light mt-3">Has iniciado sesión correctamente, {{ Auth::user()->name }}.</p>
    <a href="{{ route('peliculas.index') }}" class="btn btn-outline-warning mt-4">
        Ir al inicio
    </a>
</div>
@endsection