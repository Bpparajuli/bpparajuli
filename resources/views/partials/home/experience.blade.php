<section class="section">
    <div class="shell">
        <div class="flex flex-wrap items-end justify-between gap-6">
            <x-section-heading
                :eyebrow="$section->eyebrow ?: 'Experience'"
                :title="$section->title ?: 'Where I have worked'"
                :subtitle="$section->subtitle"
                class="reveal max-w-2xl"
            />

            <a href="{{ route('about') }}" class="btn-outline btn-sm reveal">
                Full background
                <x-icon name="arrow-right" class="h-4 w-4" />
            </a>
        </div>

        @if ($experiences->isEmpty())
            <div class="mt-12">
                <x-empty-state
                    icon="briefcase"
                    title="Experience coming soon"
                    message="Professional history will be published here."
                />
            </div>
        @else
            <div class="mt-12">
                <x-timeline :experiences="$experiences" />
            </div>
        @endif
    </div>
</section>
