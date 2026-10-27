<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ServiceRequest;
use App\Models\Service;

class AdminServiceController extends AdminResourceController
{
    protected string $model = Service::class;

    protected string $view = 'admin.services';

    protected string $route = 'admin.services';

    protected string $label = 'Service';

    protected ?string $storeRequest = ServiceRequest::class;

    protected ?string $updateRequest = ServiceRequest::class;
}
