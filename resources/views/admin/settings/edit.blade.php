<x-layouts.admin title="Settings">
    <x-admin.page-header title="Settings" subtitle="Global site configuration." />

    @php
        $labels = [
            'general' => 'General',
            'branding' => 'Branding',
            'contact' => 'Contact',
            'seo' => 'SEO',
            'appearance' => 'Appearance',
        ];
    @endphp

    <div class="mx-auto max-w-3xl">
        <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            @foreach ($schema as $group => $fields)
                <div class="admin-card space-y-5 p-6">
                    <h3 class="font-display text-base font-bold">{{ $labels[$group] ?? ucfirst($group) }}</h3>

                    @foreach ($fields as $key => $type)
                        @if ($type === 'image')
                            <x-admin.image-field :name="$key" :current="$values[$key]" :label="str_replace('_', ' ', ucfirst($key))" />
                        @elseif ($type === 'textarea')
                            <x-form.textarea :name="$key" :label="str_replace('_', ' ', ucfirst($key))" :value="$values[$key]" rows="3" />
                        @elseif ($type === 'color')
                            <div>
                                <label for="{{ $key }}" class="form-label">{{ str_replace('_', ' ', ucfirst($key)) }}</label>
                                <input id="{{ $key }}" name="{{ $key }}" type="color" value="{{ old($key, $values[$key]) }}" class="block h-11 w-20 rounded-lg border border-ink/15 bg-white p-1">
                            </div>
                        @else
                            <x-form.input :name="$key" :label="str_replace('_', ' ', ucfirst($key))" :value="$values[$key]" />
                        @endif
                    @endforeach
                </div>
            @endforeach

            <div class="flex items-center gap-3 border-t border-ink/10 pt-5">
                <button type="submit" class="admin-btn-primary">Save settings</button>
            </div>
        </form>
    </div>
</x-layouts.admin>
