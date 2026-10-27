<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ $title ?? 'Something went wrong' }}</title>
    @vite(['resources/css/app.css'])
</head>
<body class="flex min-h-screen items-center justify-center bg-surface px-6 py-16">
    <div class="w-full max-w-lg text-center">
        <p class="font-display text-6xl font-extrabold text-brand sm:text-7xl">{{ $code ?? 'Error' }}</p>
        <h1 class="display-3 mt-4">{{ $title ?? 'Something went wrong' }}</h1>
        <p class="lede mt-4">{{ $message ?? 'An unexpected error occurred. Please try again.' }}</p>

        <div class="mt-8 flex flex-wrap justify-center gap-3">
            <a href="{{ url('/') }}" class="btn-brand">
                Return home
                <x-icon name="arrow-right" class="h-4 w-4" />
            </a>
            @auth
                <a href="{{ route('admin.dashboard') }}" class="btn-outline">Admin dashboard</a>
            @endauth
        </div>
    </div>
</body>
</html>
