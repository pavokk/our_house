<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'Skagesundvegen 63' }}</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    @stack('styles')
    @stack('headerScripts')
</head>
<body class="bg-primary text-main-dark">
    
    <x-partials.main-header />

    {{ $slot }}

    <x-partials.main-footer />

    @stack('bodyScripts')
</body>
</html>