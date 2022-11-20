<?php

namespace Modules\Base\Services\Resource\Concerns\Handlers;

use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

trait Response
{
    public ?string $view = "Resource";

    public function loadResponse(array $rows, LengthAwarePaginator $data, bool $isAPI): JsonResponse | \Inertia\Response
    {
        if ($isAPI) {
            return response()->json([
                "success" => true,
                "message" => __((new self)->generateName(true, true) . ' Loaded Success'),
                "data" => $data
            ]);
        }

        return inertia($this->view, $this->response($rows, $data, $this->table));
    }

    public function response(array $rows, LengthAwarePaginator $data, string $url, array $extra = []): array
    {
        $response = [
            "success" => true,
            "create" => $this->create,
            "canView" => $this->canView,
            "canViewAny" => $this->canViewAny,
            "canEdit" => $this->canEdit,
            "canCreate" => $this->canCreate,
            "canDelete" => $this->canDelete,
            "canDeleteAny" => $this->canDeleteAny,
            "components" => $this->components(),
            "collection" => $data,
            "rows" => $rows,
            "url" => $url,
            "search" => $this->search,
            "per_page" => $this->per_page,
            "orderBy" => $this->orderBy,
            "desc" => $this->orderDirection,
            "filters" => $this->filters,
            "lang" => $this->loadTranslations(),
            "actions" => [],
            "modals" => [],
            "model" => $this->model,
            "form" => $this->form(),
            "table" => $this->table()
        ];

        return array_merge($response, $extra);
    }
}
