<x-layouts.admin title="Homepage">
    <x-admin.page-header title="Homepage" subtitle="Tune the section headings and visibility for the landing page." />

    <form method="POST" action="{{ route('admin.homepage.update') }}" class="space-y-4">
        @csrf
        @method('PUT')

        @if ($sections->isEmpty())
            <div class="admin-card p-10 text-center text-sm text-muted">No homepage sections configured.</div>
        @else
            @foreach ($sections as $section)
                <div class="admin-card space-y-5 p-6">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <h3 class="font-display text-base font-bold">{{ $section->name ?: $section->key }}</h3>
                            <p class="text-xs text-muted">Section: {{ $section->key }}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            @if (! $loop->first)
                                <button type="submit" form="reorder-up-{{ $section->id }}" class="admin-btn-light !px-2.5" aria-label="Move up">
                                    <x-icon name="arrow-up" class="h-4 w-4" />
                                </button>
                            @endif
                            @if (! $loop->last)
                                <button type="submit" form="reorder-down-{{ $section->id }}" class="admin-btn-light !px-2.5" aria-label="Move down">
                                    <x-icon name="arrow-down" class="h-4 w-4" />
                                </button>
                            @endif
                            <x-form.checkbox name="sections[{{ $section->id }}][is_enabled]" label="Enabled" :checked="$section->is_enabled" />
                        </div>
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <x-form.input name="sections[{{ $section->id }}][eyebrow]" label="Eyebrow" :value="$section->eyebrow" />
                        <x-form.input name="sections[{{ $section->id }}][title]" label="Title" :value="$section->title" />
                    </div>

                    <x-form.textarea name="sections[{{ $section->id }}][subtitle]" label="Subtitle" :value="$section->subtitle" rows="2" />

                    <input type="hidden" name="sections[{{ $section->id }}][id]" value="{{ $section->id }}">
                </div>
            @endforeach

            <div class="flex items-center gap-3 border-t border-ink/10 pt-5">
                <button type="submit" class="admin-btn-primary">Save changes</button>
            </div>
        @endif
    </form>

    @foreach ($sections as $section)
        @php
            $ids = $sections->pluck('id')->all();
            $index = array_search($section->id, $ids, true);
            $up = $ids;
            if ($index > 0) {
                [$up[$index - 1], $up[$index]] = [$up[$index], $up[$index - 1]];
            }
            $down = $ids;
            if ($index !== false && $index < count($ids) - 1) {
                [$down[$index + 1], $down[$index]] = [$down[$index], $down[$index + 1]];
            }
        @endphp
        @if (! $loop->first)
            <form id="reorder-up-{{ $section->id }}" method="POST" action="{{ route('admin.homepage.reorder') }}" class="hidden">
                @csrf
                @foreach ($up as $id)
                    <input type="hidden" name="order[]" value="{{ $id }}">
                @endforeach
            </form>
        @endif
        @if (! $loop->last)
            <form id="reorder-down-{{ $section->id }}" method="POST" action="{{ route('admin.homepage.reorder') }}" class="hidden">
                @csrf
                @foreach ($down as $id)
                    <input type="hidden" name="order[]" value="{{ $id }}">
                @endforeach
            </form>
        @endif
    @endforeach
</x-layouts.admin>
