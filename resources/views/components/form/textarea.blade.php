@props([
    'name',
    'label' => null,
    'value' => null,
    'required' => false,
    'rows' => 5,
    'hint' => null,
])

<div>
    @if ($label)
        <label for="{{ $name }}" class="form-label">
            {{ $label }}
            @if ($required)
                <span class="text-red-500" aria-hidden="true">*</span>
            @endif
        </label>
    @endif

    <textarea
        id="{{ $name }}"
        name="{{ $name }}"
        rows="{{ $rows }}"
        @if ($required) required @endif
        @if ($errors->has($name)) aria-invalid="true" aria-describedby="{{ $name }}-error" @endif
        {{ $attributes->class(['form-input', 'is-invalid' => $errors->has($name)]) }}
    >{{ old($name, $value) }}</textarea>

    @error($name)
        <p id="{{ $name }}-error" class="form-error">{{ $message }}</p>
    @enderror

    @if ($hint)
        <p class="form-help">{{ $hint }}</p>
    @endif
</div>
