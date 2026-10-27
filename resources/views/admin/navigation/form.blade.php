<x-layouts.admin :title="$item->exists ? 'Edit navigation link' : 'New navigation link'">
    <x-admin.simple-form
        :route="$route"
        :item="$item"
        :title="$item->exists ? 'Edit navigation link' : 'Create navigation link'"
        :fields="[
            ['name' => 'label', 'label' => 'Label', 'required' => true],
            ['name' => 'group', 'label' => 'Group', 'type' => 'select', 'required' => true, 'options' => ['header' => 'Header', 'footer' => 'Footer', 'legal' => 'Legal']],
            ['name' => 'url', 'label' => 'URL', 'required' => true, 'hint' => 'Use a full URL or a path such as /about'],
            ['name' => 'target', 'label' => 'Target', 'type' => 'select', 'options' => ['_self' => 'Same tab', '_blank' => 'New tab']],
            ['name' => 'sort_order', 'label' => 'Sort order', 'type' => 'number', 'value' => 0, 'section' => 'Details'],
        ]"
        :checkboxes="[
            ['name' => 'is_active', 'label' => 'Active', 'checked' => true],
        ]"
    />
</x-layouts.admin>
