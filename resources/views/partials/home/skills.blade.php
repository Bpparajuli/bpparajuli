<section class="section bg-white">
    <div class="shell">
        <x-section-heading
            :eyebrow="$section->eyebrow ?: 'Skills'"
            :title="$section->title ?: 'What I work with'"
            :subtitle="$section->subtitle ?: 'Capabilities built through hands-on work across business, technology and operations.'"
            class="reveal"
        />

        @if ($skillCategories->isEmpty())
            <div class="mt-12">
                <x-empty-state
                    icon="cpu"
                    title="Skills coming soon"
                    message="Skill groups will be listed here once added."
                />
            </div>
        @else
            <div class="mt-12 grid gap-8 lg:grid-cols-2">
                @foreach ($skillCategories as $category)
                    <div class="reveal">
                        <div class="flex items-center gap-3">
                            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-brand/10 text-brand">
                                <x-icon :name="$category->icon ?: 'cpu'" class="h-5 w-5" />
                            </span>
                            <h3 class="font-display text-lg font-bold">{{ $category->name }}</h3>
                        </div>

                        @if ($category->description)
                            <p class="mt-2 text-sm leading-relaxed text-muted">{{ $category->description }}</p>
                        @endif

                        <div class="mt-4 space-y-2.5">
                            @foreach ($category->skills as $skill)
                                <x-skill-card :skill="$skill" />
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
