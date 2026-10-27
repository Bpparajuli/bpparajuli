@props(['service'])

<article class="card card-hover group flex h-full flex-col p-7">
    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-brand/10 text-brand transition group-hover:bg-brand group-hover:text-white">
        <x-icon :name="$service->icon ?: 'sparkles'" class="h-6 w-6" />
    </div>

    <h3 class="mt-5 font-display text-lg font-bold">
        <a href="{{ route('services.show', $service) }}" class="transition hover:text-brand">{{ $service->title }}</a>
    </h3>

    @if ($service->short_description)
        <p class="mt-2 flex-1 text-sm leading-relaxed text-muted">{{ $service->short_description }}</p>
    @endif

    <a href="{{ route('services.show', $service) }}" class="mt-5 inline-flex items-center gap-1.5 text-sm font-semibold text-brand">
        Learn more
        <x-icon name="arrow-right" class="h-4 w-4 transition group-hover:translate-x-0.5" />
    </a>
</article>
