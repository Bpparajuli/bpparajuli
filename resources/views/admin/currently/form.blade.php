<x-layouts.admin :title="$item->exists ? 'Edit currently item' : 'New currently item'">
    <x-admin.simple-form
        :route="$route"
        :item="$item"
        :title="$item->exists ? 'Edit currently item' : 'Create currently item'"
        :fields="[
            ['name' => 'label', 'label' => 'Label', 'required' => true, 'hint' => 'e.g. Building, Exploring, Learning, Open to'],
            ['name' => 'value', 'label' => 'Value', 'type' => 'textarea', 'rows' => 2],
            ['name' => 'icon', 'label' => 'Icon', 'hint' => 'e.g. sparkles, lightbulb, cpu, search', 'section' => 'Details'],
            ['name' => 'sort_order', 'label' => 'Sort order', 'type' => 'number', 'value' => 0, 'section' => 'Details'],
        ]"
        :checkboxes="[
            ['name' => 'is_active', 'label' => 'Active', 'checked' => true],
        ]"
    />
</x-layouts.admin>
