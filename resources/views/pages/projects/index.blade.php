<x-layouts.public>
    <x-slot:seo>
        <x-seo
            :title="setting('projects_meta_title', 'Projects')"
            :description="setting('projects_meta_description', 'Selected projects and case studies across business, technology and operations.')"
        />
    </x-slot:seo>

    <section class="border-b border-ink/8 bg-white">
        <div class="shell py-16 sm:py-20">
            <p class="eyebrow reveal">Projects</p>
            <h1 class="display-1 reveal mt-4 max-w-3xl">Work that solves a real problem.</h1>
            <p class="lede reveal mt-6 max-w-2xl">
                Each project is documented as a case study — the problem, the approach, the solution, and what came out of it.
            </p>
        </div>
    </section>

    <section class="section">
        <div class="shell">
            <form method="GET" action="{{ route('projects.index') }}" class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex flex-wrap gap-2">
                    <a
                        href="{{ route('projects.index', array_filter(['q' => $search ?: null])) }}"
                        class="rounded-full px-4 py-2 text-sm font-medium transition {{ ! $activeCategory ? 'bg-ink text-white' : 'bg-white text-ink/70 hover:bg-ink/5' }}"
                    >
                        All
                    </a>
                    @foreach ($categories as $category)
                        <a
                            href="{{ route('projects.index', array_filter(['category' => $category->slug, 'q' => $search ?: null])) }}"
                            class="rounded-full px-4 py-2 text-sm font-medium transition {{ $activeCategory?->id === $category->id ? 'bg-ink text-white' : 'bg-white text-ink/70 hover:bg-ink/5' }}"
                        >
                            {{ $category->name }}
                            <span class="ml-1 text-xs opacity-60">{{ $category->projects_count }}</span>
                        </a>
                    @endforeach
                </div>

                <div class="relative w-full lg:w-72">
                    <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-muted">
                        <x-icon name="search" class="h-4 w-4" />
                    </span>
                    <input
                        type="search"
                        name="q"
                        value="{{ $search }}"
                        placeholder="Search projects"
                        aria-label="Search projects"
                        class="admin-input pl-9"
                    >
                    @if ($activeCategory)
                        <input type="hidden" name="category" value="{{ $activeCategory->slug }}">
                    @endif
                </div>
            </form>

            @if ($projects->isEmpty())
                <div class="mt-12">
                    <x-empty-state
                        icon="search"
                        title="No projects found"
                        message="Try a different search term or category."
                    >
                        <a href="{{ route('projects.index') }}" class="btn-outline btn-sm">Clear filters</a>
                    </x-empty-state>
                </div>
            @else
                <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($projects as $project)
                        <x-project-card :project="$project" class="reveal" />
                    @endforeach
                </div>

                <div class="mt-12">
                    {{ $projects->links() }}
                </div>
            @endif
        </div>
    </section>
</x-layouts.public>
