<x-layouts.public>
    <x-slot:seo>
        <x-seo
            :title="setting('contact_meta_title', 'Contact')"
            :description="setting('contact_meta_description', 'Get in touch to discuss a project, a problem or an idea.')"
        />
    </x-slot:seo>

    <section class="border-b border-ink/8 bg-white">
        <div class="shell py-16 sm:py-20">
            <p class="eyebrow reveal">Contact</p>
            <h1 class="display-1 reveal mt-4 max-w-3xl">Let's start a conversation.</h1>
            <p class="lede reveal mt-6 max-w-2xl">
                Tell me what you are working on, what is getting in the way, and what a good outcome looks like.
            </p>
        </div>
    </section>

    <section class="section">
        <div class="shell grid gap-12 lg:grid-cols-12 lg:gap-16">
            <div class="lg:col-span-4">
                <h2 class="display-3">Reach me directly</h2>
                <div class="mt-6 space-y-4 text-sm">
                    @if ($email = setting('contact_email'))
                        <a href="mailto:{{ $email }}" class="flex items-start gap-3 text-ink/80 transition hover:text-brand">
                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-brand/10 text-brand">
                                <x-icon name="mail" class="h-4 w-4" />
                            </span>
                            <span>
                                <span class="block text-xs font-semibold uppercase tracking-widest text-muted">Email</span>
                                {{ $email }}
                            </span>
                        </a>
                    @endif
                    @if ($phone = setting('contact_phone'))
                        <a href="tel:{{ preg_replace('/\s+/', '', $phone) }}" class="flex items-start gap-3 text-ink/80 transition hover:text-brand">
                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-brand/10 text-brand">
                                <x-icon name="phone" class="h-4 w-4" />
                            </span>
                            <span>
                                <span class="block text-xs font-semibold uppercase tracking-widest text-muted">Phone</span>
                                {{ $phone }}
                            </span>
                        </a>
                    @endif
                    @if ($location = setting('contact_location'))
                        <div class="flex items-start gap-3 text-ink/80">
                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-brand/10 text-brand">
                                <x-icon name="map-pin" class="h-4 w-4" />
                            </span>
                            <span>
                                <span class="block text-xs font-semibold uppercase tracking-widest text-muted">Location</span>
                                {{ $location }}
                            </span>
                        </div>
                    @endif
                </div>

                @if ($socials = \App\Support\SiteData::social())
                    @if ($socials->isNotEmpty())
                        <div class="mt-8 flex flex-wrap gap-2">
                            @foreach ($socials as $social)
                                <a href="{{ $social->url }}" target="_blank" rel="noopener noreferrer" aria-label="{{ $social->displayLabel() }}"
                                   class="flex h-10 w-10 items-center justify-center rounded-full border border-ink/10 text-ink/70 transition hover:border-brand/30 hover:bg-brand/5 hover:text-brand">
                                    <x-icon :name="$social->icon ?: $social->platform" class="h-5 w-5" />
                                </a>
                            @endforeach
                        </div>
                    @endif
                @endif
            </div>

            <div class="lg:col-span-8">
                @if (session('contact_status'))
                    <div class="mb-6">
                        <x-alert type="success" :message="session('contact_status')" />
                    </div>
                @endif

                <div class="card p-6 sm:p-8">
                    <form method="POST" action="{{ route('contact.store') }}" class="space-y-5" novalidate>
                        @csrf

                        <div class="grid gap-5 sm:grid-cols-2">
                            <x-form.input name="name" label="Name" :value="old('name')" required autocomplete="name" />
                            <x-form.input name="email" type="email" label="Email" :value="old('email')" required autocomplete="email" />
                        </div>

                        <div class="grid gap-5 sm:grid-cols-2">
                            <x-form.input name="phone" label="Phone" :value="old('phone')" autocomplete="tel" hint="Optional" />
                            <x-form.input name="subject" label="Subject" :value="old('subject')" hint="Optional" />
                        </div>

                        <x-form.textarea name="message" label="Message" :value="old('message')" required rows="7" />

                        {{-- Honeypot field: hidden from users, tempting to bots --}}
                        <div class="hidden" aria-hidden="true">
                            <label for="website">Website</label>
                            <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
                        </div>

                        <div class="flex flex-wrap items-center justify-between gap-4">
                            <p class="text-xs text-muted">Your details are only used to respond to your enquiry.</p>
                            <button type="submit" class="btn-brand">
                                Send message
                                <x-icon name="send" class="h-4 w-4" />
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-layouts.public>
