<x-layouts.admin :title="$item->exists ? 'Edit skill' : 'New skill'">
    <x-admin.simple-form
        :route="$route"
        :item="$item"
        :title="$item->exists ? 'Edit skill' : 'Create skill'"
        :fields="[
            ['name' => 'name', 'label' => 'Name', 'required' => true],
            ['name' => 'skill_category_id', 'label' => 'Category', 'type' => 'select', 'options' => $categories->pluck('name', 'id'), 'placeholder' => 'No category'],
            ['name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'rows' => 3, 'section' => 'Details'],
            ['name' => 'icon', 'label' => 'Icon', 'hint' => 'e.g. cpu, code, chart, cog', 'section' => 'Details'],
            ['name' => 'years_experience', 'label' => 'Years of experience', 'type' => 'number', 'hint' => 'Optional', 'section' => 'Details'],
            ['name' => 'sort_order', 'label' => 'Sort order', 'type' => 'number', 'value' => 0, 'section' => 'Details'],
        ]"
        :checkboxes="[
            ['name' => 'is_featured', 'label' => 'Featured', 'hint' => 'Highlight this skill.'],
            ['name' => 'is_active', 'label' => 'Active', 'hint' => 'Visible on the public site.', 'checked' => true],
        ]"
    />
</x-layouts.admin>
