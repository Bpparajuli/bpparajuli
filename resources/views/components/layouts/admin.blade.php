<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">

    @if ($favicon = setting('favicon'))
        <link rel="icon" href="{{ media_url($favicon) }}">
    @else
        <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    @endif

    <title>{{ $title ?? 'Dashboard' }} — Admin</title>

    @vite(['resources/css/app.css', 'resources/css/admin.css', 'resources/js/app.js'])

    @stack('head')
</head>
<body class="min-h-screen bg-surface text-ink">
    <div x-data="{ sidebarOpen: false }" class="flex min-h-screen">
        <x-admin.sidebar />

        <div class="flex min-w-0 flex-1 flex-col lg:pl-72">
            <x-admin.topbar :title="$title ?? 'Dashboard'" />

            <main class="flex-1 px-4 py-6 sm:px-6 lg:px-8">
                @if (session('status'))
                    <div class="mb-5">
                        <x-admin.alert type="success" :message="session('status')" />
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-5">
                        <x-admin.alert type="error" :message="session('error')" />
                    </div>
                @endif

                {{ $slot }}
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
