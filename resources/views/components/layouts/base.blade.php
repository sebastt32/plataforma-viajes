<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name', 'Viajes y Encargos') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-warm-50 min-h-screen flex flex-col">
        {{ $nav ?? '' }}

        <main class="flex-1">
            <div class="page-container pt-6">
                @include('partials.flash')
            </div>
            {{ $slot }}
        </main>

        @include('layouts.partials.footer')
    </body>
</html>
