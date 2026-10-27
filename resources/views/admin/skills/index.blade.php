<x-layouts.admin title="Skills">
    <x-admin.page-header
        title="Skills"
        subtitle="Capabilities and tools shown on the homepage and about page."
        :action-url="route('admin.skills.create')"
        action-label="Add skill"
    />

    <div class="admin-card overflow-hidden">
        @if ($items->isEmpty())
            <div class="p-10 text-center text-sm text-muted">No skills yet.</div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="border-b border-ink/10 bg-ink/[0.02] text-xs uppercase tracking-wider text-muted">
                        <tr>
                            <th class="px-4 py-3 font-semibold">Skill</th>
                            <th class="px-4 py-3 font-semibold">Category</th>
                            <th class="px-4 py-3 font-semibold">Years</th>
                            <th class="px-4 py-3 font-semibold">Featured</th>
                            <th class="px-4 py-3 font-semibold">Visibility</th>
                            <th class="px-4 py-3 font-semibold">Order</th>
                            <th class="px-4 py-3 text-right font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-ink/5">
                        @foreach ($items as $item)
                            <tr class="transition hover:bg-ink/[0.02]">
                                <td class="px-4 py-3 font-medium text-ink">
                                    <a href="{{ route('admin.skills.edit', $item) }}" class="transition hover:text-brand">{{ $item->name }}</a>
                                </td>
                                <td class="px-4 py-3 text-muted">{{ $item->category?->name ?: '—' }}</td>
                                <td class="px-4 py-3 text-muted">{{ $item->years_experience ?: '—' }}</td>
                                <td class="px-4 py-3 text-muted">{{ $item->is_featured ? 'Yes' : '—' }}</td>
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
                                        <a href="{{ route('admin.skills.edit', $item) }}" class="inline-flex items-center gap-1.5 text-xs font-medium text-ink/70 transition hover:text-brand">
                                            <x-icon name="pencil" class="h-3.5 w-3.5" /> Edit
                                        </a>
                                        <x-admin.delete-form :route="$route" :item="$item" label="skill" />
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
