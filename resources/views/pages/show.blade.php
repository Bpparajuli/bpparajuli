<x-layouts.public>
    <x-slot:seo>
        <x-seo
            :title="$page->seo_title ?: $page->title"
            :description="$page->seo_description ?: $page->excerpt"
            :image="$page->og_image ?: $page->featured_image"
            :canonical="$page->canonical_url"
        />
    </x-slot:seo>

    <article class="shell-narrow py-16 sm:py-20 lg:py-24">
        <nav class="text-sm text-muted" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="transition hover:text-brand">Home</a>
            <span class="mx-2" aria-hidden="true">/</span>
            <span>{{ $page->title }}</span>
        </nav>

        <header class="mt-6">
            <h1 class="display-2">{{ $page->title }}</h1>
            @if ($page->excerpt)
                <p class="lede mt-4">{{ $page->excerpt }}</p>
            @endif
        </header>

        @if ($image = media_url($page->featured_image))
            <img src="{{ $image }}" alt="{{ $page->title }}" class="mt-10 w-full rounded-2xl border border-ink/8" loading="lazy" decoding="async">
        @endif

        @if ($page->content)
            <div class="prose-content mt-10">{!! safe_html($page->content) !!}</div>
        @endif
    </article>
</x-layouts.public>
