@php
    $profile = \App\Support\SiteData::profile('short_bio')
        ?: 'I build and operate systems across business and technology — from defining the problem to delivering something that actually works in the real world.';
    $role = \App\Support\SiteData::profile('headline');
    $location = \App\Support\SiteData::profile('location');
@endphp

<section class="section">
    <div class="shell">
        <div class="grid gap-10 lg:grid-cols-12 lg:gap-16">
            <div class="lg:col-span-4">
                <p class="eyebrow reveal">{{ $section->eyebrow ?: 'About' }}</p>
                <h2 class="display-3 reveal mt-3">{{ $section->title ?: 'A little about me' }}</h2>
            </div>

            <div class="lg:col-span-8">
                @if ($role)
                    <p class="font-display text-xl font-semibold leading-snug text-ink reveal sm:text-2xl">{{ $role }}</p>
                @endif

                <p class="prose-content reveal mt-5 max-w-2xl">{{ $profile }}</p>

                <div class="reveal mt-8">
                    <a href="{{ route('about') }}" class="btn-outline">
                        More about me
                        <x-icon name="arrow-right" class="h-4 w-4" />
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
