@php
    $paginator = $paginator ?? null;
@endphp

@if ($paginator && $paginator->hasPages())
    <nav role="navigation" aria-label="Pagination" class="flex flex-wrap items-center justify-center gap-2">
        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <span class="inline-flex h-10 items-center rounded-lg border border-ink/10 bg-white px-4 text-sm text-muted/50" aria-disabled="true">
                Previous
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
               class="inline-flex h-10 items-center rounded-lg border border-ink/10 bg-white px-4 text-sm font-medium text-ink transition hover:border-brand/30 hover:text-brand">
                Previous
            </a>
        @endif

        {{-- Pages --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="inline-flex h-10 w-10 items-center justify-center text-sm text-muted">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span aria-current="page" class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-brand text-sm font-semibold text-white">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-ink/10 bg-white text-sm font-medium text-ink transition hover:border-brand/30 hover:text-brand">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next"
               class="inline-flex h-10 items-center rounded-lg border border-ink/10 bg-white px-4 text-sm font-medium text-ink transition hover:border-brand/30 hover:text-brand">
                Next
            </a>
        @else
            <span class="inline-flex h-10 items-center rounded-lg border border-ink/10 bg-white px-4 text-sm text-muted/50" aria-disabled="true">
                Next
            </span>
        @endif
    </nav>
@endif
