<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\UserRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AdminUserController extends AdminResourceController
{
    protected string $model = User::class;

    protected string $view = 'admin.users';

    protected string $route = 'admin.users';

    protected string $label = 'User';

    protected string $orderColumn = 'name';

    protected ?string $storeRequest = UserRequest::class;

    protected ?string $updateRequest = UserRequest::class;

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function prepareData(array $data, ?Model $item): array
    {
        if (empty($data['password'])) {
            unset($data['password']);
        }

        return $data;
    }

    public function destroy(int|string $id): \Illuminate\Http\RedirectResponse
    {
        $user = User::query()->findOrFail($id);

        if ($user->is($this->user())) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route($this->route.'.index')->with('status', 'User deleted successfully.');
    }

    protected function afterSave(Model $item, Request $request): void
    {
        if (! $item instanceof User) {
            return;
        }

        if ($request->hasFile('avatar_file')) {
            $stored = app(\App\Services\MediaUploader::class)->store($request->file('avatar_file'), 'avatars');
            $item->update(['avatar' => $stored['path']]);
        }
    }
}
