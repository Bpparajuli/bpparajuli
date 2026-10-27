<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use App\Models\SkillCategory;
use Illuminate\Contracts\View\View;

class AboutController extends Controller
{
    public function index(): View
    {
        return view('pages.about', [
            'experiences' => Experience::query()->active()->ordered()->get(),
            'skillCategories' => SkillCategory::query()
                ->active()
                ->ordered()
                ->with(['skills' => fn ($query) => $query->active()->ordered()])
                ->get()
                ->filter(fn ($category) => $category->skills->isNotEmpty())
                ->values(),
        ]);
    }
}
