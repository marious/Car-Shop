<?php

namespace Modules\Base\Services\Resource\Concerns\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\Base\Services\Components\Base\Alert;

trait Destroy
{
    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse|\Inertia\Response|null
     */
    public function destory(Request $request, $id)
    {
        /*
         * Check if user has role to create a new record
         */
        if ($this->checkRoles('canDelete') && !$this->isAPI($request)) {
            return $this->checkRoles('canDelete');
        }

        /*
         * Fetch Record
         */
        $record = $this->model::find($id);

        /*
         * Check if Record Exists
         */
        if ($record) {
            /*
             * Add Hook Before
             */
            $request = $this->beforeDestroy($request, $record);

            /*
             * Remove Any Relation
             */
            foreach($this->rows() as $row){
                if($row->vue === 'ViltRelation.vue'){
                    $record->{$row->name}()->sync([]);
                }
            }

            /*
             * Delete Record
             */
            $record->delete();

            /*
             * Add Hook After
             */
            $this->afterDestroy($request, $id);

            /*
             * Make a message for response
             */
            $message = __(Str::ucfirst(Str::singular($this->table)) . " Deleted Success");

            /*
             * Response For API JSON
             */
            if ($this->isAPI($request)) {
                return response()->json([
                    "success" => true,
                    "message" => $message,
                    "data" => []
                ]);
            }

            return Alert::make($message)->fire();
        }

        /*
         * If Record Not found send 404
         */
        $message = __("Sorry Record Not Found");
        if ($this->isAPI($request)) {
            return response()->json([
                "success" => false,
                "message" => $message,
                "data" => []
            ], 404);
        }

        return Alert::make($message)->fire();
    }
}
