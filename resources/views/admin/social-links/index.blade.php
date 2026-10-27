<x-layouts.admin title="Social links">
    <x-admin.page-header
        title="Social links"
        subtitle="Only active links appear on the public site."
        :action-url="route('admin.social-links.create')"
        action-label="Add link"
    />

    <div class="admin-card overflow-hidden">
        @if ($items->isEmpty())
            <div class="p-10 text-center text-sm text-muted">No social links yet.</div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="border-b border-ink/10 bg-ink/[0.02] text-xs uppercase tracking-wider text-muted">
                        <tr>
                            <th class="px-4 py-3 font-semibold">Platform</th>
                            <th class="px-4 py-3 font-semibold">URL</th>
                            <th class="px-4 py-3 font-semibold">Visibility</th>
                            <th class="px-4 py-3 font-semibold">Order</th>
                            <th class="px-4 py-3 text-right font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-ink/5">
                        @foreach ($items as $item)
                            <tr class="transition hover:bg-ink/[0.02]">
                                <td class="px-4 py-3">
                                    <a href="{{ route('admin.social-links.edit', $item) }}" class="inline-flex items-center gap-2 font-medium capitalize text-ink transition hover:text-brand">
                                        <x-icon :name="$item->icon ?: $item->platform" class="h-4 w-4 text-brand" />
                                        {{ $item->label ?: $item->platform }}
                                    </a>
                                </td>
                                <td class="max-w-xs truncate px-4 py-3 text-muted">{{ $item->url }}</td>
                                <td class="px-4 py-3">
                                    @if ($item->is_active)
                                        <span class="rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-medium text-emerald-700">Active</span>
                                    @else
                                        <span class="rounded-full bg-ink/5 px-2 py-0.5 text-xs text-muted">Hidden</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-muted">{{ $item->sort_order }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-end gap-4">
                                        <a href="{{ route('admin.social-links.edit', $item) }}" class="inline-flex items-center gap-1.5 text-xs font-medium text-ink/70 transition hover:text-brand">
                                            <x-icon name="pencil" class="h-3.5 w-3.5" /> Edit
                                        </a>
                                        <x-admin.delete-form :route="$route" :item="$item" label="link" />
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
