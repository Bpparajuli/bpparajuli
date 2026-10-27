<x-layouts.admin :title="$item->exists ? 'Edit project' : 'New project'">
    <x-admin.form-shell :title="$item->exists ? 'Edit project' : 'Create project'" :route="$route" :item="$item">
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
                    <x-form.select
                        name="project_category_id"
                        label="Category"
                        :selected="$item->project_category_id"
                        placeholder="No category"
                        :options="$categories->pluck('name', 'id')"
                    />
                </div>

                <x-form.input name="subtitle" label="Subtitle" :value="$item->subtitle" />
                <x-form.textarea name="short_description" label="Short description" :value="$item->short_description" rows="3" hint="Shown on project cards and listings." />
            </div>

            <div class="admin-card space-y-5 p-6">
                <h3 class="font-display text-base font-bold">Case study</h3>
                <x-form.textarea name="overview" label="Overview" :value="$item->overview" rows="4" />
                <x-form.textarea name="problem" label="The Problem" :value="$item->problem" rows="4" />
                <x-form.textarea name="approach" label="My Approach" :value="$item->approach" rows="4" />
                <x-form.textarea name="solution" label="The Solution" :value="$item->solution" rows="4" />
                <x-form.textarea name="result" label="Result" :value="$item->result" rows="4" hint="Optional. Leave blank to hide the results section." />
            </div>

            <div class="admin-card space-y-5 p-6">
                <h3 class="font-display text-base font-bold">Details</h3>
                <div class="grid gap-5 sm:grid-cols-3">
                    <x-form.input name="role" label="Role" :value="$item->role" />
                    <x-form.input name="client" label="Client / company" :value="$item->client" />
                    <x-form.input name="timeline" label="Timeline" :value="$item->timeline" />
                </div>

                <x-form.textarea
                    name="technologies"
                    label="Technology"
                    :value="is_array($item->technologies) ? implode(', ', $item->technologies) : ''"
                    rows="2"
                    hint="Separate with commas or new lines."
                />

                <div class="grid gap-5 sm:grid-cols-3">
                    <x-form.input name="external_url" type="url" label="External URL" :value="$item->external_url" />
                    <x-form.input name="github_url" type="url" label="GitHub URL" :value="$item->github_url" />
                    <x-form.select
                        name="status"
                        label="Status"
                        :selected="$item->status ?: 'completed'"
                        :options="\App\Models\Project::STATUSES"
                    />
                </div>
            </div>

            <div class="admin-card space-y-5 p-6">
                <h3 class="font-display text-base font-bold">Media</h3>
                <x-admin.image-field name="featured_image_file" :current="$item->featured_image" label="Featured image" />

                <div>
                    <label for="gallery" class="admin-label">Gallery</label>
                    <input type="file" id="gallery" name="gallery[]" multiple accept="image/*"
                           class="block w-full rounded-lg border border-ink/15 bg-white px-3 py-2 text-sm text-ink file:mr-3 file:rounded-md file:border-0 file:bg-brand/10 file:px-3 file:py-1.5 file:text-sm file:font-medium file:text-brand">
                    <p class="admin-help">Multiple images allowed. Uploading adds to the existing gallery.</p>
                </div>

                @if ($item->exists && $item->images->isNotEmpty())
                    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
                        @foreach ($item->images as $image)
                            <div class="group relative overflow-hidden rounded-lg border border-ink/10">
                                <img src="{{ $image->url() }}" alt="{{ $image->alt }}" class="aspect-square w-full object-cover">
                                <form method="POST" action="{{ route('admin.projects.images.destroy', [$item, $image]) }}"
                                      class="absolute inset-x-0 bottom-0 bg-ink/70 p-2 text-center opacity-0 transition group-hover:opacity-100"
                                      onsubmit="return confirm('Remove this image?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs font-medium text-white">Remove</button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="admin-card space-y-5 p-6">
                <h3 class="font-display text-base font-bold">Publishing</h3>
                <div class="grid gap-5 sm:grid-cols-2">
                    <x-form.input name="sort_order" type="number" label="Sort order" :value="$item->sort_order ?? 0" />
                    <div class="space-y-3 pt-6">
                        <x-form.checkbox name="is_featured" label="Featured" :checked="$item->is_featured" hint="Show on the homepage." />
                        <x-form.checkbox name="is_active" label="Active" :checked="$item->is_active ?? true" hint="Visible on the public site." />
                    </div>
                </div>
            </div>

            <div class="admin-card space-y-5 p-6">
                <h3 class="font-display text-base font-bold">SEO</h3>
                <x-form.input name="seo_title" label="SEO title" :value="$item->seo_title" />
                <x-form.textarea name="seo_description" label="SEO description" :value="$item->seo_description" rows="2" />
            </div>

            <x-admin.form-actions :route="$route" :item="$item" />
        </form>
    </x-admin.form-shell>
</x-layouts.admin>
