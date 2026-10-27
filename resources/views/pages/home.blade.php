<x-layouts.public>
    <x-slot:seo>
        <x-seo :person="true" />
    </x-slot:seo>

    @foreach ($sections as $section)
        @includeIf('partials.home.'.$section->key, [
            'section' => $section,
            'services' => $services ?? collect(),
            'projects' => $projects ?? collect(),
            'skillCategories' => $skillCategories ?? collect(),
            'experiences' => $experiences ?? collect(),
            'currently' => $currently ?? collect(),
        ])
    @endforeach
</x-layouts.public>
