@props([
    'title',
    'subtitle' => null,
    'actionUrl' => null,
    'actionLabel' => null,
])

<div class="mb-6 flex flex-wrap items-end justify-between gap-4">
    <div>
        <h2 class="font-display text-xl font-bold text-ink">{{ $title }}</h2>
        @if ($subtitle)
            <p class="mt-1 text-sm text-muted">{{ $subtitle }}</p>
        @endif
    </div>

    @if ($actionUrl && $actionLabel)
        <a href="{{ $actionUrl }}" class="admin-btn-primary">
            <x-icon name="plus" class="h-4 w-4" />
            {{ $actionLabel }}
        </a>
    @endif
</div>
