@props(['title', 'route', 'item' => null])

<div class="mx-auto max-w-3xl">
    <div class="mb-6">
        <a href="{{ route($route.'.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-muted transition hover:text-brand">
            <x-icon name="arrow-left" class="h-4 w-4" />
            Back to list
        </a>
        <h2 class="mt-3 font-display text-xl font-bold text-ink">{{ $title }}</h2>
    </div>

    {{ $slot }}
</div>
