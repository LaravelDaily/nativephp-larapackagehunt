<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', config('app.name', 'Laravel Package Hunt'))</title>
        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="nativephp-safe-area min-h-screen bg-white font-sans text-slate-900 antialiased">
        @yield('content')

        <native:bottom-nav label-visibility="labeled">
            <native:bottom-nav-item
                id="home"
                icon="home"
                label="Home"
                :url="route('home')"
                :active="true"
            />
            <native:bottom-nav-item
                id="discover"
                icon="search"
                label="Discover"
                url="#"
            />
        </native:bottom-nav>
        @livewireScripts
    </body>
</html>
