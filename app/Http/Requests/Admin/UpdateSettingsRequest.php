<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingsRequest extends FormRequest
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
            'site_name' => ['nullable', 'string', 'max:120'],
            'tagline' => ['nullable', 'string', 'max:200'],
            'contact_email' => ['nullable', 'email', 'max:180'],
            'contact_phone' => ['nullable', 'string', 'max:40'],
            'contact_location' => ['nullable', 'string', 'max:120'],
            'default_meta_title' => ['nullable', 'string', 'max:180'],
            'default_meta_description' => ['nullable', 'string', 'max:300'],
            'color_primary' => ['nullable', 'string', 'max:30'],
            'color_secondary' => ['nullable', 'string', 'max:30'],
            'color_accent' => ['nullable', 'string', 'max:30'],
            'analytics_id' => ['nullable', 'string', 'max:60'],
            'footer_note' => ['nullable', 'string', 'max:300'],
        ];
    }
}
