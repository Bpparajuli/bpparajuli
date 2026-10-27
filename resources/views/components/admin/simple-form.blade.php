@props([
    'route',
    'item',
    'title',
    'fields' => [],
    'checkboxes' => [],
    'enctype' => false,
])

@php
    $action = $item->exists ? route($route.'.update', $item) : route($route.'.store');

    $grouped = collect($fields)->groupBy(fn ($field) => $field['section'] ?? '');
@endphp

<x-admin.form-shell :title="$title" :route="$route" :item="$item">
    <form method="POST" action="{{ $action }}" @if ($enctype) enctype="multipart/form-data" @endif class="space-y-6">
        @csrf
        @if ($item->exists)
            @method('PUT')
        @endif

        @foreach ($grouped as $sectionTitle => $sectionFields)
            <div class="admin-card space-y-5 p-6">
                @if ($sectionTitle !== '')
                    <h3 class="font-display text-base font-bold">{{ $sectionTitle }}</h3>
                @endif

                @foreach ($sectionFields as $field)
                    @php
                        $name = $field['name'];
                        $value = old($name, data_get($item, $name, $field['value'] ?? null));
                        $type = $field['type'] ?? 'text';
                    @endphp

                    @switch($type)
                        @case('textarea')
                            <x-form.textarea :name="$name" :label="$field['label'] ?? null" :value="$value" :rows="$field['rows'] ?? 4" :hint="$field['hint'] ?? null" />
                            @break
                        @case('select')
                            <x-form.select :name="$name" :label="$field['label'] ?? null" :selected="$value" :options="$field['options'] ?? []" :placeholder="$field['placeholder'] ?? null" :hint="$field['hint'] ?? null" />
                            @break
                        @case('checkbox')
                            <x-form.checkbox :name="$name" :label="$field['label'] ?? $name" :checked="(bool) $value" :hint="$field['hint'] ?? null" />
                            @break
                        @default
                            <x-form.input :name="$name" :type="$type" :label="$field['label'] ?? null" :value="$value" :required="$field['required'] ?? false" :hint="$field['hint'] ?? null" />
                    @endswitch
                @endforeach
            </div>
        @endforeach

        @if (! empty($checkboxes))
            <div class="admin-card space-y-4 p-6">
                @foreach ($checkboxes as $checkbox)
                    <x-form.checkbox
                        :name="$checkbox['name']"
                        :label="$checkbox['label']"
                        :hint="$checkbox['hint'] ?? null"
                        :checked="old($checkbox['name'], data_get($item, $checkbox['name'], $checkbox['checked'] ?? false))"
                    />
                @endforeach
            </div>
        @endif

        <x-admin.form-actions :route="$route" :item="$item" />
    </form>
</x-admin.form-shell>
