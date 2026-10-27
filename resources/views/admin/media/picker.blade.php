<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Media picker</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-surface text-ink">
    <div class="p-6">
        <div class="mb-5 flex items-center justify-between">
            <h1 class="font-display text-lg font-bold">Choose an image</h1>
            <button type="button" onclick="window.close()" class="text-sm font-medium text-muted hover:text-ink">Close</button>
        </div>

        @if ($items->isEmpty())
            <p class="text-sm text-muted">No images yet.</p>
        @else
            <div class="grid gap-3 sm:grid-cols-3 lg:grid-cols-6">
                @foreach ($items as $item)
                    <button
                        type="button"
                        data-url="{{ $item->url() }}"
                        data-path="{{ $item->path }}"
                        class="group overflow-hidden rounded-lg border border-ink/10 bg-white text-left transition hover:border-brand/40"
                    >
                        <div class="aspect-square w-full overflow-hidden bg-ink/[0.04]">
                            <img src="{{ $item->url() }}" alt="{{ $item->alt_text }}" class="h-full w-full object-cover transition group-hover:scale-105">
                        </div>
                        <div class="p-2">
                            <p class="truncate text-xs font-medium text-ink">{{ $item->name }}</p>
                            <p class="truncate text-[11px] text-muted">Insert</p>
                        </div>
                    </button>
                @endforeach
            </div>
        @endif
    </div>

    <script>
        document.querySelectorAll('[data-url]').forEach(function (el) {
            el.addEventListener('click', function () {
                const payload = { type: 'media-picked', url: el.dataset.url, path: el.dataset.path };
                if (window.opener) {
                    window.opener.postMessage(payload, '*');
                }
                window.close();
            });
        });
    </script>
</body>
</html>
