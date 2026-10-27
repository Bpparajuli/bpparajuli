<x-layouts.public>
    <x-slot:seo>
        <x-seo
            :title="setting('about_meta_title', 'About')"
            :description="setting('about_meta_description', \App\Support\SiteData::profile('short_bio'))"
            :person="true"
        />
    </x-slot:seo>

    @php
        $image = media_url(\App\Support\SiteData::profile('image'));
        $name = \App\Support\SiteData::profile('name');
        $headline = \App\Support\SiteData::profile('headline');
        $bio = \App\Support\SiteData::profile('bio');
        $shortBio = \App\Support\SiteData::profile('short_bio');
        $location = \App\Support\SiteData::profile('location');
        $focus = \App\Support\SiteData::profile('current_focus');
    @endphp

    <section class="border-b border-ink/8 bg-white">
        <div class="shell grid gap-12 py-16 sm:py-20 lg:grid-cols-12 lg:items-center lg:gap-16">
            <div class="lg:col-span-7">
                <p class="eyebrow reveal">About</p>
                <h1 class="display-1 reveal mt-4">{{ $name ?: setting('site_name') }}</h1>
                @if ($headline)
                    <p class="lede reveal mt-6 max-w-2xl">{{ $headline }}</p>
                @endif
                @if ($location)
                    <p class="reveal mt-6 inline-flex items-center gap-2 text-sm font-medium text-muted">
                        <x-icon name="map-pin" class="h-4 w-4 text-brand" /> {{ $location }}
                    </p>
                @endif
            </div>

            @if ($image)
                <div class="reveal lg:col-span-5">
                    <div class="mx-auto aspect-[4/5] max-w-xs overflow-hidden rounded-[1.75rem] border border-ink/8 bg-white shadow-lift lg:max-w-sm">
                        <img src="{{ $image }}" alt="{{ $name }}" class="h-full w-full object-cover" loading="lazy" decoding="async">
                    </div>
                </div>
            @endif
        </div>
    </section>

    <section class="section">
        <div class="shell grid gap-12 lg:grid-cols-12 lg:gap-16">
            <div class="lg:col-span-4">
                <h2 class="display-3 reveal">The story so far</h2>
            </div>
            <div class="lg:col-span-8">
                @if ($bio)
                    <div class="prose-content reveal">{!! safe_html($bio) !!}</div>
                @elseif ($shortBio)
                    <p class="prose-content reveal">{{ $shortBio }}</p>
                @else
                    <x-empty-state
                        icon="user"
                        title="Biography coming soon"
                        message="A detailed professional story will be published here."
                    />
                @endif
            </div>
        </div>
    </section>

    @if ($skillCategories->isNotEmpty())
        <section class="section bg-white">
            <div class="shell">
                <x-section-heading
                    eyebrow="Areas of Work"
                    title="Where I focus"
                    subtitle="The disciplines I apply, and the tools that support them."
                    class="reveal"
                />

                <div class="mt-12 grid gap-8 lg:grid-cols-2">
                    @foreach ($skillCategories as $category)
                        <div class="reveal">
                            <div class="flex items-center gap-3">
                                <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-brand/10 text-brand">
                                    <x-icon :name="$category->icon ?: 'cpu'" class="h-5 w-5" />
                                </span>
                                <h3 class="font-display text-lg font-bold">{{ $category->name }}</h3>
                            </div>
                            @if ($category->description)
                                <p class="mt-2 text-sm leading-relaxed text-muted">{{ $category->description }}</p>
                            @endif
                            <div class="mt-4 space-y-2.5">
                                @foreach ($category->skills as $skill)
                                    <x-skill-card :skill="$skill" />
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if ($experiences->isNotEmpty())
        <section class="section">
            <div class="shell">
                <x-section-heading
                    eyebrow="Professional Journey"
                    title="Experience"
                    subtitle="Roles and organisations that shaped how I work."
                    class="reveal"
                />
                <div class="mt-12">
                    <x-timeline :experiences="$experiences" />
                </div>
            </div>
        </section>
    @endif

    @if ($focus)
        <section class="section bg-white">
            <div class="shell">
                <div class="grid gap-10 lg:grid-cols-12 lg:gap-16">
                    <div class="lg:col-span-4">
                        <x-section-heading eyebrow="Current Focus" title="What I am building toward" class="reveal" />
                    </div>
                    <div class="lg:col-span-8">
                        <p class="prose-content reveal">{!! safe_html($focus) !!}</p>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <x-cta eyebrow="Contact" title="Let's work together" copy="If any of this resonates with a problem you are trying to solve, I would like to hear about it." />
</x-layouts.public>
