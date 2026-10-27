@php
    $groups = [
        [
            'label' => 'Overview',
            'items' => [
                ['route' => 'admin.dashboard', 'pattern' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => 'home'],
                ['route' => 'admin.profile.edit', 'pattern' => 'admin.profile.*', 'label' => 'Profile', 'icon' => 'user'],
                ['route' => 'admin.homepage.index', 'pattern' => 'admin.homepage.*', 'label' => 'Homepage', 'icon' => 'layers'],
                ['route' => 'admin.currently.index', 'pattern' => 'admin.currently.*', 'label' => 'Currently', 'icon' => 'sparkles'],
            ],
        ],
        [
            'label' => 'Content',
            'items' => [
                ['route' => 'admin.projects.index', 'pattern' => 'admin.projects.*', 'label' => 'Projects', 'icon' => 'layers'],
                ['route' => 'admin.project-categories.index', 'pattern' => 'admin.project-categories.*', 'label' => 'Project categories', 'icon' => 'folder'],
                ['route' => 'admin.services.index', 'pattern' => 'admin.services.*', 'label' => 'Services', 'icon' => 'briefcase'],
                ['route' => 'admin.pages.index', 'pattern' => 'admin.pages.*', 'label' => 'Pages', 'icon' => 'file-text'],
            ],
        ],
        [
            'label' => 'Credentials',
            'items' => [
                ['route' => 'admin.skills.index', 'pattern' => 'admin.skills.*', 'label' => 'Skills', 'icon' => 'cpu'],
                ['route' => 'admin.skill-categories.index', 'pattern' => 'admin.skill-categories.*', 'label' => 'Skill categories', 'icon' => 'folder'],
                ['route' => 'admin.experiences.index', 'pattern' => 'admin.experiences.*', 'label' => 'Experience', 'icon' => 'briefcase'],
            ],
        ],
        [
            'label' => 'Library',
            'items' => [
                ['route' => 'admin.media.index', 'pattern' => 'admin.media.*', 'label' => 'Media', 'icon' => 'image'],
                ['route' => 'admin.messages.index', 'pattern' => 'admin.messages.*', 'label' => 'Messages', 'icon' => 'message', 'badge' => \App\Models\ContactMessage::query()->unread()->count()],
            ],
        ],
        [
            'label' => 'Configuration',
            'items' => [
                ['route' => 'admin.navigation.index', 'pattern' => 'admin.navigation.*', 'label' => 'Navigation', 'icon' => 'menu'],
                ['route' => 'admin.social-links.index', 'pattern' => 'admin.social-links.*', 'label' => 'Social links', 'icon' => 'globe'],
                ['route' => 'admin.settings.edit', 'pattern' => 'admin.settings.*', 'label' => 'Settings', 'icon' => 'settings'],
                ['route' => 'admin.users.index', 'pattern' => 'admin.users.*', 'label' => 'Users', 'icon' => 'users'],
            ],
        ],
    ];
@endphp

{{-- Mobile overlay --}}
<div
    x-show="sidebarOpen"
    x-cloak
    x-transition.opacity
    @click="sidebarOpen = false"
    class="fixed inset-0 z-40 bg-ink/40 lg:hidden"
></div>

<aside
    x-cloak
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 z-50 flex w-72 flex-col border-r border-ink/10 bg-white transition-transform duration-300 lg:translate-x-0"
>
    <div class="flex h-16 items-center justify-between border-b border-ink/10 px-5">
        <a href="{{ route('admin.dashboard') }}" class="font-display text-base font-extrabold text-ink">
            {{ setting('site_name', config('app.name')) }}
            <span class="block text-[11px] font-medium uppercase tracking-widest text-muted">Admin</span>
        </a>
        <button type="button" @click="sidebarOpen = false" class="text-muted lg:hidden" aria-label="Close menu">
            <x-icon name="x" class="h-5 w-5" />
        </button>
    </div>

    <nav class="flex-1 space-y-6 overflow-y-auto px-3 py-5" aria-label="Admin">
        @foreach ($groups as $group)
            <div>
                <p class="px-3 text-[11px] font-semibold uppercase tracking-widest text-muted">{{ $group['label'] }}</p>
                <div class="mt-2 space-y-0.5">
                    @foreach ($group['items'] as $item)
                        @php($active = request()->routeIs($item['pattern']))
                        <a href="{{ route($item['route']) }}" @class(['admin-nav-link', 'is-active' => $active])>
                            <x-icon :name="$item['icon']" class="h-4.5 w-4.5 shrink-0" />
                            <span class="flex-1">{{ $item['label'] }}</span>
                            @if (! empty($item['badge']))
                                <span class="rounded-full bg-brand px-2 py-0.5 text-[11px] font-semibold text-white">{{ $item['badge'] }}</span>
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>
        @endforeach
    </nav>

    <div class="border-t border-ink/10 p-3">
        <a href="{{ route('home') }}" target="_blank" class="admin-nav-link">
            <x-icon name="external-link" class="h-4.5 w-4.5" />
            View website
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="admin-nav-link w-full">
                <x-icon name="log-out" class="h-4.5 w-4.5" />
                Sign out
            </button>
        </form>
    </div>
</aside>
