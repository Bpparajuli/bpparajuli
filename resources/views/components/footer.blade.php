@php
    $socials = \App\Support\SiteData::social();
    $siteName = setting('site_name', config('app.name'));
    $tagline = setting('tagline');
    $footerLinks = \App\Support\SiteData::navigation('footer');
    $year = now()->year;
@endphp

<footer class="mt-auto border-t border-ink/8 bg-white">
    <div class="shell py-14 lg:py-20">
        <div class="grid gap-10 lg:grid-cols-12">
            <div class="lg:col-span-5">
                <a href="{{ route('home') }}" class="font-display text-xl font-extrabold text-ink">{{ $siteName }}</a>
                @if ($tagline)
                    <p class="mt-3 max-w-sm text-sm leading-relaxed text-muted">{{ $tagline }}</p>
                @endif

                <div class="mt-6 space-y-2 text-sm text-muted">
                    @if ($email = setting('contact_email'))
                        <a href="mailto:{{ $email }}" class="flex items-center gap-2 transition hover:text-brand">
                            <x-icon name="mail" class="h-4 w-4" /> {{ $email }}
                        </a>
                    @endif
                    @if ($phone = setting('contact_phone'))
                        <a href="tel:{{ preg_replace('/\s+/', '', $phone) }}" class="flex items-center gap-2 transition hover:text-brand">
                            <x-icon name="phone" class="h-4 w-4" /> {{ $phone }}
                        </a>
                    @endif
                    @if ($location = setting('contact_location'))
                        <span class="flex items-center gap-2">
                            <x-icon name="map-pin" class="h-4 w-4" /> {{ $location }}
                        </span>
                    @endif
                </div>
            </div>

            <div class="lg:col-span-3">
                <h2 class="font-display text-sm font-semibold uppercase tracking-widest text-ink">Explore</h2>
                <ul class="mt-4 space-y-2.5 text-sm text-muted">
                    @foreach ($footerLinks as $link)
                        <li>
                            <a href="{{ $link->url }}" class="transition hover:text-brand">{{ $link->label }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="lg:col-span-4">
                <h2 class="font-display text-sm font-semibold uppercase tracking-widest text-ink">Connect</h2>
                @if ($socials->isNotEmpty())
                    <div class="mt-4 flex flex-wrap gap-2">
                        @foreach ($socials as $social)
                            <a
                                href="{{ $social->url }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                aria-label="{{ $social->displayLabel() }}"
                                class="flex h-10 w-10 items-center justify-center rounded-full border border-ink/10 text-ink/70 transition hover:border-brand/30 hover:bg-brand/5 hover:text-brand"
                            >
                                <x-icon :name="$social->icon ?: $social->platform" class="h-5 w-5" />
                            </a>
                        @endforeach
                    </div>
                @endif

                <a href="{{ route('contact.index') }}" class="btn-outline btn-sm mt-6">
                    Start a conversation
                    <x-icon name="arrow-right" class="h-4 w-4" />
                </a>
            </div>
        </div>

        <div class="mt-12 flex flex-col gap-4 border-t border-ink/8 pt-6 text-xs text-muted sm:flex-row sm:items-center sm:justify-between">
            <p>&copy; {{ $year }} {{ $siteName }}. All rights reserved.</p>
            <div class="flex items-center gap-4">
                @foreach (\App\Support\SiteData::navigation('legal') as $link)
                    <a href="{{ $link->url }}" class="transition hover:text-brand">{{ $link->label }}</a>
                @endforeach
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="transition hover:text-brand">Admin</a>
                @endauth
            </div>
        </div>
    </div>
</footer>
