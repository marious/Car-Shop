<?php

namespace Modules\Base\Services\Resource\Concerns\Handlers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use  Modules\Base\Services\Resource\Abstracts\Query as QueryBuilder;

trait Query
{
    public ?string $model = null;

    public function query(Request $request, array $rows, bool $isAPI): LengthAwarePaginator
    {
        return QueryBuilder::create(app($this->model))
            ->modifyQuery(function ($query) use ($request, $isAPI, $rows) {
                $this->modifyQuery($query, $request, $isAPI, $rows);
            })
            ->processRequestAndGet(
                $request,
                $this->cols($rows),
                $this->searchable($rows),
                $this->filter($rows, $request),
            );
    }

    public function modifyQuery($query, Request $request, bool $isAPI, array $rows): void
    {
        $this->beforeIndexQuery($query, $request, $rows);

        if($isAPI){
            $this->beforeIndexQueryAPI($query, $request, $rows);
        }
        foreach ($rows as $row) {
            /*
             * Load Relation by JOIN for HasOne && HasMany
             */
            if (($row->vue === 'ViltRelation.vue') && $row->list) {
                $query->with($row->name);
            }
            else if (($row->vue === 'ViltHasOne.vue') && $row->list) {
                $query->with($row->relation);
            }

            /*
             * Load Relation by JOIN for HasOne && HasMany For API Without check List
             */
            if ($isAPI) {
                if (($row->vue === 'ViltRelation.vue') ) {
                    $query->with($row->name);
                }
                if (($row->vue === 'ViltHasOne.vue')) {
                    $query->with($row->relation);
                }
            }
        }

        $this->afterIndexQuery($query, $request, $rows);

        if($isAPI){
            $this->afterIndexQueryAPI($query, $request, $rows);
        }
    }

    public function cols(array $rows): array
    {
        return collect($this->rows())->where('list', true)
            ->where('vue', '!==', 'ViltMedia.vue')
            ->where('vue', '!==', 'ViltRelation.vue')
            ->where('over', '!==', true)
            ->pluck('name')->toArray();
    }

    public function searchable(array $rows): array
    {
        return collect($this->rows())->where('searchable', true)->pluck('name')->toArray();
    }

    public function filter(array $rows, Request $request): callable
    {
        return function ($query) use ($request) {
            $this->setFilters($query, $request);
        };
    }

    public function setFilters($query, Request $request): void {}

}
