<x-layouts.admin :title="$item->exists ? 'Edit page' : 'New page'">
    <x-admin.form-shell :title="$item->exists ? 'Edit page' : 'Create page'" :route="$route" :item="$item">
        <form
            method="POST"
            action="{{ $item->exists ? route($route.'.update', $item) : route($route.'.store') }}"
            enctype="multipart/form-data"
            class="space-y-6"
        >
            @csrf
            @if ($item->exists)
                @method('PUT')
            @endif

            <div class="admin-card space-y-5 p-6">
                <x-form.input name="title" label="Title" :value="$item->title" required />

                <div class="grid gap-5 sm:grid-cols-2">
                    <x-form.input name="slug" label="Slug" :value="$item->slug" hint="Leave blank to generate automatically." />
                    <x-form.select name="status" label="Status" :selected="$item->status ?: 'draft'" :options="['draft' => 'Draft', 'published' => 'Published']" />
                </div>

                <x-form.textarea name="excerpt" label="Excerpt" :value="$item->excerpt" rows="3" hint="A short summary shown in listings and search results." />
                <x-form.textarea name="content" label="Content" :value="$item->content" rows="16" hint="Basic HTML is supported (headings, lists, links, images)." />
            </div>

            <div class="admin-card space-y-5 p-6">
                <h3 class="font-display text-base font-bold">Media</h3>
                <x-admin.image-field name="featured_image_file" :current="$item->featured_image" label="Featured image" />
                <x-form.input name="featured_image" label="Or use an image path / URL" :value="$item->featured_image" hint="Leave blank to keep the uploaded image." />
            </div>

            <div class="admin-card space-y-5 p-6">
                <h3 class="font-display text-base font-bold">Layout</h3>
                <div class="grid gap-5 sm:grid-cols-2">
                    <x-form.input name="template" label="Template" :value="$item->template ?: 'default'" hint="Blade template key, e.g. default or full-width." />
                    <x-form.input name="sort_order" type="number" label="Sort order" :value="$item->sort_order ?? 0" />
                </div>
            </div>

            <div class="admin-card space-y-5 p-6">
                <h3 class="font-display text-base font-bold">SEO</h3>
                <x-form.input name="seo_title" label="SEO title" :value="$item->seo_title" />
                <x-form.textarea name="seo_description" label="SEO description" :value="$item->seo_description" rows="2" />
                <x-form.input name="canonical_url" type="url" label="Canonical URL" :value="$item->canonical_url" />
            </div>

            <x-admin.form-actions :route="$route" :item="$item" />
        </form>
    </x-admin.form-shell>
</x-layouts.admin>
