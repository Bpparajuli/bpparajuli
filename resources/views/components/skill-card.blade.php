@props(['skill'])

<div class="group flex items-start gap-3 rounded-xl border border-ink/8 bg-white px-4 py-3.5 transition hover:border-brand/25 hover:shadow-soft">
    @if ($skill->icon)
        <span class="mt-0.5 text-brand">
            <x-icon :name="$skill->icon" class="h-5 w-5" />
        </span>
    @else
        <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-brand"></span>
    @endif

    <div class="min-w-0">
        <p class="text-sm font-semibold text-ink">{{ $skill->name }}</p>
        @if ($skill->description)
            <p class="mt-0.5 text-xs leading-relaxed text-muted">{{ $skill->description }}</p>
        @endif
    </div>

    @if ($skill->years_experience)
        <span class="ml-auto shrink-0 rounded-full bg-ink/5 px-2 py-0.5 text-[11px] font-medium text-ink/50">
            {{ $skill->years_experience }}y
        </span>
    @endif
</div>
