<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dark Souls Compendium - @yield('title', 'Ashen One\'s Guide')</title>
    
    {{-- Agregué el CSRF token y la CDN de Font Awesome para los iconos --}}
    <meta name="csrf-token" content="{{ csrf_token() }}"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
    /* Paleta de Colores y Tipografía (Simulación de Dark Souls UI) */
    :root {
        --ds-bg-dark: #121212;
        /* Fondo muy oscuro */
        --ds-text-light: #CCCCCC;
        /* Texto claro ligeramente envejecido */
        --ds-border-grey: #4c4c4c;
        /* Borde de menú / separador */
        --ds-highlight-gold: #b8860b;
        /* Dorado para destacar (como botones/links) */
        --ds-font-gothic: 'Times New Roman', serif;
        /* Simula fuente gótica/serifa */
        --ds-font-small: 0.85rem;
    }

    /* Estilos Globales del Cuerpo */
    body {
        background-color: var(--ds-bg-dark);
        color: var(--ds-text-light);
        font-family: var(--ds-font-gothic);
        line-height: 1.6;
    }

    /* Contenedores y Estructura */
    .ds-container {
        background-color: #1a1a1a;
        /* Un tono más claro para el contenido */
        border: 2px solid var(--ds-border-grey);
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.7);
        padding: 20px;
        margin-top: 30px;
        margin-bottom: 30px;
        min-height: 90vh; /* Asegura un mínimo de altura */
    }

    /* Encabezado */
    .ds-header {
        border-bottom: 3px solid var(--ds-highlight-gold);
        padding-bottom: 15px;
        margin-bottom: 25px;
        text-align: center;
    }

    .ds-header h1 {
        color: var(--ds-text-light);
        font-size: 2.5rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.8);
    }
    
    /* Titulo del Usuario (Sidebar/Menú) */
    .ds-user-title {
        color: var(--ds-highlight-gold);
        font-weight: bold;
        text-transform: capitalize;
        font-size: 1rem;
        padding: 8px 15px;
    }

    /* Navegación (Simula menú de ítems) */
    .ds-nav-link {
        color: var(--ds-text-light) !important;
        text-transform: uppercase;
        font-size: var(--ds-font-small);
        padding: 8px 15px;
        margin: 0 5px;
        border: 1px solid transparent;
        transition: all 0.2s;
        text-decoration: none; /* Asegura que no haya subrayado por defecto */
    }

    .ds-nav-link:hover,
    .ds-nav-link.active {
        color: var(--ds-highlight-gold) !important;
        border-color: var(--ds-highlight-gold);
        background-color: rgba(184, 134, 11, 0.1);
    }
    
    /* Botón de Logout */
    .ds-logout-btn {
        color: #f44336 !important; /* Rojo sutil para cerrar sesión */
        text-transform: uppercase;
        font-size: var(--ds-font-small);
        padding: 8px 15px;
        margin: 0 5px;
        border: 1px solid transparent;
        transition: all 0.2s;
        background: none;
        cursor: pointer;
    }
    
    .ds-logout-btn:hover {
        border-color: #f44336;
        background-color: rgba(244, 67, 54, 0.1);
    }


    /* Tablas */
    .ds-table {
        --bs-table-bg: #242424;
        /* Fondo de tabla oscuro */
        --bs-table-color: var(--ds-text-light);
        --bs-table-border-color: var(--ds-border-grey);
        font-size: var(--ds-font-small);
    }

    .ds-table th {
        color: var(--ds-highlight-gold);
        text-transform: uppercase;
        border-bottom-width: 2px;
        border-top-width: 0;
    }

    .ds-table tbody tr:hover {
        background-color: #333333;
        /* Resaltado al pasar el ratón */
        cursor: pointer;
    }

    /* Botones (Como si fueran elementos de la UI) */
    .ds-btn {
        background-color: var(--ds-highlight-gold);
        color: var(--ds-bg-dark);
        border: none;
        text-transform: uppercase;
        font-weight: bold;
        font-size: var(--ds-font-small);
        transition: background-color 0.2s;
    }

    .ds-btn:hover {
        background-color: #daa520;
        /* Tono más claro de dorado */
        color: var(--ds-bg-dark);
    }

    /* Estilo para las Tarjetas (Cards) */
    .ds-card {
        background-color: #1a1a1a;
        /* Fondo similar al ds-container */
        border: 1px solid var(--ds-border-grey);
        border-radius: 0;
        /* Bordes cuadrados */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
        transition: all 0.3s ease;
    }

    /* Efecto Hover sobre la tarjeta (para simular interacción de UI de juego) */
    .ds-card-link:hover .ds-card {
        border-color: var(--ds-highlight-gold);
        background-color: #242424;
        /* Ligeramente más claro en hover */
        box-shadow: 0 4px 15px rgba(184, 134, 11, 0.5);
        transform: translateY(-3px);
        /* Pequeño efecto de levantamiento */
    }

    /* Asegura que el texto dentro de la tarjeta sea el color claro del tema */
    .ds-card * {
        /* Restablecer color para los elementos hijos */
        color: inherit; 
    }
    
    .ds-card-body h5 {
        color: var(--ds-highlight-gold);
    }
    
    /* Corrección para enlaces dentro de las cards que no son nav-link */
    a {
        color: var(--ds-highlight-gold);
    }

    </style>
</head>

<body>
    
    {{-- Formulario oculto para el Logout, necesario para el método POST --}}
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    
    <div class="container-fluid ds-container">
        <header class="ds-header">
            {{-- Enlace a Home si el usuario está logeado --}}
            @auth
                <a href="{{ route('regiones.landingPage') }}" style="text-decoration: none;">
                    <h1>Compendio del Cenizo</h1>
                </a>
            @else
                <h1>Compendio del Cenizo</h1>
            @endauth
            <p class="mb-0" style="font-size: 0.9rem;">Guía para el Viajero No Muerto</p>
        </header>

        {{-- 🛑 BLOQUE DE MENSAJES 🛑 --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="background-color: #4CAF5033; border-color: #4CAF50; color: #C8E6C9;">
                <strong>¡Éxito!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="color: white;"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="background-color: #F4433633; border-color: #F44336; color: #FFCDD2;">
                <strong>¡Error!</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="color: white;"></button>
            </div>
        @endif
        {{-- FIN BLOQUE DE MENSAJES --}}

        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid justify-content-center">
                <ul class="navbar-nav">
                    
                    {{-- Enlaces Públicos / Autenticados --}}
                    <li class="nav-item">
                        <a class="nav-link ds-nav-link" href="{{ route('regiones.index') }}">Regiones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link ds-nav-link" href="{{ route('zonas.index') }}">Zonas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link ds-nav-link " href="{{ route('objetos.index') }}">Objetos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link ds-nav-link " href="{{ route('enemigos.index') }}">Enemigos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link ds-nav-link" href="{{ route('armas.index') }}">Armas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link ds-nav-link" href="{{ route('regiones.areaVip') }}">Area VIP</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link ds-nav-link" href="{{ route('home') }}">Home</a>
                    </li>
                    
                    <hr style="border-color: #444; margin: 0 10px;">
                    
                    {{-- ENLACES DE AUTENTICACIÓN (Condicionales) --}}
                    @guest
                        {{-- Usuario NO autenticado --}}
                        <li class="nav-item">
                            <a class="nav-link ds-nav-link" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link ds-nav-link" href="{{ route('register') }}">
                                    <i class="fas fa-scroll"></i> Registro
                                </a>
                            </li>
                        @endif
                    @else
                        {{-- Usuario AUTENTICADO --}}
                        <li class="nav-item ds-user-title">
                            {{-- Muestra el nombre del usuario --}}
                            <i class="fas fa-user-circle"></i> {{ Auth::user()->name }}
                        </li>
                        
                        <li class="nav-item">
                            <button class="ds-logout-btn" 
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-power-off"></i> Logout
                            </button>
                        </li>
                    @endguest

                </ul>
            </div>
        </nav>

        <hr style="border-color: var(--ds-border-grey); margin-top: 20px; margin-bottom: 20px;">

        <main class="ds-content">
            @yield('content')
        </main>

        <hr style="border-color: var(--ds-border-grey); margin-top: 30px; margin-bottom: 10px;">

        <footer class="text-center mt-3" style="font-size: 0.7rem;">
            <p>&copy; 2025 Compendio No Muerto. **Praise the Sun!**</p>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    {{-- Si usas Webpack Mix, descomenta la línea de JS: --}}
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
    
</body>
</html>