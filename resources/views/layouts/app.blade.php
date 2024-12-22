<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- Bootstrap Icons (optional for navigation icons) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .sidebar {
            width: 60px;
            position: fixed; 
            top: 0;
            left: 0;
            height: 100vh;
            background-color: #f8f9fa;
            transition: width 0.3s ease;
            z-index: 1030; 
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            overflow-x: hidden;
        }

        .sidebar:hover {
            width: 200px;
        }

        .sidebar-item {
            padding: 4px 10px;
        }

        .sidebar-link {
            text-decoration: none;
            color: #333;
            border-radius: 8px;
            padding: 5px;
            display: flex;
            align-items: center;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .sidebar-link:hover,
        .sidebar-link.active {
            background-color: #007bff;
            color: #fff;
        }

        .sidebar-link i {
            font-size: 1.5rem;
            transition: transform 0.3s ease;
        }

        .sidebar-text {
            white-space: nowrap;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar:hover .sidebar-text {
            opacity: 1;
        }

        .main-content {
            margin-top: 60px;
            margin-left: 60px;
            transition: margin-left 0.3s ease;
        }

        .no-sidebar {
            margin-left: 0;
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <div id="app">
        <div class="d-flex">
            @auth
                @include('partials.side_navigation')
            @endauth
            <div class="flex-grow-1 main-content {{ Auth::check() ? '' : 'no-sidebar' }}">
                @include('partials.navigation')

                <main class="p-4">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
        });
    </script>
</body>

</html>
