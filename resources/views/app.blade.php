<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
        <link rel="stylesheet" href="https://unpkg.com/vue-multiselect/dist/vue-multiselect.min.css">
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
    <style>
        .multiselect {
            width: 400px;
        }
        .bg-gainsboro {
            background-color: gainsboro;
        }
    </style>
</html>
