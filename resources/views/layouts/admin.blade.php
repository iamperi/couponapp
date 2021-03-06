<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 px-4">
            <nav class="admin-nav fixed rounded shadow-lg flex items-center p-4 z-10 bg-white">
                <div class="admin-nav-left flex-grow">
                    <a href="/">
                        <img src="{{ asset('img/icons/home.svg') }}" class="w-8">
                    </a>
                </div>

                <div class="admin-nav-center flex-grow text-center">
                    <label>Cupones WebApp</label>
                </div>

                <div class="admin-nav-right flex-grow text-right">
                    @include('admin.includes.user-avatar')
                </div>
            </nav>

            <div class="admin-sidebar">

            </div>

            <main class="py-24 max-w-7xl m-auto">
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 6000)">
                    @include('admin.includes.tabs')
                    @if(session('success'))
                    <div class="alert alert-success alert-big mb-4 text-center" x-show="show">
                        <label>{{ session('success') }}</label>
                    </div>
                    @endif
                    @if(session('error'))
                    <div class="alert alert-error alert-big mb-4 text-center" x-show="show">
                        <label>{{ session('error') }}</label>
                    </div>
                    @endif
                    {{ $slot }}
                </div>
            </main>
        </div>

        <!-- Scripts -->
        <script src="{{ asset('js/admin.js') }}"></script>
        @stack('js')
    </body>
</html>
