@props(['eyebrow' => null, 'title' => null, 'subtitle' => null, 'center' => false, 'class' => ''])

<div @class(['max-w-2xl', 'mx-auto text-center' => $center, $class])>
    @if ($eyebrow)
        <p class="eyebrow reveal">{{ $eyebrow }}</p>
    @endif

    @if ($title)
        <h2 class="display-2 reveal mt-3">{{ $title }}</h2>
    @endif

    @if ($subtitle)
        <p class="lede reveal mt-4">{{ $subtitle }}</p>
    @endif

    @if (isset($actions))
        <div @class(['mt-8 flex flex-wrap gap-3', 'justify-center' => $center])>{{ $actions }}</div>
    @endif
</div>
