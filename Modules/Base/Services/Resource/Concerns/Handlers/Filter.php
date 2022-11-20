<?php

namespace Modules\Base\Services\Resource\Concerns\Handlers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

trait Filter
{
    public ?bool $create = false;
    public ?string $search = null;
    public ?int $per_page = 10;
    public ?string $orderBy = "id";
    public ?string $orderDirection = "desc";
    public ?array $filters = [];

    public function loadFilters(Request $request): void
    {
        if ($request->has('create')) {
            $this->create = true;
        }
        if ($request->has('search') && !empty($request->has('search'))) {
            $this->search = $request->get('search');
        }
        if ($request->has('per_page')) {
            $this->per_page = $request->get('per_page');
        }
        if ($request->has('orderBy')) {
            $this->orderBy = $request->get('orderBy');
            $this->orderDirection = $request->get('orderDirection');
        }

        if(isset($this->table()->filters) && !empty($this->table()->filters))
        foreach($this->table()->filters as $filter){
            if ($request->has($filter->name)) {
                foreach($filter->rows as $row){
                    if(!empty($row->model)){
                        $this->filters[$filter->name] = $row->model::find($request->get($filter->name));
                    }
                    else {
                        $this->filters[$filter->name] = $request->get($filter->name);
                    }
                }
            }
        }
    }
}
