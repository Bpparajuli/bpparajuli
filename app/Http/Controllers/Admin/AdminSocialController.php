<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\SocialLinkRequest;
use App\Models\SocialLink;

class AdminSocialController extends AdminResourceController
{
    protected string $model = SocialLink::class;

    protected string $view = 'admin.social-links';

    protected string $route = 'admin.social-links';

    protected string $label = 'Social link';

    protected ?string $storeRequest = SocialLinkRequest::class;

    protected ?string $updateRequest = SocialLinkRequest::class;
}
