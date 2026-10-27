<x-layouts.admin title="Pages">
    <x-admin.page-header
        title="Pages"
        subtitle="Custom content pages published at a clean URL."
        :action-url="route('admin.pages.create')"
        action-label="Add page"
    />

    <div class="admin-card overflow-hidden">
        @if ($items->isEmpty())
            <div class="p-10 text-center text-sm text-muted">No pages yet.</div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="border-b border-ink/10 bg-ink/[0.02] text-xs uppercase tracking-wider text-muted">
                        <tr>
                            <th class="px-4 py-3 font-semibold">Title</th>
                            <th class="px-4 py-3 font-semibold">URL</th>
                            <th class="px-4 py-3 font-semibold">Status</th>
                            <th class="px-4 py-3 text-right font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-ink/5">
                        @foreach ($items as $item)
                            <tr class="transition hover:bg-ink/[0.02]">
                                <td class="px-4 py-3">
                                    <a href="{{ route('admin.pages.edit', $item) }}" class="font-medium text-ink transition hover:text-brand">{{ $item->title }}</a>
                                    @if ($item->is_system)
                                        <span class="ml-2 rounded-full bg-ink/5 px-2 py-0.5 text-[11px] font-medium text-muted">System</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('pages.show', $item->slug) }}" target="_blank" class="text-muted transition hover:text-brand">/{{ $item->slug }}</a>
                                </td>
                                <td class="px-4 py-3">
                                    @if ($item->status === 'published')
                                        <span class="rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-medium text-emerald-700">Published</span>
                                    @else
                                        <span class="rounded-full bg-amber-50 px-2 py-0.5 text-xs font-medium text-amber-700">Draft</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-end gap-4">
                                        <a href="{{ route('admin.pages.edit', $item) }}" class="inline-flex items-center gap-1.5 text-xs font-medium text-ink/70 transition hover:text-brand">
                                            <x-icon name="pencil" class="h-3.5 w-3.5" /> Edit
                                        </a>
                                        <x-admin.delete-form :route="$route" :item="$item" label="page" />
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="border-t border-ink/10 p-4">{{ $items->links() }}</div>
        @endif
    </div>
</x-layouts.admin>
