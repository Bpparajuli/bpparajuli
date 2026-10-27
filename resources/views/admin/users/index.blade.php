<x-layouts.admin title="Users">
    <x-admin.page-header
        title="Users"
        subtitle="People who can sign in to the admin area."
        :action-url="route('admin.users.create')"
        action-label="Add user"
    />

    <div class="admin-card overflow-hidden">
        @if ($items->isEmpty())
            <div class="p-10 text-center text-sm text-muted">No users yet.</div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="border-b border-ink/10 bg-ink/[0.02] text-xs uppercase tracking-wider text-muted">
                        <tr>
                            <th class="px-4 py-3 font-semibold">Name</th>
                            <th class="px-4 py-3 font-semibold">Email</th>
                            <th class="px-4 py-3 font-semibold">Role</th>
                            <th class="px-4 py-3 font-semibold">Joined</th>
                            <th class="px-4 py-3 text-right font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-ink/5">
                        @foreach ($items as $item)
                            <tr class="transition hover:bg-ink/[0.02]">
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        @if ($item->avatar)
                                            <img src="{{ media_url($item->avatar) }}" alt="" class="h-8 w-8 rounded-full object-cover">
                                        @else
                                            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-brand/10 text-xs font-semibold text-brand">{{ $item->initials() }}</span>
                                        @endif
                                        <a href="{{ route('admin.users.edit', $item) }}" class="font-medium text-ink transition hover:text-brand">{{ $item->name }}</a>
                                    </div>
                                    @if ($item->job_title)
                                        <span class="block pl-11 text-xs text-muted">{{ $item->job_title }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-muted">{{ $item->email }}</td>
                                <td class="px-4 py-3">
                                    @if ($item->is_admin)
                                        <span class="rounded-full bg-brand/10 px-2 py-0.5 text-xs font-medium text-brand">Admin</span>
                                    @else
                                        <span class="rounded-full bg-ink/5 px-2 py-0.5 text-xs text-muted">Editor</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-muted">{{ $item->created_at?->format('M j, Y') }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-end gap-4">
                                        <a href="{{ route('admin.users.edit', $item) }}" class="inline-flex items-center gap-1.5 text-xs font-medium text-ink/70 transition hover:text-brand">
                                            <x-icon name="pencil" class="h-3.5 w-3.5" /> Edit
                                        </a>
                                        @unless ($item->is(auth()->user()))
                                            <x-admin.delete-form :route="$route" :item="$item" label="user" />
                                        @endunless
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
