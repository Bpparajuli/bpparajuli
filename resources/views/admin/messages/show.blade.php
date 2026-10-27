<x-layouts.admin title="Message">
    <div class="mx-auto max-w-3xl">
        <div class="mb-6">
            <a href="{{ route('admin.messages.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-muted transition hover:text-brand">
                <x-icon name="arrow-left" class="h-4 w-4" />
                Back to messages
            </a>
        </div>

        <div class="admin-card overflow-hidden">
            <div class="flex flex-wrap items-start justify-between gap-4 border-b border-ink/10 p-6">
                <div>
                    <h2 class="font-display text-lg font-bold text-ink">{{ $message->subject ?: 'No subject' }}</h2>
                    <p class="mt-1 text-sm text-muted">
                        From <span class="font-medium text-ink">{{ $message->name }}</span>
                        &lt;<a href="mailto:{{ $message->email }}" class="text-brand">{{ $message->email }}</a>&gt;
                    </p>
                    @if ($message->phone)
                        <p class="text-sm text-muted">Phone: {{ $message->phone }}</p>
                    @endif
                </div>
                <span class="rounded-full bg-ink/5 px-2 py-0.5 text-xs font-medium capitalize text-muted">{{ $message->statusLabel() }}</span>
            </div>

            <div class="whitespace-pre-line p-6 text-sm leading-relaxed text-ink">{{ $message->message }}</div>

            <div class="border-t border-ink/10 px-6 py-4 text-xs text-muted">
                Received {{ $message->created_at?->format('M j, Y \a\t H:i') }}
                @if ($message->ip_address)
                    · IP {{ $message->ip_address }}
                @endif
            </div>
        </div>

        <div class="mt-6 grid gap-4 sm:grid-cols-2">
            <div class="admin-card p-5">
                <h3 class="font-display text-base font-bold">Update status</h3>
                <form method="POST" action="{{ route('admin.messages.status', $message) }}" class="mt-4 flex items-end gap-3">
                    @csrf
                    @method('PATCH')
                    <div class="flex-1">
                        <x-form.select name="status" label="Status" :selected="$message->status" :options="\App\Models\ContactMessage::STATUSES" />
                    </div>
                    <button type="submit" class="admin-btn-primary">Save</button>
                </form>
            </div>

            <div class="admin-card p-5">
                <h3 class="font-display text-base font-bold">Actions</h3>
                <div class="mt-4 flex flex-wrap gap-2">
                    <a href="mailto:{{ $message->email }}" class="admin-btn-light">
                        <x-icon name="mail" class="h-4 w-4" /> Reply
                    </a>
                    <x-admin.delete-form :route="'admin.messages'" :item="$message" label="message" />
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
