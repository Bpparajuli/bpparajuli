<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $urls = collect();

        foreach ([
            route('home'),
            route('about'),
            route('projects.index'),
            route('services.index'),
            route('contact.index'),
        ] as $url) {
            $urls->push(['loc' => $url, 'priority' => '0.8', 'lastmod' => now()->toAtomString()]);
        }

        foreach (Project::query()->published()->ordered()->get() as $project) {
            $urls->push([
                'loc' => route('projects.show', $project),
                'priority' => '0.7',
                'lastmod' => $project->updated_at?->toAtomString(),
            ]);
        }

        foreach (Service::query()->active()->ordered()->get() as $service) {
            $urls->push([
                'loc' => route('services.show', $service),
                'priority' => '0.6',
                'lastmod' => $service->updated_at?->toAtomString(),
            ]);
        }

        foreach (Page::query()->published()->get() as $page) {
            $urls->push([
                'loc' => route('pages.show', $page->slug),
                'priority' => '0.5',
                'lastmod' => $page->updated_at?->toAtomString(),
            ]);
        }

        return response()
            ->view('sitemap', compact('urls'))
            ->header('Content-Type', 'application/xml');
    }
}
