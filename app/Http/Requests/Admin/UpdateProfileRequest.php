<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'profile_name' => ['nullable', 'string', 'max:120'],
            'profile_headline' => ['nullable', 'string', 'max:180'],
            'profile_short_bio' => ['nullable', 'string', 'max:600'],
            'profile_bio' => ['nullable', 'string', 'max:20000'],
            'profile_location' => ['nullable', 'string', 'max:120'],
            'contact_email' => ['nullable', 'email', 'max:180'],
            'contact_phone' => ['nullable', 'string', 'max:40'],
            'profile_availability' => ['nullable', 'string', 'max:120'],
            'profile_current_focus' => ['nullable', 'string', 'max:2000'],
            'profile_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'remove_profile_image' => ['nullable', 'boolean'],
        ];
    }
}
