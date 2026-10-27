<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ExperienceRequest;
use App\Models\Experience;
use Illuminate\Database\Eloquent\Model;

class AdminExperienceController extends AdminResourceController
{
    protected string $model = Experience::class;

    protected string $view = 'admin.experiences';

    protected string $route = 'admin.experiences';

    protected string $label = 'Experience';

    protected ?string $storeRequest = ExperienceRequest::class;

    protected ?string $updateRequest = ExperienceRequest::class;

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function prepareData(array $data, ?Model $item): array
    {
        $data['responsibilities'] = $this->toLines($data['responsibilities'] ?? null);
        $data['achievements'] = $this->toLines($data['achievements'] ?? null);

        return $data;
    }

    /**
     * @return array<int, string>
     */
    protected function toLines(?string $value): array
    {
        return collect(preg_split('/\r\n|\r|\n/', (string) $value))
            ->map(fn ($line) => trim($line))
            ->filter()
            ->values()
            ->all();
    }
}
