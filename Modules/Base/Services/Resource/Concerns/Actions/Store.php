<?php

namespace Modules\Base\Services\Resource\Concerns\Actions;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Modules\Base\Services\Components\Base\Alert;

trait Store
{

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Inertia\Response|void|null
     */
    public function store(Request $request)
    {
        /*
         * Check if user has role to create a new record
         */
        if ($this->checkRoles('canCreate') && !$this->isAPI($request)) {
            return $this->checkRoles('canCreate');
        }

        /*
         * Check Request validation
         */
        $validator = $this->validStore($request);

        if (!$validator->fails()) {

            /*
             * Convert select object to Ids
             */
            $this->processSelect($request);

            /*
             * Process translations to be AR / EN
             */
            $this->processTranslations($request);

            /*
             * Hook before store
             */
            $data = $this->beforeStore($request);

            /*
             * Hook before store for API Case
             */
            if($this->isAPI($request)){
                $data = $this->beforeStoreAPI($request);
            }

            $record = $this->model::create($data->all());

            /*
             * Append Media To current Record
             */
            $this->processMediaOnCreate($request, $record);

            /*
             * Hook after store
             */
            $this->afterStore($request, $record);

            /*
             * Hook before store for API Case
             */
            if($this->isAPI($request)){
                $this->afterStoreAPI($request, $record);
            }

            /*
             * Return JSON response if request is API
             */
            if ($this->isAPI($request)) {
                return response()->json([
                    "success" => true,
                    "message" => __($this->generateName(true, true) . " Created Success"),
                    "data" => $record
                ]);
            }

            /*
             * Redirect to record list page with success message
             */
            return Alert::make(__($this->generateName(true, true) . " Created Success"))->fire();
        }
    }
}
