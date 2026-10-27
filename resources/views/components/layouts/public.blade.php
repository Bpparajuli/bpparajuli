<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @if ($favicon = setting('favicon'))
        <link rel="icon" href="{{ media_url($favicon) }}">
    @else
        <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    @endif

    {{ $seo ?? '' }}

    @fonts

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @include('partials.brand-vars')

    @stack('head')
</head>
<body class="flex min-h-screen flex-col">
    <a
        href="#main"
        class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-[60] focus:rounded-lg focus:bg-ink focus:px-4 focus:py-2 focus:text-sm focus:text-white"
    >
        Skip to content
    </a>

    <x-navbar />

    <main id="main" class="flex-1">
        {{ $slot }}
    </main>

    <x-footer />

    @stack('scripts')
</body>
</html>
