<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProjectImage;
use Illuminate\Http\RedirectResponse;

class AdminProjectImageController extends Controller
{
    public function destroy(ProjectImage $image): RedirectResponse
    {
        $projectId = $image->project_id;
        $image->delete();

        return redirect()
            ->route('admin.projects.edit', $projectId)
            ->with('status', 'Image removed from gallery.');
    }
}
