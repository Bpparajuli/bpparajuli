<x-layouts.public>
    <x-slot:seo>
        <x-seo
            :title="$service->seo_title ?: $service->title"
            :description="$service->seo_description ?: $service->short_description"
        />
    </x-slot:seo>

    <article class="shell py-16 sm:py-20 lg:py-24">
        <nav class="text-sm text-muted" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="transition hover:text-brand">Home</a>
            <span class="mx-2" aria-hidden="true">/</span>
            <a href="{{ route('services.index') }}" class="transition hover:text-brand">Services</a>
            <span class="mx-2" aria-hidden="true">/</span>
            <span class="text-ink/60">{{ $service->title }}</span>
        </nav>

        <header class="mt-6 max-w-3xl">
            <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-brand/10 text-brand">
                <x-icon :name="$service->icon ?: 'sparkles'" class="h-6 w-6" />
            </span>
            <h1 class="display-1 mt-5">{{ $service->title }}</h1>
            @if ($service->short_description)
                <p class="lede mt-5">{{ $service->short_description }}</p>
            @endif
        </header>

        @if ($service->full_description)
            <div class="prose-content mt-10 max-w-3xl">{!! safe_html($service->full_description) !!}</div>
        @endif

        <div class="mt-12">
            <a href="{{ route('contact.index') }}" class="btn-brand">
                Discuss this with me
                <x-icon name="arrow-right" class="h-4 w-4" />
            </a>
        </div>
    </article>

    @if ($others->isNotEmpty())
        <section class="section bg-white">
            <div class="shell">
                <h2 class="display-3 reveal">Other services</h2>
                <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($others as $other)
                        <x-service-card :service="$other" class="reveal" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <x-cta />
</x-layouts.public>
