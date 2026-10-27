<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomepageSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminHomepageController extends Controller
{
    public function index(): View
    {
        return view('admin.homepage.index', [
            'sections' => HomepageSection::query()->ordered()->get(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'sections' => ['required', 'array'],
            'sections.*.id' => ['required', 'integer', 'exists:homepage_sections,id'],
            'sections.*.eyebrow' => ['nullable', 'string', 'max:120'],
            'sections.*.title' => ['nullable', 'string', 'max:200'],
            'sections.*.subtitle' => ['nullable', 'string', 'max:600'],
            'sections.*.is_enabled' => ['nullable', 'boolean'],
        ]);

        foreach ($validated['sections'] as $payload) {
            $section = HomepageSection::query()->find($payload['id']);

            if (! $section) {
                continue;
            }

            $section->update([
                'eyebrow' => $payload['eyebrow'] ?? null,
                'title' => $payload['title'] ?? null,
                'subtitle' => $payload['subtitle'] ?? null,
                'is_enabled' => filter_var($payload['is_enabled'] ?? false, FILTER_VALIDATE_BOOLEAN),
            ]);
        }

        return redirect()->route('admin.homepage.index')->with('status', 'Homepage sections updated.');
    }

    public function reorder(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'order' => ['required', 'array'],
            'order.*' => ['integer', 'exists:homepage_sections,id'],
        ]);

        foreach ($validated['order'] as $position => $id) {
            HomepageSection::query()->whereKey($id)->update(['sort_order' => $position]);
        }

        return redirect()->route('admin.homepage.index')->with('status', 'Section order updated.');
    }
}
