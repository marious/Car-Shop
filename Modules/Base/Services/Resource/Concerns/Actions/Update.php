<?php

namespace Modules\Base\Services\Resource\Concerns\Actions;

use Illuminate\Http\Request;
use Modules\Base\Services\Components\Base\Alert;

trait Update
{


    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Inertia\Response|void|null
     */
    public function update(Request $request, $id)
    {
        /*
         * Check if user has role to create a new record
         */
        if ($this->checkRoles('canEdit') && !$this->isAPI($request)) {
            return $this->checkRoles('canEdit');
        }

        /*
         * Check Request validation
         */
        $validator = $this->validUpdate($request, $id);

        if (!$validator->fails()) {

            /*
             * Select Record By ID
             */
            $record = $this->model::find($id);

            /*
             * Process Select to be ID
             */
            $this->processSelect($request);

            /*
             * Process translations to be AR / EN
             */
            $this->processTranslations($request, $record);

            /*
             * Make Hook Before Update
             */
            $request = $this->beforeUpdate($request, $record);
            if($this->isAPI($request)){
                $request = $this->beforeUpdateAPI($request, $record);
            }


            $record->update($request->all());

            /*
             * Process Media after update the record
             */
            $this->processMediaOnUpdate($request, $record);

            /*
             * Make Hook After Update
             */
            $this->afterUpdate($request, $record);
            if($this->isAPI($request)){
                $this->afterUpdateAPI($request, $record);
            }

            /*
             * Return JSON response if request is API
             */
            if ($this->isAPI($request)) {
                return response()->json([
                    "success" => true,
                    "message" => __($this->generateName(true, true) . " Updated Success"),
                    "data" => $record
                ]);
            }

            /*
             * Return Redirect Response if request is not API
             */
            return Alert::make(__($this->generateName(true, true) . " Updated Success"))->fire();
        }
    }
}
