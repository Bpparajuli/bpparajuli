<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateSettingsRequest;
use App\Services\MediaUploader;
use App\Support\Settings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminSettingsController extends Controller
{
    /**
     * @var array<string, array<string, string>>
     */
    protected array $schema = [
        'general' => [
            'site_name' => 'text',
            'tagline' => 'text',
            'footer_note' => 'text',
        ],
        'branding' => [
            'logo' => 'image',
            'favicon' => 'image',
        ],
        'contact' => [
            'contact_email' => 'text',
            'contact_phone' => 'text',
            'contact_location' => 'text',
        ],
        'seo' => [
            'default_meta_title' => 'text',
            'default_meta_description' => 'textarea',
            'default_og_image' => 'image',
            'analytics_id' => 'text',
        ],
        'appearance' => [
            'color_primary' => 'color',
            'color_secondary' => 'color',
            'color_accent' => 'color',
        ],
    ];

    public function edit(): View
    {
        return view('admin.settings.edit', [
            'schema' => $this->schema,
            'values' => collect($this->schema)
                ->flatten()
                ->keys()
                ->mapWithKeys(fn ($key) => [$key => setting($key)])
                ->all(),
        ]);
    }

    public function update(UpdateSettingsRequest $request, MediaUploader $uploader): RedirectResponse
    {
        $validated = $request->validated();

        foreach ($this->schema as $group => $fields) {
            foreach ($fields as $key => $type) {
                if ($type === 'image') {
                    continue;
                }

                if (array_key_exists($key, $validated)) {
                    Settings::set($key, $validated[$key], $group, $type === 'textarea' ? 'textarea' : 'text');
                }
            }
        }

        foreach (['logo' => 'branding', 'favicon' => 'branding', 'default_og_image' => 'seo'] as $key => $group) {
            if ($request->hasFile($key)) {
                $stored = $uploader->store($request->file($key), 'branding');
                Settings::set($key, $stored['path'], $group, 'image');
            }
        }

        Settings::flush();

        return redirect()->route('admin.settings.edit')->with('status', 'Settings saved successfully.');
    }
}
