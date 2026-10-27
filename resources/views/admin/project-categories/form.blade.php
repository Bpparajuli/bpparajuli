<x-layouts.admin :title="$item->exists ? 'Edit project category' : 'New project category'">
    <x-admin.simple-form
        :route="$route"
        :item="$item"
        :title="$item->exists ? 'Edit project category' : 'Create project category'"
        :fields="[
            ['name' => 'name', 'label' => 'Name', 'required' => true],
            ['name' => 'slug', 'label' => 'Slug', 'hint' => 'Leave blank to generate automatically.'],
            ['name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'rows' => 3, 'section' => 'Details'],
            ['name' => 'icon', 'label' => 'Icon', 'hint' => 'e.g. layers, briefcase, cpu', 'section' => 'Details'],
            ['name' => 'sort_order', 'label' => 'Sort order', 'type' => 'number', 'value' => 0, 'section' => 'Details'],
        ]"
        :checkboxes="[
            ['name' => 'is_active', 'label' => 'Active', 'hint' => 'Visible on the public site.', 'checked' => true],
        ]"
    />
</x-layouts.admin>
