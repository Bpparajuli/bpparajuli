<x-layouts.admin title="Projects">
    <x-admin.page-header
        title="Projects"
        subtitle="Case studies shown on the public site."
        :action-url="route('admin.projects.create')"
        action-label="Add project"
    />

    <div class="admin-card overflow-hidden">
        @if ($items->isEmpty())
            <div class="p-10 text-center text-sm text-muted">No projects yet. Add your first project to get started.</div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="border-b border-ink/10 bg-ink/[0.02] text-xs uppercase tracking-wider text-muted">
                        <tr>
                            <th class="px-4 py-3 font-semibold">Title</th>
                            <th class="px-4 py-3 font-semibold">Category</th>
                            <th class="px-4 py-3 font-semibold">Status</th>
                            <th class="px-4 py-3 font-semibold">Featured</th>
                            <th class="px-4 py-3 font-semibold">Order</th>
                            <th class="px-4 py-3 text-right font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-ink/5">
                        @foreach ($items as $item)
                            <tr class="transition hover:bg-ink/[0.02]">
                                <td class="px-4 py-3">
                                    <a href="{{ route($route.'.edit', $item) }}" class="font-medium text-ink transition hover:text-brand">{{ $item->title }}</a>
                                    <span class="block text-xs text-muted">{{ $item->slug }}</span>
                                </td>
                                <td class="px-4 py-3 text-muted">{{ $item->category?->name ?: '—' }}</td>
                                <td class="px-4 py-3">
                                    <span class="rounded-full bg-ink/5 px-2 py-0.5 text-xs font-medium text-ink/70">{{ $item->statusLabel() }}</span>
                                </td>
                                <td class="px-4 py-3">
                                    @if ($item->is_featured)
                                        <span class="text-brand"><x-icon name="star" class="h-4 w-4" /></span>
                                    @else
                                        <span class="text-muted/40">—</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-muted">{{ $item->sort_order }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-end gap-4">
                                        <a href="{{ route($route.'.edit', $item) }}" class="inline-flex items-center gap-1.5 text-xs font-medium text-ink/70 transition hover:text-brand">
                                            <x-icon name="pencil" class="h-3.5 w-3.5" /> Edit
                                        </a>
                                        <x-admin.delete-form :route="$route" :item="$item" label="project" />
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="border-t border-ink/10 p-4">
                {{ $items->links() }}
            </div>
        @endif
    </div>
</x-layouts.admin>
