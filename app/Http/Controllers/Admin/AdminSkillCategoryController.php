<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\SkillCategoryRequest;
use App\Models\SkillCategory;

class AdminSkillCategoryController extends AdminResourceController
{
    protected string $model = SkillCategory::class;

    protected string $view = 'admin.skill-categories';

    protected string $route = 'admin.skill-categories';

    protected string $label = 'Skill category';

    protected ?string $storeRequest = SkillCategoryRequest::class;

    protected ?string $updateRequest = SkillCategoryRequest::class;
}
