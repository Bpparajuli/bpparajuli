<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(): View
    {
        return view('pages.services.index', [
            'services' => Service::query()
                ->active()
                ->ordered()
                ->get(),
        ]);
    }

    public function show(Request $request, Service $service): View
    {
        abort_unless($service->is_active, 404);

        return view('pages.services.show', [
            'service' => $service,
            'others' => Service::query()
                ->active()
                ->whereKeyNot($service->getKey())
                ->ordered()
                ->limit(3)
                ->get(),
        ]);
    }
}
