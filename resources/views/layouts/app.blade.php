<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/sidebar.css') }}" rel="stylesheet">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        body {
            min-height: 100vh;
            background-color: #f8f9fa;
        }
        
        #app {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }
        
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
            height: 60px;
            background-color: #6c757d;
            padding: 0.5rem 1rem;
        }
        
        .navbar .container-fluid {
            padding: 0;
        }
        
        .navbar-brand {
            padding: 0;
            margin-right: 2rem;
            color: white !important;
        }
        
        .navbar .nav-link {
            padding: 0.5rem 1rem !important;
            color: rgba(255, 255, 255, 0.85) !important;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .navbar .nav-link i {
            font-size: 1rem;
            line-height: 1;
        }

        .navbar .nav-link:hover {
            color: white !important;
        }

        .navbar-toggler {
            border-color: rgba(255, 255, 255, 0.1);
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.85%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        .navbar .dropdown-menu {
            background-color: #1a1a1a;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .navbar .dropdown-item {
            color: rgba(255, 255, 255, 0.85);
        }

        .navbar .dropdown-item:hover {
            background-color: #2d2d2d;
            color: white;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            position: fixed;
            left: 0;
            top: 60px;
            bottom: 0;
            z-index: 100;
            background-color: #fff;
            border-right: 1px solid #dee2e6;
            padding: 0;
        }
        
        .sidebar .nav-item {
            padding: 0;
            margin: 0;
            border-bottom: 1px solid #dee2e6;
        }
        
        .sidebar .nav-link {
            color: #333;
            padding: 0.75rem 1rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: all 0.2s ease;
            font-size: 0.95rem;
            border-radius: 0;
        }
        
        .sidebar .nav-link:hover {
            background-color: #f8f9fa;
        }
        
        .sidebar .nav-link.active {
            background-color: #e9ecef;
            color: #0d6efd;
            font-weight: 500;
        }
        
        .sidebar .nav-link i {
            width: 1.5rem;
            text-align: center;
            font-size: 1.1rem;
            opacity: 0.75;
        }
        
        .content-wrapper {
            display: flex;
            min-height: calc(100vh - 60px);
        }
        
        .main-content {
            flex: 1;
            padding: 1.5rem;
            margin-left: 250px;
            margin-top: 60px;
            transition: margin-left 0.3s ease;
        }

        /* Estilo para páginas sem autenticação */
        .guest-content .container {
            margin-top: 80px;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: relative;
                top: 0;
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <div id="app">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-md navbar-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">
                                        <i class="fas fa-sign-in-alt"></i> {{ __('Login') }}
                                    </a>
                                </li>
                            @endif
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">
                                        <i class="fas fa-user-plus"></i> {{ __('Register') }}
                                    </a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('profile.show') }}">
                                        {{ __('Perfil') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <div class="content-wrapper @guest guest-content @endguest">
            <!-- Sidebar -->
            @auth
            <nav class="sidebar">
                @include('layouts.sidebar')
            </nav>
            @endauth

            <!-- Main Content -->
            <main class="main-content @guest w-100 m-0 @endguest">
                @yield('content')
            </main>
        </div>
    </div>

    @yield('scripts')
    <script src="{{ asset('js/sidebar.js') }}"></script>
</body>
</html>
