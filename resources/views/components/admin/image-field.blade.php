@props([
    'name' => 'image_file',
    'current' => null,
    'label' => 'Image',
    'hint' => 'JPG, PNG or WebP. Max 4 MB.',
])

@php($url = media_url($current))

<div x-data="{ preview: null }">
    <label for="{{ $name }}" class="admin-label">{{ $label }}</label>

    @if ($url)
        <div class="mb-3 flex items-center gap-4">
            <img
                src="{{ $url }}"
                alt=""
                class="h-20 w-32 rounded-lg border border-ink/10 object-cover"
                :class="preview ? 'opacity-40' : ''"
            >
            <div class="text-xs text-muted">
                <p class="font-medium text-ink">Current image</p>
                <p class="mt-0.5 break-all">{{ $current }}</p>
            </div>
        </div>
    @endif

    <template x-if="preview">
        <img :src="preview" alt="Preview" class="mb-3 h-20 w-32 rounded-lg border border-ink/10 object-cover">
    </template>

    <input
        type="file"
        id="{{ $name }}"
        name="{{ $name }}"
        accept="image/jpeg,image/png,image/webp,image/gif"
        @change="preview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : null"
        class="block w-full rounded-lg border border-ink/15 bg-white px-3 py-2 text-sm text-ink file:mr-3 file:rounded-md file:border-0 file:bg-brand/10 file:px-3 file:py-1.5 file:text-sm file:font-medium file:text-brand"
    >
    <p class="admin-help">{{ $hint }}</p>
</div>
