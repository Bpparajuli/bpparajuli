<section class="section">
    <div class="shell">
        <div class="relative overflow-hidden rounded-3xl bg-ink px-8 py-14 text-white sm:px-14 sm:py-20">
            <div class="pointer-events-none absolute -right-24 -top-24 h-72 w-72 rounded-full bg-brand/40 blur-3xl"></div>
            <div class="pointer-events-none absolute -bottom-32 -left-16 h-72 w-72 rounded-full bg-accent/30 blur-3xl"></div>

            <div class="relative max-w-2xl">
                <p class="eyebrow text-white/70 reveal">{{ $eyebrow ?? 'Get in touch' }}</p>
                <h2 class="display-2 reveal mt-3 !text-white">
                    {{ $title ?? "Let's build something that works." }}
                </h2>
                <p class="mt-4 text-lg leading-relaxed text-white/70 reveal">
                    {{ $copy ?? 'Have a project, a problem, or an idea worth exploring? Start a conversation and let us work through it together.' }}
                </p>

                <div class="mt-8 flex flex-wrap gap-3 reveal">
                    <a href="{{ route('contact.index') }}" class="btn bg-white text-ink hover:bg-white/90">
                        Let's Connect
                        <x-icon name="arrow-right" class="h-4 w-4" />
                    </a>
                    @if ($email = setting('contact_email'))
                        <a href="mailto:{{ $email }}" class="btn border border-white/20 text-white hover:bg-white/10">
                            <x-icon name="mail" class="h-4 w-4" />
                            Email me
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
