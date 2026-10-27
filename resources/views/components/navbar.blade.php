@php
    $links = \App\Support\SiteData::navigation('header');

    if ($links->isEmpty()) {
        $links = collect([
            (object) ['label' => 'Home', 'url' => route('home'), 'target' => '_self'],
            (object) ['label' => 'About', 'url' => route('about'), 'target' => '_self'],
            (object) ['label' => 'Projects', 'url' => route('projects.index'), 'target' => '_self'],
            (object) ['label' => 'Services', 'url' => route('services.index'), 'target' => '_self'],
            (object) ['label' => 'Contact', 'url' => route('contact.index'), 'target' => '_self'],
        ]);
    }

    $logo = setting('logo');
    $siteName = setting('site_name', config('app.name'));
@endphp

<header
    x-data="{ open: false, scrolled: false }"
    x-init="scrolled = window.scrollY > 16; window.addEventListener('scroll', () => scrolled = window.scrollY > 16, { passive: true })"
    @keydown.escape.window="open = false"
    class="sticky top-0 z-50 transition"
    :class="scrolled ? 'border-b border-ink/8 bg-surface/85 backdrop-blur-lg' : 'border-b border-transparent'"
>
    <nav class="shell flex h-16 items-center justify-between gap-4 lg:h-20" aria-label="Primary">
        <a href="{{ route('home') }}" class="flex items-center gap-2.5 font-display text-lg font-extrabold tracking-tight text-ink">
            @if ($logo)
                <img src="{{ media_url($logo) }}" alt="{{ $siteName }}" class="h-9 w-auto">
            @else
                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-brand text-sm font-bold text-white">
                    {{ \Illuminate\Support\Str::of($siteName)->substr(0, 1)->upper() }}
                </span>
                <span>{{ $siteName }}</span>
            @endif
        </a>

        <div class="hidden items-center gap-1 lg:flex">
            @foreach ($links as $link)
                @php($isActive = ! str_starts_with($link->url, 'http') && url()->current() === rtrim($link->url, '/'))
                <a
                    href="{{ $link->url }}"
                    target="{{ $link->target ?? '_self' }}"
                    class="rounded-full px-4 py-2 text-sm font-medium transition {{ $isActive ? 'text-brand' : 'text-ink/70 hover:bg-ink/5 hover:text-ink' }}"
                    @if ($isActive) aria-current="page" @endif
                >
                    {{ $link->label }}
                </a>
            @endforeach
        </div>

        <div class="hidden items-center gap-2 lg:flex">
            <a href="{{ route('contact.index') }}" class="btn-brand btn-sm">
                Let's Connect
                <x-icon name="arrow-right" class="h-4 w-4" />
            </a>
        </div>

        <button
            type="button"
            class="inline-flex h-10 w-10 items-center justify-center rounded-lg text-ink transition hover:bg-ink/5 lg:hidden"
            @click="open = ! open"
            :aria-expanded="open.toString()"
            aria-controls="mobile-menu"
            aria-label="Toggle navigation"
        >
            <x-icon name="menu" class="h-6 w-6" x-show="! open" />
            <x-icon name="x" class="h-6 w-6" x-show="open" x-cloak />
        </button>
    </nav>

    <div
        id="mobile-menu"
        x-show="open"
        x-cloak
        x-transition.origin.top
        class="border-t border-ink/8 bg-surface lg:hidden"
    >
        <div class="shell space-y-1 py-4">
            @foreach ($links as $link)
                <a
                    href="{{ $link->url }}"
                    target="{{ $link->target ?? '_self' }}"
                    class="block rounded-xl px-4 py-3 text-base font-medium text-ink/80 transition hover:bg-ink/5 hover:text-ink"
                >
                    {{ $link->label }}
                </a>
            @endforeach

            <a href="{{ route('contact.index') }}" class="btn-brand mt-2 w-full">
                Let's Connect
                <x-icon name="arrow-right" class="h-4 w-4" />
            </a>
        </div>
    </div>
</header>
