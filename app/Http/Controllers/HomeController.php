<?php

namespace App\Http\Controllers;

use App\Models\CurrentlyItem;
use App\Models\Experience;
use App\Models\HomepageSection;
use App\Models\Project;
use App\Models\Service;
use App\Models\SkillCategory;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $sections = HomepageSection::query()->enabled()->ordered()->get();
        $keys = $sections->pluck('key')->all();

        $data = [
            'sections' => $sections,
        ];

        if (in_array('capabilities', $keys, true)) {
            $data['services'] = Service::query()->active()->ordered()->limit(6)->get();
        }

        if (in_array('projects', $keys, true)) {
            $data['projects'] = Project::query()
                ->published()
                ->with('category')
                ->featured()
                ->ordered()
                ->limit(6)
                ->get();
        }

        if (in_array('skills', $keys, true)) {
            $data['skillCategories'] = SkillCategory::query()
                ->active()
                ->ordered()
                ->with(['skills' => fn ($query) => $query->active()->ordered()])
                ->get()
                ->filter(fn ($category) => $category->skills->isNotEmpty())
                ->values();
        }

        if (in_array('experience', $keys, true)) {
            $data['experiences'] = Experience::query()->active()->ordered()->limit(4)->get();
        }

        if (in_array('currently', $keys, true)) {
            $data['currently'] = CurrentlyItem::query()->active()->ordered()->get();
        }

        return view('pages.home', $data);
    }
}
