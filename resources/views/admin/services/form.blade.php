<x-layouts.admin :title="$item->exists ? 'Edit service' : 'New service'">
    <x-admin.form-shell :title="$item->exists ? 'Edit service' : 'Create service'" :route="$route" :item="$item">
        <form
            method="POST"
            action="{{ $item->exists ? route($route.'.update', $item) : route($route.'.store') }}"
            class="space-y-6"
        >
            @csrf
            @if ($item->exists)
                @method('PUT')
            @endif

            <div class="admin-card space-y-5 p-6">
                <x-form.input name="title" label="Title" :value="$item->title" required />
                <x-form.input name="slug" label="Slug" :value="$item->slug" hint="Leave blank to generate automatically." />
                <x-form.textarea name="short_description" label="Short description" :value="$item->short_description" rows="3" hint="Shown on service cards." />
                <x-form.textarea name="full_description" label="Full description" :value="$item->full_description" rows="8" hint="Basic HTML is supported." />
                <x-form.input name="icon" label="Icon" :value="$item->icon" hint="e.g. briefcase, cpu, chart, cog, lightbulb, users" />
            </div>

            <div class="admin-card space-y-5 p-6">
                <h3 class="font-display text-base font-bold">Display</h3>
                <div class="grid gap-5 sm:grid-cols-2">
                    <x-form.input name="sort_order" type="number" label="Sort order" :value="$item->sort_order ?? 0" />
                    <div class="space-y-3 pt-6">
                        <x-form.checkbox name="is_featured" label="Featured" :checked="$item->is_featured" />
                        <x-form.checkbox name="is_active" label="Active" :checked="$item->is_active ?? true" />
                    </div>
                </div>
            </div>

            <x-admin.form-actions :route="$route" :item="$item" />
        </form>
    </x-admin.form-shell>
</x-layouts.admin>
