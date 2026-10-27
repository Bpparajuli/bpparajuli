<x-layouts.public>
    <x-slot:seo>
        <x-seo title="Sign in" robots="noindex, nofollow" />
    </x-slot:seo>

    <div class="shell flex min-h-[70vh] items-center justify-center py-16">
        <div class="w-full max-w-md">
            <div class="card p-8">
                <a href="{{ route('home') }}" class="font-display text-lg font-extrabold text-ink">{{ setting('site_name', config('app.name')) }}</a>
                <h1 class="display-3 mt-6">Sign in</h1>
                <p class="mt-2 text-sm text-muted">Access the admin area.</p>

                @if ($errors->any())
                    <div class="mt-6">
                        <x-alert type="error" :message="$errors->first()" />
                    </div>
                @endif

                <form method="POST" action="{{ route('login.store') }}" class="mt-6 space-y-5">
                    @csrf
                    <x-form.input name="email" type="email" label="Email" required autocomplete="email" autofocus />
                    <x-form.input name="password" type="password" label="Password" required autocomplete="current-password" />

                    <x-form.checkbox name="remember" label="Remember me" />

                    <button type="submit" class="btn-brand w-full">
                        Sign in
                        <x-icon name="arrow-right" class="h-4 w-4" />
                    </button>
                </form>
            </div>

            <p class="mt-6 text-center text-xs text-muted">
                <a href="{{ route('home') }}" class="transition hover:text-brand">Return to website</a>
            </p>
        </div>
    </div>
</x-layouts.public>
