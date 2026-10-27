<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:180'],
            'slug' => ['nullable', 'string', 'max:200', 'alpha_dash', Rule::unique('projects', 'slug')->ignore($this->route('project')?->id)],
            'project_category_id' => ['nullable', 'integer', 'exists:project_categories,id'],
            'subtitle' => ['nullable', 'string', 'max:200'],
            'short_description' => ['nullable', 'string', 'max:600'],
            'overview' => ['nullable', 'string', 'max:30000'],
            'problem' => ['nullable', 'string', 'max:20000'],
            'approach' => ['nullable', 'string', 'max:20000'],
            'solution' => ['nullable', 'string', 'max:20000'],
            'result' => ['nullable', 'string', 'max:20000'],
            'role' => ['nullable', 'string', 'max:200'],
            'client' => ['nullable', 'string', 'max:200'],
            'timeline' => ['nullable', 'string', 'max:120'],
            'technologies' => ['nullable', 'string', 'max:1000'],
            'status' => ['required', Rule::in(array_keys(\App\Models\Project::STATUSES))],
            'featured_image' => ['nullable', 'string', 'max:500'],
            'external_url' => ['nullable', 'url', 'max:300'],
            'github_url' => ['nullable', 'url', 'max:300'],
            'is_featured' => ['boolean'],
            'is_active' => ['boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'seo_title' => ['nullable', 'string', 'max:180'],
            'seo_description' => ['nullable', 'string', 'max:300'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_featured' => $this->boolean('is_featured'),
            'is_active' => $this->boolean('is_active'),
            'sort_order' => $this->input('sort_order', 0),
            'project_category_id' => $this->filled('project_category_id') ? $this->input('project_category_id') : null,
        ]);
    }
}
