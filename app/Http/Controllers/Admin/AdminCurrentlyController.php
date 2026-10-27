<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CurrentlyItemRequest;
use App\Models\CurrentlyItem;

class AdminCurrentlyController extends AdminResourceController
{
    protected string $model = CurrentlyItem::class;

    protected string $view = 'admin.currently';

    protected string $route = 'admin.currently';

    protected string $label = 'Currently item';

    protected ?string $storeRequest = CurrentlyItemRequest::class;

    protected ?string $updateRequest = CurrentlyItemRequest::class;
}
