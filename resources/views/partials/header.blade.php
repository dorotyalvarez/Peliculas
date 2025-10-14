<!-- Header -->
<header class="bg-black py-3">
    <div class="container">

        <!-- Fila móvil -->
        <div class="d-flex justify-content-between align-items-center d-md-none">
            <!-- Logo -->
            <a href="{{ route('peliculas.index') }}">
                <img src="{{ asset('img/logo/Logo Home Yellow.png') }}" alt="Logo Películas Web" width="120">
            </a>

            <!-- Login móvil -->
            <div class="d-flex align-items-center justify-content-end">
                @auth
                   <img src="{{ asset('img/logo/4086652.png') }}" class="rounded-circle me-2" alt="Usuario" width="30" height="30">
                    <span class="text-light small">{{ Auth::user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline ms-2">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-warning py-0 px-2">Salir</button>
                    </form>
                @endauth
                
                           @auth
                       <a href="{{ route('panel') }}" class="btn btn-sm btn-outline-warning ms-2">Panel</a>
                @endauth
                @guest
                    <a href="{{ route('login') }}" class="btn btn-sm btn-outline-warning py-0 px-2">Login</a>
                @endguest
            </div>

            <!-- Botón hamburguesa -->
            <button class="navbar-toggler border-0 text-warning" type="button" data-bs-toggle="collapse" data-bs-target="#menuMovil">
                ☰
            </button>
        </div>

        <!-- Menú móvil -->
        <div class="collapse text-center mt-3 d-md-none" id="menuMovil">
            <nav class="mb-3">
                <a href="{{ route('peliculas.animadas') }}" class="btn btn-outline-warning btn-sm mx-1">Animación</a>
                <a href="{{ route('peliculas.cartoon') }}" class="btn btn-outline-warning btn-sm mx-1">Cartoon</a>
                <a href="{{ route('peliculas.normal') }}" class="btn btn-outline-warning btn-sm mx-1">Normal</a>
                <a href="{{ route('peliculas.solicitar') }}" class="btn btn-outline-warning btn-sm mx-1">Solicitar Película</a>
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
            <div class="col-4">
                <nav>
                    <a href="{{ route('peliculas.animadas') }}" class="btn btn-outline-warning btn-sm mx-1">Animación</a>
                    <a href="{{ route('peliculas.cartoon') }}" class="btn btn-outline-warning btn-sm mx-1">Cartoon</a>
                    <a href="{{ route('peliculas.normal') }}" class="btn btn-outline-warning btn-sm mx-1">Normal</a>
                </nav>
            </div>

            <!-- Buscador -->
            <div class="col-4 d-flex align-items-center">
                <form action="{{ route('peliculas.index') }}" method="GET" class="d-flex flex-grow-1">
                    <input class="form-control form-control-sm me-2" type="search" name="search" placeholder="Buscar..." value="{{ request('search') }}">
                    <button class="btn btn-warning btn-sm">🔍</button>
                </form>
                <a href="{{ route('peliculas.solicitar') }}" class="btn btn-outline-warning btn-sm mx-1">Solicitar Película</a>
            </div>

            <!-- Login escritorio -->
            <div class="col-2 d-flex align-items-center justify-content-end">
                @auth
                    <img src="{{ asset('img/logo/4086652.png') }}" class="rounded-circle me-2" alt="Usuario" width="30" height="30">
                    <span class="text-light">{{ Auth::user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline ms-2">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-warning py-0 px-2">Salir</button>
                       
                    </form>
                @endauth
               @auth
  @if(auth()->user()->role === 'admin')
    <a href="{{ route('panel') }}" class="btn btn-sm btn-outline-warning ms-2">Panel Admin</a>
  @elseif(auth()->user()->role === 'verificador')
    <a href="{{ route('verificador.panel') }}" class="btn btn-sm btn-outline-warning ms-2">Verificador</a>
  @elseif(auth()->user()->role === 'publicador')
    <a href="{{ route('publicador.panel') }}" class="btn btn-sm btn-outline-warning ms-2">Publicador</a>
  @endif
@endauth


                @guest
                    <a href="{{ route('login') }}" class="btn btn-sm btn-outline-warning">Login</a>
                @endguest
            </div>
        </div>
    </div>
</header>
