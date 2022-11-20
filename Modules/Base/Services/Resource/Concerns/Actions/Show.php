<?php

namespace Modules\Base\Services\Resource\Concerns\Actions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

trait Show
{
    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse|\Inertia\Response
     */
    public  function show(Request $request, $id): JsonResponse | \Inertia\Response
    {
        /*
         * Check if user has role to create a new record
         */
        if ($this->checkRoles('canViewAny') && !$this->isAPI($request)) {
            return $this->checkRoles('canViewAny');
        }

        /*
         * Create a new query
         */
        $query = $this->model::query();

        /*
         * Select Record By ID
         */
        $query->find($id);

        /*
         * Set JOIN to relation
         */
        $this->filterRelation($query);

        /*
         * Make a Hook before get Query
         */
        $this->beforeShowQuery($query, $request, $this->rows());
        if($this->isAPI($request)){
            $this->beforeShowQueryAPI($query, $request, $this->rows());
        }

        /*
         * Get Query
         */
        $record = $query->select(collect($this->rows())->where('view', true)
            ->where('vue', '!=', 'ViltMedia.vue')
            ->where('vue', '!=', 'ViltRelation.vue')
            ->where('over', '!=', true)
            ->pluck('name')->toArray())->first();

        /*
         * Make a Hook after get Query
         */
        $this->afterShowQuery($record, $request, $this->rows());
        if($this->isAPI($request)){
            $this->afterShowQueryAPI($record, $request, $this->rows());
        }

        /*
         * Make Hook Before Show Data
         */
        $record = $this->beforeShow($request, $record);
        if($this->isAPI($request)){
            $record = $this->beforeShowAPI($request, $record);
        }

        /*
         * Load Media To Record
         */
        $record = $this->filterMedia($this->rows(), collect([$record]))->first();

        /*
         * Process Select to return Object
         */
        $record = $this->filterSelect($this->rows(),collect([$record]))->first();

        /*
         * Process Translation to return select local value
         */
        $record = $this->filterTranslation($this->rows(),collect([$record]))->first();


        /*
         * Unset Unused Data
         */
        $this->unsetShowData($record);

        /*
         * Make Hook After Show Data
         */
        $this->afterShow($request, $record);
        if($this->isAPI($request)){
            $this->afterShowAPI($request, $record);
        }

        /*
         * Return JSON Response For API / Inertia
         */
        return response()->json([
            "success" => true,
            "message" => __($this->generateName(true, true) . " Loaded Success"),
            "data" => $record
        ]);
    }

    public function unsetShowData($record): void
    {
        foreach($this->rows() as $row) {
            if ($row->vue === 'ViltHasOne.vue' && !empty($row->relation)) {
                $record->{$row->name} = $record->{$row->relation};
                unset($record->{$row->relation});
            }
        }
    }
}
