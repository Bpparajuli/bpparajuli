<x-layouts.admin title="Dashboard">
    @php
        $cards = [
            ['label' => 'Projects', 'value' => $stats['projects'], 'icon' => 'layers', 'route' => route('admin.projects.index')],
            ['label' => 'Skills', 'value' => $stats['skills'], 'icon' => 'cpu', 'route' => route('admin.skills.index')],
            ['label' => 'Experience', 'value' => $stats['experiences'], 'icon' => 'briefcase', 'route' => route('admin.experiences.index')],
            ['label' => 'Unread messages', 'value' => $stats['unread'], 'icon' => 'message', 'route' => route('admin.messages.index', ['status' => 'unread'])],
        ];

        $quickActions = [
            ['label' => 'Add Project', 'route' => route('admin.projects.create'), 'icon' => 'layers'],
            ['label' => 'Add Service', 'route' => route('admin.services.create'), 'icon' => 'briefcase'],
            ['label' => 'Add Experience', 'route' => route('admin.experiences.create'), 'icon' => 'briefcase'],
            ['label' => 'Add Skill', 'route' => route('admin.skills.create'), 'icon' => 'cpu'],
            ['label' => 'Upload Media', 'route' => route('admin.media.index'), 'icon' => 'upload'],
        ];
    @endphp

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ($cards as $card)
            <a href="{{ $card['route'] }}" class="admin-card p-5 transition hover:border-brand/30 hover:shadow-md">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold uppercase tracking-widest text-muted">{{ $card['label'] }}</span>
                    <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-brand/10 text-brand">
                        <x-icon :name="$card['icon']" class="h-4 w-4" />
                    </span>
                </div>
                <p class="mt-3 font-display text-3xl font-extrabold text-ink">{{ $card['value'] }}</p>
            </a>
        @endforeach
    </div>

    <div class="mt-8">
        <h2 class="mb-3 text-sm font-semibold uppercase tracking-widest text-muted">Quick actions</h2>
        <div class="flex flex-wrap gap-2">
            @foreach ($quickActions as $action)
                <a href="{{ $action['route'] }}" class="admin-btn-light">
                    <x-icon :name="$action['icon']" class="h-4 w-4" />
                    {{ $action['label'] }}
                </a>
            @endforeach
        </div>
    </div>

    <div class="mt-8 grid gap-6 lg:grid-cols-2">
        <div class="admin-card p-5 lg:col-span-1">
            <div class="flex items-center justify-between">
                <h2 class="font-display text-base font-bold">Recent projects</h2>
                <a href="{{ route('admin.projects.index') }}" class="text-xs font-medium text-brand">View all</a>
            </div>
            @if ($recentProjects->isEmpty())
                <p class="mt-4 text-sm text-muted">No projects yet.</p>
            @else
                <ul class="mt-4 divide-y divide-ink/5">
                    @foreach ($recentProjects as $project)
                        <li class="flex items-center justify-between gap-3 py-3">
                            <div class="min-w-0">
                                <a href="{{ route('admin.projects.edit', $project) }}" class="block truncate text-sm font-medium text-ink transition hover:text-brand">
                                    {{ $project->title }}
                                </a>
                                <span class="text-xs text-muted">{{ $project->category?->name ?: 'Uncategorised' }}</span>
                            </div>
                            <span class="shrink-0 text-xs text-muted">{{ $project->created_at?->format('M j') }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="admin-card p-5 lg:col-span-1">
            <div class="flex items-center justify-between">
                <h2 class="font-display text-base font-bold">Recent messages</h2>
                <a href="{{ route('admin.messages.index') }}" class="text-xs font-medium text-brand">View all</a>
            </div>
            @if ($recentMessages->isEmpty())
                <p class="mt-4 text-sm text-muted">No messages yet.</p>
            @else
                <ul class="mt-4 divide-y divide-ink/5">
                    @foreach ($recentMessages as $message)
                        <li class="py-3">
                            <a href="{{ route('admin.messages.show', $message) }}" class="flex items-center justify-between gap-3">
                                <div class="min-w-0">
                                    <span class="block truncate text-sm font-medium text-ink">{{ $message->name }}</span>
                                    <span class="block truncate text-xs text-muted">{{ $message->subject ?: 'No subject' }}</span>
                                </div>
                                @if ($message->status === 'unread')
                                    <span class="shrink-0 rounded-full bg-brand/10 px-2 py-0.5 text-[11px] font-semibold text-brand">New</span>
                                @endif
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</x-layouts.admin>
