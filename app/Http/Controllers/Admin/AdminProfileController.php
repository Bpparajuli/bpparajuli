<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateProfileRequest;
use App\Services\MediaUploader;
use App\Support\Settings;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminProfileController extends Controller
{
    /**
     * @var array<string, string>
     */
    protected array $textFields = [
        'profile_name' => 'text',
        'profile_headline' => 'text',
        'profile_short_bio' => 'textarea',
        'profile_bio' => 'textarea',
        'profile_location' => 'text',
        'contact_email' => 'text',
        'contact_phone' => 'text',
        'profile_availability' => 'text',
        'profile_current_focus' => 'textarea',
    ];

    public function edit(): View
    {
        return view('admin.profile.edit', [
            'values' => collect($this->textFields)
                ->keys()
                ->mapWithKeys(fn ($key) => [$key => setting($key)])
                ->all(),
        ]);
    }

    public function update(UpdateProfileRequest $request, MediaUploader $uploader): RedirectResponse
    {
        foreach ($request->safe()->except('profile_image') as $key => $value) {
            if (array_key_exists($key, $this->textFields)) {
                Settings::set($key, $value, 'profile', $this->textFields[$key]);
            }
        }

        if ($request->hasFile('profile_image')) {
            $stored = $uploader->store($request->file('profile_image'), 'profile');
            Settings::set('profile_image', $stored['path'], 'profile');
        }

        if ($request->boolean('remove_profile_image')) {
            Settings::set('profile_image', null, 'profile');
        }

        return redirect()->route('admin.profile.edit')->with('status', 'Profile updated successfully.');
    }
}
