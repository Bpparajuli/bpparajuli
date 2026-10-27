<x-layouts.admin :title="$item->exists ? 'Edit social link' : 'New social link'">
    <x-admin.simple-form
        :route="$route"
        :item="$item"
        :title="$item->exists ? 'Edit social link' : 'Create social link'"
        :fields="[
            ['name' => 'platform', 'label' => 'Platform', 'type' => 'select', 'required' => true, 'placeholder' => 'Select a platform', 'options' => [
                'linkedin' => 'LinkedIn', 'github' => 'GitHub', 'facebook' => 'Facebook', 'instagram' => 'Instagram',
                'youtube' => 'YouTube', 'x' => 'X (Twitter)', 'whatsapp' => 'WhatsApp', 'website' => 'Website',
            ]],
            ['name' => 'label', 'label' => 'Custom label', 'hint' => 'Optional. Overrides the platform name.'],
            ['name' => 'url', 'type' => 'url', 'label' => 'URL', 'required' => true],
            ['name' => 'icon', 'label' => 'Icon override', 'hint' => 'Optional icon key, e.g. globe.', 'section' => 'Details'],
            ['name' => 'sort_order', 'label' => 'Sort order', 'type' => 'number', 'value' => 0, 'section' => 'Details'],
        ]"
        :checkboxes="[
            ['name' => 'is_active', 'label' => 'Active', 'hint' => 'Show this link on the public site.', 'checked' => true],
        ]"
    />
</x-layouts.admin>
