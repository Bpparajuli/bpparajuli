<x-layouts.admin title="Media">
    <x-admin.page-header title="Media" subtitle="Images and files uploaded to the library." />

    <div class="admin-card p-6">
        <form
            x-data="{ uploading: false }"
            @submit.prevent="
                uploading = true;
                let fd = new FormData($event.target);
                fetch($event.target.action, {
                    method: 'POST',
                    body: fd,
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content, 'Accept': 'application/json' }
                })
                .then(r => r.json())
                .then(d => { if (d.url) { window.location.reload(); } else { alert(d.message || 'Upload failed'); } })
                .catch(() => alert('Upload failed'))
                .finally(() => uploading = false);
            "
            action="{{ route('admin.media.upload') }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf
            <div class="flex flex-wrap items-end gap-3">
                <div class="flex-1 min-w-[220px]">
                    <label for="file" class="admin-label">Upload file</label>
                    <input type="file" id="file" name="file" required
                           class="block w-full rounded-lg border border-ink/15 bg-white px-3 py-2 text-sm text-ink file:mr-3 file:rounded-md file:border-0 file:bg-brand/10 file:px-3 file:py-1.5 file:text-sm file:font-medium file:text-brand">
                </div>
                <div>
                    <label for="folder" class="admin-label">Folder</label>
                    <input type="text" id="folder" name="folder" placeholder="uploads" value="uploads"
                           class="form-input w-40">
                </div>
                <button type="submit" class="admin-btn-primary" :disabled="uploading">
                    <x-icon name="upload" class="h-4 w-4" />
                    <span x-text="uploading ? 'Uploading…' : 'Upload'"></span>
                </button>
            </div>
        </form>
    </div>

    <div class="mt-6 flex flex-wrap items-center gap-3">
        <form method="GET" action="{{ route('admin.media.index') }}" class="flex flex-1 items-center gap-2">
            <input type="search" name="q" value="{{ request('q') }}" placeholder="Search files…" class="form-input max-w-xs">
            <select name="folder" class="form-input w-auto">
                <option value="">All folders</option>
                @foreach ($folders as $folder)
                    <option value="{{ $folder }}" @selected(request('folder') === $folder)>{{ $folder }}</option>
                @endforeach
            </select>
            <select name="type" class="form-input w-auto">
                <option value="">All types</option>
                <option value="image" @selected(request('type') === 'image')>Images</option>
            </select>
            <button type="submit" class="admin-btn-light">Filter</button>
        </form>
    </div>

    @if ($items->isEmpty())
        <div class="admin-card mt-6 p-10 text-center text-sm text-muted">No files found.</div>
    @else
        <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($items as $item)
                <div class="admin-card overflow-hidden">
                    <div class="relative aspect-video w-full bg-ink/[0.04]">
                        @if ($item->isImage())
                            <img src="{{ $item->url() }}" alt="{{ $item->alt_text }}" class="h-full w-full object-cover">
                        @else
                            <div class="flex h-full w-full items-center justify-center text-muted">
                                <x-icon name="file-text" class="h-8 w-8" />
                            </div>
                        @endif
                    </div>
                    <div class="p-4">
                        <p class="truncate text-sm font-medium text-ink" title="{{ $item->file_name }}">{{ $item->name }}</p>
                        <p class="mt-0.5 text-xs text-muted">{{ $item->humanSize() }} · {{ $item->folder ?: 'root' }}</p>

                        <details class="mt-3">
                            <summary class="cursor-pointer text-xs font-medium text-brand">Edit</summary>
                            <form method="POST" action="{{ route('admin.media.update', $item) }}" class="mt-3 space-y-3">
                                @csrf
                                @method('PUT')
                                <x-form.input name="name" label="Name" :value="$item->name" />
                                <x-form.input name="alt_text" label="Alt text" :value="$item->alt_text" />
                                <button type="submit" class="admin-btn-light w-full">Save</button>
                            </form>
                        </details>

                        <div class="mt-3 border-t border-ink/10 pt-3">
                            <x-admin.delete-form :route="'admin.media'" :item="$item" label="file" />
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-6">{{ $items->links() }}</div>
    @endif
</x-layouts.admin>
