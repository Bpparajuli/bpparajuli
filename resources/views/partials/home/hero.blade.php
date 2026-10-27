@php
    $image = media_url(\App\Support\SiteData::profile('image'));
    $availability = \App\Support\SiteData::profile('availability');
    $headline = $section->title ?: setting('hero_headline', 'Business. Technology. Systems. Execution.');
    $subtitle = $section->subtitle ?: setting('hero_subtitle', 'I work at the intersection of entrepreneurship, consultancy, technology and operations — turning ideas into practical systems that solve real-world problems.');
@endphp

<section class="relative overflow-hidden">
    <div class="pointer-events-none absolute inset-0 grain opacity-60" aria-hidden="true"></div>
    <div class="pointer-events-none absolute -right-40 top-0 h-[28rem] w-[28rem] rounded-full bg-brand/10 blur-3xl" aria-hidden="true"></div>

    <div class="shell relative grid gap-12 py-16 sm:py-20 lg:grid-cols-12 lg:items-center lg:gap-16 lg:py-28">
        <div class="lg:col-span-7">
            @if ($availability)
                <span class="badge reveal">
                    <span class="relative flex h-2 w-2">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex h-2 w-2 rounded-full bg-emerald-500"></span>
                    </span>
                    {{ $availability }}
                </span>
            @endif

            @if ($section->eyebrow)
                <p class="eyebrow reveal mt-6">{{ $section->eyebrow }}</p>
            @endif

            <h1 class="display-1 reveal mt-4">
                {{ $headline }}
            </h1>

            <p class="lede reveal mt-6 max-w-2xl">{{ $subtitle }}</p>

            <div class="reveal mt-9 flex flex-wrap items-center gap-3">
                <a href="{{ route('projects.index') }}" class="btn-brand">
                    Explore my work
                    <x-icon name="arrow-right" class="h-4 w-4" />
                </a>
                <a href="{{ route('contact.index') }}" class="btn-outline">
                    Let's Connect
                </a>
            </div>

            @php
                $focus = \App\Support\SiteData::profile('current_focus');
                $location = \App\Support\SiteData::profile('location');
            @endphp

            @if ($focus || $location)
                <dl class="reveal mt-12 grid gap-6 border-t border-ink/8 pt-8 sm:grid-cols-2">
                    @if ($location)
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-widest text-muted">Based in</dt>
                            <dd class="mt-1.5 flex items-center gap-2 text-sm font-medium text-ink">
                                <x-icon name="map-pin" class="h-4 w-4 text-brand" /> {{ $location }}
                            </dd>
                        </div>
                    @endif
                    @if ($focus)
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-widest text-muted">Current focus</dt>
                            <dd class="mt-1.5 text-sm font-medium leading-relaxed text-ink">{{ $focus }}</dd>
                        </div>
                    @endif
                </dl>
            @endif
        </div>

        <div class="reveal lg:col-span-5">
            <div class="relative mx-auto max-w-sm">
                <div class="absolute -inset-4 rounded-[2rem] bg-gradient-to-br from-brand/15 via-secondary/10 to-accent/15" aria-hidden="true"></div>
                <div class="relative aspect-[4/5] overflow-hidden rounded-[1.75rem] border border-white/60 bg-white shadow-lift">
                    @if ($image)
                        <img
                            src="{{ $image }}"
                            alt="{{ \App\Support\SiteData::profile('name') }}"
                            width="800"
                            height="1000"
                            class="h-full w-full object-cover"
                        >
                    @else
                        <div class="flex h-full w-full flex-col items-center justify-center gap-3 bg-gradient-to-br from-brand/10 to-secondary/10 text-brand/50">
                            <x-icon name="user" class="h-16 w-16" />
                            <span class="text-xs font-medium uppercase tracking-widest">Add a profile photo</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
