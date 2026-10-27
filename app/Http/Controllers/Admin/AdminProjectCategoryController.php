<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ProjectCategoryRequest;
use App\Models\ProjectCategory;

class AdminProjectCategoryController extends AdminResourceController
{
    protected string $model = ProjectCategory::class;

    protected string $view = 'admin.project-categories';

    protected string $route = 'admin.project-categories';

    protected string $label = 'Project category';

    protected ?string $storeRequest = ProjectCategoryRequest::class;

    protected ?string $updateRequest = ProjectCategoryRequest::class;
}
