@props(['experiences'])

<ol class="relative space-y-10 border-l border-ink/10 pl-6 sm:pl-8">
    @foreach ($experiences as $experience)
        <li class="reveal relative">
            <span class="absolute -left-[calc(1.5rem+5px)] top-1.5 h-2.5 w-2.5 rounded-full bg-brand ring-4 ring-surface sm:-left-[calc(2rem+5px)]" aria-hidden="true"></span>

            <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-muted">
                <span class="font-semibold text-brand">{{ $experience->periodLabel() }}</span>
                @if ($experience->location)
                    <span class="inline-flex items-center gap-1">
                        <x-icon name="map-pin" class="h-3.5 w-3.5" /> {{ $experience->location }}
                    </span>
                @endif
                @if ($experience->is_current)
                    <span class="rounded-full bg-emerald-50 px-2 py-0.5 font-medium text-emerald-700">Current</span>
                @endif
            </div>

            <h3 class="mt-2 font-display text-lg font-bold text-ink">{{ $experience->position }}</h3>

            <p class="text-sm font-medium text-ink/70">
                @if ($experience->organization_url)
                    <a href="{{ $experience->organization_url }}" target="_blank" rel="noopener noreferrer" class="transition hover:text-brand">
                        {{ $experience->organization }}
                    </a>
                @else
                    {{ $experience->organization }}
                @endif
            </p>

            @if ($experience->description)
                <p class="mt-3 text-sm leading-relaxed text-muted">{{ $experience->description }}</p>
            @endif

            @if (! empty($experience->responsibilities))
                <ul class="mt-3 space-y-1.5">
                    @foreach ($experience->responsibilities as $item)
                        <li class="flex gap-2 text-sm leading-relaxed text-ink/75">
                            <span class="mt-[0.45rem] h-1 w-1 shrink-0 rounded-full bg-brand/50"></span>
                            {{ $item }}
                        </li>
                    @endforeach
                </ul>
            @endif

            @if (! empty($experience->achievements))
                <div class="mt-4 rounded-xl bg-brand/5 p-4">
                    <p class="text-xs font-semibold uppercase tracking-widest text-brand">Highlights</p>
                    <ul class="mt-2 space-y-1.5">
                        @foreach ($experience->achievements as $item)
                            <li class="flex gap-2 text-sm leading-relaxed text-ink/75">
                                <x-icon name="check" class="mt-0.5 h-4 w-4 shrink-0 text-brand" />
                                {{ $item }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </li>
    @endforeach
</ol>
