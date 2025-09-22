<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('frontend/css/estilodas.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/stilotech.css') }}">
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <div class="dashboard-wrapper">
            @php
                $role = auth()->user()->role ?? 'cliente';
            @endphp

            @if ($role === 'admin')
                @include('frontend.layouts.sidebar-admin')
            @elseif ($role === 'empleado')
                @include('frontend.layouts.sidebar-empleado')
            @else
                @include('frontend.layouts.sidebar-cliente')
            @endif

            <main class="main-content">
                @yield('content')
            </main>
        </div>

        <script src="{{ asset('frontend/js/perfilad.js') }}" defer></script>
    </div>
</body>
</html>
