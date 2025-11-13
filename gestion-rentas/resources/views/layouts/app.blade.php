<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sistema de Rentas') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
            
            <div class="container-fluid">
                <!-- Hamburger Button (visible on all screen sizes) -->
                <button class="navbar-toggler mx-md-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu" aria-controls="offcanvasMenu" style="display: inline-block !important;">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!-- Logo/Brand -->
                <a class="navbar-brand fw-bold mx-md-3" href="{{ route('dashboard') }}">
                    <i class="fas fa-home me-2"></i>Sistema de Rentas de Departamentos
                </a>
                
                <!-- Navigation Links -->
                <div class="collapse navbar-collapse mx-md-3" id="navbarNav">
                    <!-- Left Side Navigation -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" 
                               href="{{ route('dashboard') }}">
                                <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                            </a>
                        </li>
                    </ul>
                    
                    <!-- Right Side Navigation -->
                    <ul class="navbar-nav ms-auto me-5">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" 
                               href="#" 
                               id="navbarDropdown" 
                               role="button" 
                               data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-2"></i>
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <!-- Profile Link -->
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                        <i class="fas fa-user me-2"></i>Mi Perfil
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                
                                <!-- Logout Form -->
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                
            </div>
        </nav>

        <!-- Removed duplicate mobile collapse: offcanvas is used for small screens -->

        <!-- Page Content -->
        <main class="py-4">
            <div class="container">
                <!-- [@yield('content')] -->
                 {{$slot}}
            </div>
        </main>
    </div>

        <!-- Offcanvas Sidebar -->
        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasMenuLabel">
            <i class="fas fa-home me-2"></i>Menu
        </h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="mb-3">
            <div class="fw-bold">{{ Auth::user()->name }}</div>
            <div class="text-muted small">{{ Auth::user()->email }}</div>
        </div>

        <nav class="nav nav-pills flex-column">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="fas fa-gauge me-2"></i>Dashboard
            </a>
           <a class="nav-link {{ request()->is('propiedades*') ? 'active' : '' }}" href="{{ route('propiedades.index') }}">
                 <i class="fas fa-building me-2"></i>Departamentos
            </a>
            <a class="nav-link {{ request()->is('inquilinos*') ? 'active' : '' }}" href="{{ route('inquilinos.index') }}">
                <i class="fas fa-users me-2"></i>Inquilinos
            </a>
            <a class="nav-link {{ request()->is('pagos*') ? 'active' : '' }}" href="#">
                <i class="fas fa-money-bill-wave me-2"></i>Pagos
            </a>
            <a class="nav-link {{ request()->is('gastos*') ? 'active' : '' }}" href="#">
                <i class="fas fa-receipt me-2"></i>Gastos
            </a>

            <!-- Reportes Dropdown -->
            <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle {{ request()->is('reportes*') ? 'active' : '' }}" 
                   href="#" role="button" data-bs-toggle="dropdown">
                    <i class="fas fa-chart-line me-2"></i>Reportes
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item {{ request()->routeIs('') ? 'active' : '' }}" 
                           href="#">
                            <i class="fas fa-balance-scale me-2"></i>Balance General
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item {{ request()->routeIs('') ? 'active' : '' }}" 
                           href="#">
                            <i class="fas fa-file-invoice-dollar me-2"></i>Estado de Cuenta
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item {{ request()->routeIs('') ? 'active' : '' }}" 
                           href="#">
                            <i class="fas fa-chart-bar me-2"></i>Reporte Mensual
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item {{ request()->routeIs('') ? 'active' : '' }}" 
                           href="#">
                            <i class="fas fa-chart-pie me-2"></i>Reporte Anual
                        </a>
                    </li>
                </ul>
            </div>

            <a class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}" href="{{ route('profile.edit') }}">
                <i class="fas fa-user me-2"></i>Mi Perfil
            </a>
            <div class="mt-3">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger w-100 text-start">
                        <i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión
                    </button>
                </form>
            </div>
        </nav>
    </div>
</div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Initialize Bootstrap components -->
    <script>
        // Initialize tooltips and popovers if needed
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>
</body>
</html>