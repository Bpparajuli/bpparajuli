<x-layouts.public>
    <x-slot:seo>
        <x-seo
            :title="setting('services_meta_title', 'Services')"
            :description="setting('services_meta_description', 'The areas I work in — strategy, operations, technology, systems and problem solving.')"
        />
    </x-slot:seo>

    <section class="border-b border-ink/8 bg-white">
        <div class="shell py-16 sm:py-20 lg:py-24">
            <p class="eyebrow reveal">Services</p>
            <h1 class="display-1 reveal mt-4 max-w-3xl">Practical help for problems that matter.</h1>
            <p class="lede reveal mt-6 max-w-2xl">
                From framing a problem to delivering the system that solves it — here is where I can contribute.
            </p>
        </div>
    </section>

    <section class="section">
        <div class="shell">
            @if ($services->isEmpty())
                <x-empty-state
                    icon="sparkles"
                    title="Services coming soon"
                    message="Service offerings will be published here shortly."
                />
            @else
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($services as $service)
                        <x-service-card :service="$service" class="reveal" />
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <x-cta eyebrow="Get in touch" title="Not sure which applies?" copy="Describe the situation in your own words and I will tell you honestly whether and how I can help." />
</x-layouts.public>
