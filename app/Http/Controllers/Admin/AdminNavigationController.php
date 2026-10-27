<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\NavigationLinkRequest;
use App\Models\NavigationLink;

class AdminNavigationController extends AdminResourceController
{
    protected string $model = NavigationLink::class;

    protected string $view = 'admin.navigation';

    protected string $route = 'admin.navigation';

    protected string $label = 'Navigation link';

    protected ?string $storeRequest = NavigationLinkRequest::class;

    protected ?string $updateRequest = NavigationLinkRequest::class;
}
