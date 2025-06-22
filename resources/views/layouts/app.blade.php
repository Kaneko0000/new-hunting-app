<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- <title>{{ config('app.name', 'Laravel') }}</title> -->
        <title>{{ isset($title) ? $title : 'ハンターパネル' }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Kaisei+Opti&display=swap" rel="stylesheet">

        <!-- mapbox CDN -->
        <script src="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.js" defer></script>
        <link href="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.css" rel="stylesheet" />

        <!-- FullCalendar v6 CDN構成（正解） -->
        <!-- <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.global.min.js"></script> -->
        <!-- <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet" /> -->

        <!-- @vite(['resources/css/app.css', 'resources/css/custom.css', 'resources/js/app.js']) -->
        @vite(['resources/css/app.css', 'resources/css/custom.css', 'resources/js/app.js', 'resources/js/custom.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="mt-20">
                @yield('content')  <!-- @section('content') の内容がここに出力される -->
            </main>

        </div>
        @yield('scripts')
    </body>
</html>
