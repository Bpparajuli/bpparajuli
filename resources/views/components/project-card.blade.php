@props(['project'])

@php
    $image = media_url($project->featured_image);
@endphp

<article class="card card-hover group flex h-full flex-col overflow-hidden">
    <a href="{{ route('projects.show', $project) }}" class="block" tabindex="-1" aria-hidden="true">
        <div class="relative aspect-[16/10] overflow-hidden bg-gradient-to-br from-brand/10 via-secondary/10 to-accent/10">
            @if ($image)
                <img
                    src="{{ $image }}"
                    alt="{{ $project->title }}"
                    loading="lazy"
                    decoding="async"
                    class="h-full w-full object-cover transition duration-700 ease-out group-hover:scale-[1.04]"
                >
            @else
                <div class="flex h-full w-full items-center justify-center text-brand/40">
                    <x-icon name="layers" class="h-12 w-12" />
                </div>
            @endif

            @if ($project->category)
                <span class="absolute left-3 top-3 rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-brand backdrop-blur">
                    {{ $project->category->name }}
                </span>
            @endif

            <span class="absolute right-3 top-3 rounded-full bg-ink/80 px-3 py-1 text-xs font-medium text-white backdrop-blur">
                {{ $project->statusLabel() }}
            </span>
        </div>
    </a>

    <div class="flex flex-1 flex-col p-6">
        <h3 class="font-display text-lg font-bold leading-snug">
            <a href="{{ route('projects.show', $project) }}" class="transition hover:text-brand">
                {{ $project->title }}
            </a>
        </h3>

        @if ($project->short_description)
            <p class="mt-2 line-clamp-3 flex-1 text-sm leading-relaxed text-muted">{{ $project->short_description }}</p>
        @endif

        @if (! empty($project->technologies))
            <div class="mt-4 flex flex-wrap gap-1.5">
                @foreach (array_slice($project->technologies, 0, 4) as $tech)
                    <span class="rounded-md bg-ink/5 px-2 py-0.5 text-[11px] font-medium text-ink/60">{{ $tech }}</span>
                @endforeach
            </div>
        @endif

        <a href="{{ route('projects.show', $project) }}" class="mt-5 inline-flex items-center gap-1.5 text-sm font-semibold text-brand">
            View Project
            <x-icon name="arrow-right" class="h-4 w-4 transition group-hover:translate-x-0.5" />
        </a>
    </div>
</article>
