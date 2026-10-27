<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\PageRequest;
use App\Models\Page;
use App\Services\MediaUploader;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AdminPageController extends AdminResourceController
{
    protected string $model = Page::class;

    protected string $view = 'admin.pages';

    protected string $route = 'admin.pages';

    protected string $label = 'Page';

    protected ?string $storeRequest = PageRequest::class;

    protected ?string $updateRequest = PageRequest::class;

    protected function afterSave(Model $item, Request $request): void
    {
        if (! $item instanceof Page) {
            return;
        }

        if ($request->hasFile('featured_image_file')) {
            $stored = app(MediaUploader::class)->store($request->file('featured_image_file'), 'pages');
            $item->update(['featured_image' => $stored['path']]);
        }
    }
}
