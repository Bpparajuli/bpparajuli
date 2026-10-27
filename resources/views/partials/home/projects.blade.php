<section class="section">
    <div class="shell">
        <div class="flex flex-wrap items-end justify-between gap-6">
            <x-section-heading
                :eyebrow="$section->eyebrow ?: 'Selected Work'"
                :title="$section->title ?: 'Featured projects'"
                :subtitle="$section->subtitle"
                class="reveal max-w-2xl"
            />

            <a href="{{ route('projects.index') }}" class="btn-outline btn-sm reveal">
                View all projects
                <x-icon name="arrow-right" class="h-4 w-4" />
            </a>
        </div>

        @if ($projects->isEmpty())
            <div class="mt-12">
                <x-empty-state
                    icon="layers"
                    title="Projects coming soon"
                    message="Featured work will appear here once projects are published."
                />
            </div>
        @else
            <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($projects as $project)
                    <x-project-card :project="$project" class="reveal" />
                @endforeach
            </div>
        @endif
    </div>
</section>
