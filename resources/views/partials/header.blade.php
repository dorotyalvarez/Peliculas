<!-- Header -->
<header class="bg-black py-3">
    <div class="container">

        <!-- Fila móvil -->
        <div class="d-flex justify-content-between align-items-center d-md-none">
            <!-- Logo -->
            <a href="{{ route('peliculas.index') }}">
                <img src="{{ asset('img/logo/Logo Home Yellow.png') }}" alt="Logo Películas Web" width="120">
            </a>

            <!-- Login -->
            <div class="d-flex align-items-center justify-content-end">
                <img src="https://via.placeholder.com/28" class="rounded-circle me-2" alt="User">
                <span class="text-light small">Usuario</span>
            </div>

            <!-- Botón hamburguesa -->
            <button class="navbar-toggler border-0 text-warning" type="button" data-bs-toggle="collapse" data-bs-target="#menuMovil">
                ☰ <!-- Puedes cambiar esto por <span class="navbar-toggler-icon"></span> si quieres el icono de Bootstrap -->
            </button>
        </div>

        <!-- Menú desplegable móvil -->
        <div class="collapse text-center mt-3 d-md-none" id="menuMovil">
            <nav class="mb-3">
                <a href="{{ route('peliculas.animadas') }}" class="btn btn-outline-warning btn-sm mx-1">Animación</a>
                <a href="{{ route('peliculas.cartoon') }}" class="btn btn-outline-warning btn-sm mx-1">Cartoon</a>
                <a href="{{ route('peliculas.normal') }}" class="btn btn-outline-warning btn-sm mx-1">Normal</a>
                <a href="#" class="text-light mx-2">Terror</a>
            </nav>
            <form action="{{ route('peliculas.index') }}" method="GET" class="d-flex justify-content-center">
                <input class="form-control form-control-sm me-2 w-75" type="search" name="search" placeholder="Buscar..." value="{{ request('search') }}">
                <button class="btn btn-warning btn-sm">🔍</button>
            </form>
        </div>

        <!-- Layout escritorio -->
        <div class="row align-items-center d-none d-md-flex mt-2">
            <!-- Logo -->
            <div class="col-2">
                <a href="{{ route('peliculas.index') }}">
                    <img src="{{ asset('img/logo/Logo Home Yellow.png') }}" alt="Logo Películas Web" width="120">
                </a>
            </div>

            <!-- Categorías -->
            <div class="col-5">
                <nav>
                    <a href="{{ route('peliculas.animadas') }}" class="btn btn-outline-warning btn-sm mx-1">Animación</a>
                    <a href="{{ route('peliculas.cartoon') }}" class="btn btn-outline-warning btn-sm mx-1">Cartoon</a>
                    <a href="{{ route('peliculas.normal') }}" class="btn btn-outline-warning btn-sm mx-1">Normal</a>
                    <a href="#" class="text-light mx-2">Terror</a>
                </nav>
            </div>

            <!-- Buscador -->
            <div class="col-3">
                <form action="{{ route('peliculas.index') }}" method="GET" class="d-flex">
                    <input class="form-control form-control-sm me-2" type="search" name="search" placeholder="Buscar..." value="{{ request('search') }}">
                    <button class="btn btn-warning btn-sm">🔍</button>
                </form>
            </div>

            <!-- Login -->
            <div class="col-2 d-flex align-items-center justify-content-end">
                <img src="https://via.placeholder.com/30" class="rounded-circle me-2" alt="User">
                <span class="text-light">Usuario</span>
            </div>
        </div>

    </div>
</header>
