@props(['type' => 'info', 'message' => null])

@php
    $styles = [
        'success' => ['bg-emerald-50', 'text-emerald-800', 'border-emerald-200', 'check-circle'],
        'error' => ['bg-red-50', 'text-red-800', 'border-red-200', 'alert'],
        'warning' => ['bg-amber-50', 'text-amber-800', 'border-amber-200', 'alert'],
        'info' => ['bg-sky-50', 'text-sky-800', 'border-sky-200', 'info'],
    ];
    [$bg, $text, $border, $icon] = $styles[$type] ?? $styles['info'];
@endphp

<div role="alert" {{ $attributes->merge(['class' => "flex items-start gap-3 rounded-xl border $border $bg px-4 py-3 text-sm $text"]) }}>
    <x-icon :name="$icon" class="mt-0.5 h-5 w-5 shrink-0" />
    <div class="leading-relaxed">{{ $message ?? $slot }}</div>
</div>
