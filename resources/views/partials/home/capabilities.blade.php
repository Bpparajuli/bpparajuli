<section class="section bg-white">
    <div class="shell">
        <x-section-heading
            :eyebrow="$section->eyebrow ?: 'What I Do'"
            :title="$section->title ?: 'Capabilities across the full stack of a business'"
            :subtitle="$section->subtitle ?: 'From strategy and operations to technology and systems — the work spans the areas that turn ideas into working results.'"
            class="reveal"
        />

        @if ($services->isEmpty())
            <div class="mt-12">
                <x-empty-state
                    icon="sparkles"
                    title="Capabilities coming soon"
                    message="Service areas will be published here shortly."
                />
            </div>
        @else
            <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($services as $service)
                    <x-service-card :service="$service" class="reveal" />
                @endforeach
            </div>

            <div class="reveal mt-10">
                <a href="{{ route('services.index') }}" class="btn-ghost">
                    All services
                    <x-icon name="arrow-right" class="h-4 w-4" />
                </a>
            </div>
        @endif
    </div>
</section>
