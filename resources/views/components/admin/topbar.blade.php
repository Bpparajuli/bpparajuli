@props(['title' => 'Dashboard'])

@php($user = auth()->user())

<header class="sticky top-0 z-30 flex h-16 items-center gap-4 border-b border-ink/10 bg-white/85 px-4 backdrop-blur sm:px-6 lg:px-8">
    <button type="button" @click="sidebarOpen = true" class="text-ink lg:hidden" aria-label="Open menu">
        <x-icon name="menu" class="h-6 w-6" />
    </button>

    <h1 class="font-display text-lg font-bold text-ink">{{ $title }}</h1>

    <div class="ml-auto flex items-center gap-3">
        <a href="{{ route('home') }}" target="_blank" class="hidden items-center gap-1.5 text-sm font-medium text-muted transition hover:text-brand sm:inline-flex">
            View site
            <x-icon name="external-link" class="h-4 w-4" />
        </a>

        <div class="flex items-center gap-2.5 rounded-full border border-ink/10 py-1 pl-1 pr-3">
            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-brand text-xs font-bold text-white">
                {{ $user?->initials() }}
            </span>
            <div class="hidden leading-tight sm:block">
                <span class="block text-xs font-semibold text-ink">{{ $user?->name }}</span>
                <span class="block text-[11px] text-muted">{{ $user?->job_title ?: 'Admin' }}</span>
            </div>
        </div>
    </div>
</header>
