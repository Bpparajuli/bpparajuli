<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectCategory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request): View
    {
        $categories = ProjectCategory::query()
            ->active()
            ->ordered()
            ->withCount(['projects' => fn ($query) => $query->published()])
            ->get();

        $activeCategory = null;

        if ($request->filled('category')) {
            $activeCategory = $categories->firstWhere('slug', $request->string('category')->toString());
        }

        $search = trim((string) $request->query('q', ''));

        $projects = Project::query()
            ->published()
            ->with('category')
            ->when($activeCategory, fn ($query) => $query->where('project_category_id', $activeCategory->id))
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('title', 'like', "%{$search}%")
                        ->orWhere('short_description', 'like', "%{$search}%");
                });
            })
            ->ordered()
            ->paginate(9)
            ->withQueryString();

        return view('pages.projects.index', compact('categories', 'projects', 'activeCategory', 'search'));
    }

    public function show(Project $project): View
    {
        abort_unless($project->is_active, 404);

        $project->load(['category', 'images']);

        return view('pages.projects.show', [
            'project' => $project,
            'related' => $project->related(3),
        ]);
    }
}
