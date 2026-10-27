@props(['icon' => 'sparkles', 'title' => 'Nothing here yet', 'message' => null])

<div {{ $attributes->merge(['class' => 'rounded-2xl border border-dashed border-ink/15 bg-white/60 px-8 py-14 text-center']) }}>
    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-brand/10 text-brand">
        <x-icon :name="$icon" class="h-6 w-6" />
    </div>
    <h3 class="mt-4 font-display text-lg font-semibold text-ink">{{ $title }}</h3>
    @if ($message)
        <p class="mx-auto mt-2 max-w-md text-sm leading-relaxed text-muted">{{ $message }}</p>
    @endif
    @if (isset($slot) && trim($slot) !== '')
        <div class="mt-6">{{ $slot }}</div>
    @endif
</div>
