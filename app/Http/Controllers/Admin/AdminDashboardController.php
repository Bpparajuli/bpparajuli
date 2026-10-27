<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Experience;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Contracts\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'stats' => [
                'projects' => Project::query()->count(),
                'skills' => Skill::query()->count(),
                'experiences' => Experience::query()->count(),
                'unread' => ContactMessage::query()->unread()->count(),
            ],
            'recentProjects' => Project::query()->with('category')->latest()->limit(5)->get(),
            'recentMessages' => ContactMessage::query()->latest()->limit(5)->get(),
        ]);
    }
}
