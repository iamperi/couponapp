<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/admin.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 px-4">
            <nav class="admin-nav fixed rounded shadow-lg flex items-center p-4">
                <div class="admin-nav-left flex-grow">
                    <img src="{{ asset('img/icons/notes.svg') }}" class="w-8">
                </div>

                <div class="admin-nav-center flex-grow text-center">
                    <label>Cupones WebApp</label>
                </div>

                <div class="admin-nav-right flex-grow">

                </div>
            </nav>

            <div class="admin-sidebar">

            </div>

            <main class="pt-24">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
