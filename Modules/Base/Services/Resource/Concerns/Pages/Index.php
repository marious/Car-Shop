<?php

namespace Modules\Base\Services\Resource\Concerns\Pages;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

trait Index
{
    public function index(Request $request): JsonResponse | \Inertia\Response
    {
        /*
         * Check if the request come from API
         */
        $isAPI = $this->isAPI($request);

        /*
         * Add Hook before load data
         */
        $request = $this->beforeIndex($request);
        if($isAPI){
            $request = $this->beforeIndexAPI($request);
        }
        /*
         * Check if the user has permission to view the resource
         */
        $this->loadRoles();
        /*
         * Check if the user has permission or redirect 403
         */
        if ($this->checkRoles('canView') && !$isAPI) {
            return $this->checkRoles('canView');
        }

        /*
         * Load Rows Of The Current Resource
         */
        $rows = $this->rows();

        /*
         * Load Query For Current Model With Pagination and return collection
         */
        $data = $this->query($request, $rows, $isAPI);

        /*
         * Filter Data And Remove Unused Data from the collection
         */
        $this->filterQuery($rows,$data, $isAPI);

        /*
         * Process Media to preview on the table and API
         */
        $this->filterMedia($rows, $data);

        /*
         * Process Select Options to show to table and API
         */
        $this->filterSelect($rows, $data);

        /*
         * Process Select Options to show to table and API
         */
        $this->filterTranslation($rows, $data);

        /*
         * Process Filters back with response
         */
        $this->loadFilters($request);

        $this->afterIndex($data, $request);

        if($this->isAPI($request)){
            $this->afterIndexAPI($data, $request);
        }

        /*
         * Return response for API OR Inertia
         */
        return $this->loadResponse($rows, $data, $isAPI);
    }
}
