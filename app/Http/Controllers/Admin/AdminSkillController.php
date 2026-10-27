<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\SkillRequest;
use App\Models\Skill;
use App\Models\SkillCategory;
use Illuminate\Database\Eloquent\Model;

class AdminSkillController extends AdminResourceController
{
    protected string $model = Skill::class;

    protected string $view = 'admin.skills';

    protected string $route = 'admin.skills';

    protected string $label = 'Skill';

    protected array $indexRelations = ['category'];

    protected ?string $storeRequest = SkillRequest::class;

    protected ?string $updateRequest = SkillRequest::class;

    protected function formData(?Model $item = null): array
    {
        return ['categories' => SkillCategory::query()->ordered()->get()];
    }
}
