@php
    $steps = $section->setting('steps') ?: [
        ['title' => 'Understand', 'description' => 'Start with the real problem, the constraints, and the people involved before reaching for a solution.'],
        ['title' => 'Structure', 'description' => 'Turn ambiguity into a clear model — priorities, sequence, and what success actually looks like.'],
        ['title' => 'Build', 'description' => 'Execute with the simplest tooling that works, shipping in iterations rather than one large bet.'],
        ['title' => 'Improve', 'description' => 'Measure what happened, learn from it, and refine the system so it keeps performing.'],
    ];
@endphp

<section class="section bg-ink text-white">
    <div class="shell">
        <x-section-heading
            :eyebrow="$section->eyebrow ?: 'How I Think'"
            :title="$section->title ?: 'How I approach problems'"
            :subtitle="$section->subtitle ?: 'A repeatable way of working that keeps projects grounded in reality and moving toward a measurable outcome.'"
            class="reveal [&_.eyebrow]:text-white/60 [&_.display-2]:!text-white [&_.lede]:text-white/60"
        />

        <ol class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($steps as $index => $step)
                <li class="reveal relative rounded-2xl border border-white/10 bg-white/5 p-6">
                    <span class="font-display text-3xl font-extrabold text-white/25">
                        {{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}
                    </span>
                    <h3 class="mt-4 font-display text-lg font-bold !text-white">{{ $step['title'] ?? '' }}</h3>
                    <p class="mt-2 text-sm leading-relaxed text-white/60">{{ $step['description'] ?? '' }}</p>
                </li>
            @endforeach
        </ol>
    </div>
</section>
