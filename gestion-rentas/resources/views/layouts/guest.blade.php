<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light">
    <div class="container-fluid vh-100">
        <div class="row h-100">
            <!-- Columna izquierda: Formulario -->
            <div class="col-md-6 d-flex align-items-center justify-content-center">
                <div class="w-100" style="max-width: 400px;">
                    {{ $slot }}
                </div>
            </div>

            <!-- Columna derecha: Imagen o información -->
            <div class="col-md-6 d-none d-md-block bg-primary">
                <div class="h-100 d-flex align-items-center justify-content-center text-white">
                    <div class="text-center">
                        <i class="fas fa-home fa-5x mb-4"></i>
                        <h2>Sistema de Gestión de Rentas</h2>
                        <p class="lead">Administra tus propiedades de manera eficiente</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>