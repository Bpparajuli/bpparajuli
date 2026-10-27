<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

abstract class AdminResourceController extends Controller
{
    /** @var class-string<Model> */
    protected string $model;

    /** View directory, e.g. "admin.projects". */
    protected string $view;

    /** Route name prefix, e.g. "admin.projects". */
    protected string $route;

    /** Human label, e.g. "Project". */
    protected string $label = 'Item';

    /** @var array<int, string> */
    protected array $indexRelations = [];

    protected string $orderColumn = 'sort_order';

    protected string $orderDirection = 'asc';

    protected int $perPage = 15;

    /** @var class-string|null */
    protected ?string $storeRequest = null;

    /** @var class-string|null */
    protected ?string $updateRequest = null;

    public function index(): View
    {
        $query = $this->model::query();

        if ($this->indexRelations !== []) {
            $query->with($this->indexRelations);
        }

        $items = $query
            ->orderBy($this->orderColumn, $this->orderDirection)
            ->orderBy('id')
            ->paginate($this->perPage);

        return view($this->view.'.index', array_merge([
            'items' => $items,
            'label' => $this->label,
            'route' => $this->route,
        ], $this->indexData()));
    }

    public function create(): View
    {
        return view($this->view.'.create', array_merge([
            'item' => new $this->model,
            'label' => $this->label,
            'route' => $this->route,
        ], $this->formData()));
    }

    public function store(Request $request): RedirectResponse
    {
        $request = $this->resolveRequest($this->storeRequest, $request);
        $data = $this->prepareData($request->validated(), null);

        $item = $this->model::query()->create($data);

        $this->afterSave($item, $request);

        return redirect()
            ->route($this->route.'.index')
            ->with('status', $this->label.' created successfully.');
    }

    public function edit(int|string $id): View
    {
        $item = $this->findItem($id);

        return view($this->view.'.edit', array_merge([
            'item' => $item,
            'label' => $this->label,
            'route' => $this->route,
        ], $this->formData($item)));
    }

    public function update(Request $request, int|string $id): RedirectResponse
    {
        $item = $this->findItem($id);
        $request = $this->resolveRequest($this->updateRequest, $request);
        $data = $this->prepareData($request->validated(), $item);

        $item->update($data);

        $this->afterSave($item, $request);

        return redirect()
            ->route($this->route.'.index')
            ->with('status', $this->label.' updated successfully.');
    }

    public function destroy(int|string $id): RedirectResponse
    {
        $item = $this->findItem($id);
        $item->delete();

        return redirect()
            ->route($this->route.'.index')
            ->with('status', $this->label.' deleted successfully.');
    }

    protected function findItem(int|string $id): Model
    {
        return $this->model::query()->findOrFail($id);
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function prepareData(array $data, ?Model $item): array
    {
        return $data;
    }

    protected function afterSave(Model $item, Request $request): void
    {
        //
    }

    /**
     * @return array<string, mixed>
     */
    protected function indexData(): array
    {
        return [];
    }

    /**
     * @return array<string, mixed>
     */
    protected function formData(?Model $item = null): array
    {
        return [];
    }

    protected function resolveRequest(?string $requestClass, Request $request): Request
    {
        if ($requestClass === null) {
            return $request;
        }

        /** @var \Illuminate\Foundation\Http\FormRequest $form */
        $form = $requestClass::createFrom($request);
        $form->setContainer(app())->setRedirector(app('redirect'));
        $form->validateResolved();

        return $form;
    }
}
