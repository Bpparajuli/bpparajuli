@props([
    'name',
    'label',
    'checked' => false,
    'hint' => null,
    'value' => '1',
])

<label for="{{ $name }}" class="flex cursor-pointer items-start gap-3">
    <input type="hidden" name="{{ $name }}" value="0">
    <input
        type="checkbox"
        id="{{ $name }}"
        name="{{ $name }}"
        value="{{ $value }}"
        @checked(old($name, $checked))
        {{ $attributes->merge(['class' => 'mt-0.5 h-4 w-4 rounded border-ink/25 text-brand focus:ring-brand/30']) }}
    >
    <span>
        <span class="block text-sm font-medium text-ink">{{ $label }}</span>
        @if ($hint)
            <span class="mt-0.5 block text-xs text-muted">{{ $hint }}</span>
        @endif
    </span>
</label>
