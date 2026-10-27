<x-layouts.public>
    <x-slot:seo>
        <x-seo
            :title="$project->seo_title ?: $project->title"
            :description="$project->seo_description ?: $project->short_description"
            :image="$project->og_image ?: $project->featured_image"
            :canonical="$project->canonical_url"
            type="article"
            :modified-time="$project->updated_at?->toIso8601String()"
        />
    </x-slot:seo>

    @php
        $hero = media_url($project->featured_image);
        $sections = [
            'Overview' => $project->overview,
            'The Problem' => $project->problem,
            'My Approach' => $project->approach,
            'The Solution' => $project->solution,
        ];
    @endphp

    <article>
        <header class="border-b border-ink/8 bg-white">
            <div class="shell py-14 sm:py-20">
                <nav class="text-sm text-muted" aria-label="Breadcrumb">
                    <a href="{{ route('home') }}" class="transition hover:text-brand">Home</a>
                    <span class="mx-2" aria-hidden="true">/</span>
                    <a href="{{ route('projects.index') }}" class="transition hover:text-brand">Projects</a>
                    <span class="mx-2" aria-hidden="true">/</span>
                    <span class="text-ink/60">{{ $project->title }}</span>
                </nav>

                <div class="mt-6 flex flex-wrap items-center gap-3 text-xs">
                    @if ($project->category)
                        <a href="{{ route('projects.index', ['category' => $project->category->slug]) }}" class="chip">{{ $project->category->name }}</a>
                    @endif
                    <span class="badge">{{ $project->statusLabel() }}</span>
                </div>

                <h1 class="display-1 mt-5 max-w-4xl">{{ $project->title }}</h1>

                @if ($project->subtitle)
                    <p class="lede mt-4 max-w-2xl">{{ $project->subtitle }}</p>
                @elseif ($project->short_description)
                    <p class="lede mt-4 max-w-2xl">{{ $project->short_description }}</p>
                @endif

                <dl class="mt-10 grid gap-6 border-t border-ink/8 pt-8 sm:grid-cols-2 lg:grid-cols-4">
                    @if ($project->role)
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-widest text-muted">Role</dt>
                            <dd class="mt-1.5 text-sm font-medium text-ink">{{ $project->role }}</dd>
                        </div>
                    @endif
                    @if ($project->client)
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-widest text-muted">Client</dt>
                            <dd class="mt-1.5 text-sm font-medium text-ink">{{ $project->client }}</dd>
                        </div>
                    @endif
                    @if ($project->timeline)
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-widest text-muted">Timeline</dt>
                            <dd class="mt-1.5 text-sm font-medium text-ink">{{ $project->timeline }}</dd>
                        </div>
                    @endif
                    @if ($project->external_url || $project->github_url)
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-widest text-muted">Links</dt>
                            <dd class="mt-1.5 flex flex-wrap gap-3 text-sm font-medium">
                                @if ($project->external_url)
                                    <a href="{{ $project->external_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1 text-brand hover:underline">
                                        Live <x-icon name="external-link" class="h-3.5 w-3.5" />
                                    </a>
                                @endif
                                @if ($project->github_url)
                                    <a href="{{ $project->github_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1 text-brand hover:underline">
                                        Code <x-icon name="external-link" class="h-3.5 w-3.5" />
                                    </a>
                                @endif
                            </dd>
                        </div>
                    @endif
                </dl>
            </div>
        </header>

        @if ($hero)
            <div class="shell mt-10">
                <img src="{{ $hero }}" alt="{{ $project->title }}" class="w-full rounded-2xl border border-ink/8 shadow-soft" width="1600" height="900">
            </div>
        @endif

        <div class="shell section">
            <div class="grid gap-12 lg:grid-cols-12 lg:gap-16">
                <div class="lg:col-span-8">
                    @foreach ($sections as $heading => $content)
                        @if (filled($content))
                            <section class="mb-12">
                                <h2 class="display-3">{{ $heading }}</h2>
                                <div class="prose-content mt-4">{!! safe_html($content) !!}</div>
                            </section>
                        @endif
                    @endforeach

                    @if (filled($project->result))
                        <section class="rounded-2xl border border-brand/15 bg-brand/5 p-7">
                            <h2 class="display-3">Result</h2>
                            <div class="prose-content mt-4">{!! safe_html($project->result) !!}</div>
                        </section>
                    @endif
                </div>

                <aside class="lg:col-span-4">
                    <div class="sticky top-24 space-y-6">
                        @if (! empty($project->technologies))
                            <div class="card p-6">
                                <h2 class="text-xs font-semibold uppercase tracking-widest text-muted">Technology</h2>
                                <div class="mt-4 flex flex-wrap gap-2">
                                    @foreach ($project->technologies as $tech)
                                        <span class="chip">{{ $tech }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if ($project->client || $project->timeline || $project->role)
                            <div class="card p-6">
                                <h2 class="text-xs font-semibold uppercase tracking-widest text-muted">Project details</h2>
                                <dl class="mt-4 space-y-3 text-sm">
                                    @if ($project->client)
                                        <div class="flex justify-between gap-4">
                                            <dt class="text-muted">Client</dt>
                                            <dd class="text-right font-medium text-ink">{{ $project->client }}</dd>
                                        </div>
                                    @endif
                                    @if ($project->role)
                                        <div class="flex justify-between gap-4">
                                            <dt class="text-muted">Role</dt>
                                            <dd class="text-right font-medium text-ink">{{ $project->role }}</dd>
                                        </div>
                                    @endif
                                    @if ($project->timeline)
                                        <div class="flex justify-between gap-4">
                                            <dt class="text-muted">Timeline</dt>
                                            <dd class="text-right font-medium text-ink">{{ $project->timeline }}</dd>
                                        </div>
                                    @endif
                                    <div class="flex justify-between gap-4">
                                        <dt class="text-muted">Status</dt>
                                        <dd class="text-right font-medium text-ink">{{ $project->statusLabel() }}</dd>
                                    </div>
                                </dl>
                            </div>
                        @endif

                        <a href="{{ route('contact.index') }}" class="btn-brand w-full">
                            Start a project
                            <x-icon name="arrow-right" class="h-4 w-4" />
                        </a>
                    </div>
                </aside>
            </div>
        </div>

        @if ($project->images->isNotEmpty())
            <section class="section bg-white">
                <div class="shell">
                    <h2 class="display-3">Gallery</h2>
                    <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($project->images as $image)
                            <figure class="overflow-hidden rounded-xl border border-ink/8">
                                <img src="{{ $image->url() }}" alt="{{ $image->alt ?: $project->title }}" loading="lazy" decoding="async" class="aspect-[4/3] w-full object-cover">
                                @if ($image->caption)
                                    <figcaption class="bg-white px-4 py-3 text-xs text-muted">{{ $image->caption }}</figcaption>
                                @endif
                            </figure>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    </article>

    @if ($related->isNotEmpty())
        <section class="section">
            <div class="shell">
                <h2 class="display-3 reveal">Related projects</h2>
                <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($related as $item)
                        <x-project-card :project="$item" class="reveal" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <x-cta eyebrow="Contact" title="Working on something similar?" copy="If this looks like the kind of problem you are dealing with, let's talk it through." />
</x-layouts.public>
