<section class="section bg-white">
    <div class="shell">
        <div class="grid gap-10 lg:grid-cols-12 lg:gap-16">
            <div class="lg:col-span-4">
                <x-section-heading
                    :eyebrow="$section->eyebrow ?: 'Currently'"
                    :title="$section->title ?: 'What I am working on now'"
                    :subtitle="$section->subtitle"
                    class="reveal"
                />
            </div>

            <div class="lg:col-span-8">
                @if ($currently->isEmpty())
                    <x-empty-state
                        icon="sparkles"
                        title="Nothing shared yet"
                        message="Current activities will be posted here."
                    />
                @else
                    <dl class="reveal grid gap-px overflow-hidden rounded-2xl border border-ink/8 bg-ink/8 sm:grid-cols-2">
                        @foreach ($currently as $item)
                            <div class="bg-white p-6">
                                <dt class="flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-muted">
                                    @if ($item->icon)
                                        <x-icon :name="$item->icon" class="h-4 w-4 text-brand" />
                                    @endif
                                    {{ $item->label }}
                                </dt>
                                <dd class="mt-2 text-sm font-medium leading-relaxed text-ink">{{ $item->value }}</dd>
                            </div>
                        @endforeach
                    </dl>
                @endif
            </div>
        </div>
    </div>
</section>
