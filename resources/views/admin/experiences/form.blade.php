<x-layouts.admin :title="$item->exists ? 'Edit experience' : 'New experience'">
    <x-admin.form-shell :title="$item->exists ? 'Edit experience' : 'Create experience'" :route="$route" :item="$item">
        <form method="POST" action="{{ $item->exists ? route($route.'.update', $item) : route($route.'.store') }}" class="space-y-6">
            @csrf
            @if ($item->exists)
                @method('PUT')
            @endif

            <div class="admin-card space-y-5 p-6">
                <div class="grid gap-5 sm:grid-cols-2">
                    <x-form.input name="position" label="Position" :value="$item->position" required />
                    <x-form.input name="organization" label="Organisation" :value="$item->organization" required />
                </div>
                <div class="grid gap-5 sm:grid-cols-3">
                    <x-form.input name="location" label="Location" :value="$item->location" />
                    <x-form.input name="start_date" type="date" label="Start date" :value="$item->start_date?->format('Y-m-d')" />
                    <x-form.input name="end_date" type="date" label="End date" :value="$item->end_date?->format('Y-m-d')" />
                </div>
                <x-form.input name="organization_url" type="url" label="Organisation website" :value="$item->organization_url" />
                <x-form.checkbox name="is_current" label="Current role" :checked="$item->is_current" />
            </div>

            <div class="admin-card space-y-5 p-6">
                <h3 class="font-display text-base font-bold">Details</h3>
                <x-form.textarea name="description" label="Description" :value="$item->description" rows="4" />
                <x-form.textarea
                    name="responsibilities"
                    label="Responsibilities"
                    :value="is_array($item->responsibilities) ? implode(PHP_EOL, $item->responsibilities) : ''"
                    rows="5"
                    hint="One responsibility per line."
                />
                <x-form.textarea
                    name="achievements"
                    label="Highlights / achievements"
                    :value="is_array($item->achievements) ? implode(PHP_EOL, $item->achievements) : ''"
                    rows="5"
                    hint="One highlight per line. Use only factual, verifiable results."
                />
            </div>

            <div class="admin-card space-y-5 p-6">
                <div class="grid gap-5 sm:grid-cols-2">
                    <x-form.input name="sort_order" type="number" label="Sort order" :value="$item->sort_order ?? 0" />
                    <div class="pt-6">
                        <x-form.checkbox name="is_active" label="Active" :checked="$item->is_active ?? true" />
                    </div>
                </div>
            </div>

            <x-admin.form-actions :route="$route" :item="$item" />
        </form>
    </x-admin.form-shell>
</x-layouts.admin>
