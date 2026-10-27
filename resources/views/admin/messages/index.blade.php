<x-layouts.admin title="Messages">
    <x-admin.page-header title="Messages" subtitle="Inquiries from the contact form." />

    <div class="mb-5 flex flex-wrap gap-2">
        @php
            $tabs = [
                '' => 'All',
                'unread' => 'Unread',
                'read' => 'Read',
                'replied' => 'Replied',
                'archived' => 'Archived',
            ];
        @endphp
        @foreach ($tabs as $status => $label)
            <a
                href="{{ route('admin.messages.index', $status ? ['status' => $status] : []) }}"
                @class([
                    'admin-btn-light',
                    'is-active' => ($activeStatus ?: '') === $status,
                ])
            >
                {{ $label }}
                <span class="ml-1 text-xs text-muted">{{ $counts[$status === '' ? 'all' : $status] }}</span>
            </a>
        @endforeach

        <form method="GET" action="{{ route('admin.messages.index') }}" class="ml-auto flex items-center gap-2">
            <input type="search" name="q" value="{{ request('q') }}" placeholder="Search…" class="form-input max-w-xs">
            @if ($activeStatus)
                <input type="hidden" name="status" value="{{ $activeStatus }}">
            @endif
            <button type="submit" class="admin-btn-light">Search</button>
        </form>
    </div>

    <div class="admin-card overflow-hidden">
        @if ($items->isEmpty())
            <div class="p-10 text-center text-sm text-muted">No messages.</div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="border-b border-ink/10 bg-ink/[0.02] text-xs uppercase tracking-wider text-muted">
                        <tr>
                            <th class="px-4 py-3 font-semibold">From</th>
                            <th class="px-4 py-3 font-semibold">Subject</th>
                            <th class="px-4 py-3 font-semibold">Status</th>
                            <th class="px-4 py-3 font-semibold">Received</th>
                            <th class="px-4 py-3 text-right font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-ink/5">
                        @foreach ($items as $item)
                            <tr class="transition hover:bg-ink/[0.02]">
                                <td class="px-4 py-3">
                                    <a href="{{ route('admin.messages.show', $item) }}" class="{{ $item->status === 'unread' ? 'font-semibold text-ink' : 'font-medium text-ink' }} transition hover:text-brand">
                                        {{ $item->name }}
                                    </a>
                                    <span class="block text-xs text-muted">{{ $item->email }}</span>
                                </td>
                                <td class="max-w-xs truncate px-4 py-3 text-muted">{{ $item->subject ?: '—' }}</td>
                                <td class="px-4 py-3">
                                    @php
                                        $badge = match ($item->status) {
                                            'replied' => 'bg-emerald-50 text-emerald-700',
                                            'read' => 'bg-sky-50 text-sky-700',
                                            'archived' => 'bg-ink/10 text-ink/60',
                                            default => 'bg-brand/10 text-brand',
                                        };
                                    @endphp
                                    <span class="rounded-full px-2 py-0.5 text-xs font-medium capitalize {{ $badge }}">{{ $item->status }}</span>
                                </td>
                                <td class="px-4 py-3 text-muted">{{ $item->created_at?->format('M j, Y H:i') }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-end gap-4">
                                        <a href="{{ route('admin.messages.show', $item) }}" class="inline-flex items-center gap-1.5 text-xs font-medium text-ink/70 transition hover:text-brand">
                                            <x-icon name="eye" class="h-3.5 w-3.5" /> View
                                        </a>
                                        <x-admin.delete-form :route="'admin.messages'" :item="$item" label="message" />
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
