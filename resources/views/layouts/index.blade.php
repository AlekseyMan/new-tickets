<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="https://unpkg.com/@tabler/core@latest/dist/js/tabler.min.js"></script>
    <script src="{{asset('js/helpers.js?' . date('H:i:s'))}}"></script>

    <!-- Styles -->
    <link rel="stylesheet" href="https://unpkg.com/@tabler/core@latest/dist/css/tabler.min.css">
    <meta name="viewport" content="width=device-width; initial-scale=1">
</head>
<body>
<x-top-menu />
<div class="container">
    @yield('content')
</div>
</body>
</html>

