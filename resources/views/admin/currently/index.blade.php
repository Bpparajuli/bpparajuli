<x-layouts.admin title="Currently">
    <x-admin.page-header
        title="Currently"
        subtitle="Short, current status items for the homepage 'Currently' section."
        :action-url="route('admin.currently.create')"
        action-label="Add item"
    />

    <div class="admin-card overflow-hidden">
        @if ($items->isEmpty())
            <div class="p-10 text-center text-sm text-muted">No items yet.</div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="border-b border-ink/10 bg-ink/[0.02] text-xs uppercase tracking-wider text-muted">
                        <tr>
                            <th class="px-4 py-3 font-semibold">Label</th>
                            <th class="px-4 py-3 font-semibold">Value</th>
                            <th class="px-4 py-3 font-semibold">Visibility</th>
                            <th class="px-4 py-3 font-semibold">Order</th>
                            <th class="px-4 py-3 text-right font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-ink/5">
                        @foreach ($items as $item)
                            <tr class="transition hover:bg-ink/[0.02]">
                                <td class="px-4 py-3">
                                    <a href="{{ route('admin.currently.edit', $item) }}" class="inline-flex items-center gap-2 font-medium text-ink transition hover:text-brand">
                                        <x-icon :name="$item->icon ?: 'sparkles'" class="h-4 w-4 text-brand" />
                                        {{ $item->label }}
                                    </a>
                                </td>
                                <td class="max-w-md px-4 py-3 text-muted">{{ \Illuminate\Support\Str::limit($item->value, 80) }}</td>
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
                                        <a href="{{ route('admin.currently.edit', $item) }}" class="inline-flex items-center gap-1.5 text-xs font-medium text-ink/70 transition hover:text-brand">
                                            <x-icon name="pencil" class="h-3.5 w-3.5" /> Edit
                                        </a>
                                        <x-admin.delete-form :route="$route" :item="$item" label="item" />
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
