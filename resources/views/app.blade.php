<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? "rtl" : "ltr" }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title inertia>{{ config('app.name', 'Laravel') }}</title>


    <!-- Scripts -->
    @routes
    @vite(['resources/css/main.css', 'resources/js/app.js'])
    @inertiaHead
</head>
<body class="font-sans antialiased">
@inertia

<x-translations></x-translations>
</body>
</html>
