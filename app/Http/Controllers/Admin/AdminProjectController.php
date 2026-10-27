<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ProjectRequest;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Services\MediaUploader;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AdminProjectController extends AdminResourceController
{
    protected string $model = Project::class;

    protected string $view = 'admin.projects';

    protected string $route = 'admin.projects';

    protected string $label = 'Project';

    protected array $indexRelations = ['category'];

    protected ?string $storeRequest = ProjectRequest::class;

    protected ?string $updateRequest = ProjectRequest::class;

    protected function indexData(): array
    {
        return ['categories' => ProjectCategory::query()->ordered()->get()];
    }

    protected function formData(?Model $item = null): array
    {
        return ['categories' => ProjectCategory::query()->ordered()->get()];
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function prepareData(array $data, ?Model $item): array
    {
        $data['technologies'] = collect(preg_split('/[\r\n,]+/', (string) ($data['technologies'] ?? '')))
            ->map(fn ($value) => trim($value))
            ->filter()
            ->values()
            ->all();

        return $data;
    }

    protected function afterSave(Model $item, Request $request): void
    {
        if (! $item instanceof Project) {
            return;
        }

        $uploader = app(MediaUploader::class);

        if ($request->hasFile('featured_image_file')) {
            $stored = $uploader->store($request->file('featured_image_file'), 'projects');
            $item->update(['featured_image' => $stored['path']]);
        }

        if ($request->hasFile('gallery')) {
            $position = (int) $item->images()->max('sort_order');

            foreach ($request->file('gallery') as $file) {
                $stored = $uploader->store($file, 'projects/gallery');
                $item->images()->create([
                    'path' => $stored['path'],
                    'alt' => $item->title,
                    'sort_order' => ++$position,
                ]);
            }
        }
    }
}
