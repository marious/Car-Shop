<?php

namespace Modules\Base\Services\Resource\Concerns\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Modules\Base\Services\Components\Base\Alert;

trait Bulk
{

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Inertia\Response|void|null
     * @throws \Illuminate\Validation\ValidationException
     */
    public function bulk(Request $request)
    {
        /*
         * Valid ID | ACTION
         */
        $rules = [
            "action" => "required",
            "ids" => "required|array",
        ];
        $validator = Validator::make($request->all(), $rules);
        $validator->validate();

        if (!$validator->fails()) {
            /*
             * Make Before Bulk Hook
             */
            $request = $this->beforeBulk($request);

            /*
             * Loop on selected IDs
             */
            foreach ($request->get('ids') as $key => $value) {
                /*
                 * Fetch Record
                 */
                $record = $this->model::find($key);

                /*
                 * Check Action Type
                 */
                if ($record && $request->get('action') === 'delete') {
                    /*
                     * Check if user has role to create a new record
                     */
                    if ($this->checkRoles('canDeleteAny') && !$this->isAPI($request)) {
                        return $this->checkRoles('canDeleteAny');
                    }

                    /*
                     * Check if Record Has Relations
                     */
                    foreach ($this->rows() as $row) {
                        if ($row->vue === 'relation') {
                            $record->{$row->name}()->sync([]);
                        }
                    }

                    /*
                     * Delete Selected Record
                     */
                    $record->delete();
                }
            }

            /*
             * Make After Bulk Hook
             */
            $this->afterBulk($request);

            /*
             * Set Message for response
             */
            $message = __(Str::ucfirst(Str::singular($this->table)) . " Bulk Action Success");

            /*
             * Return response for JSON
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
    }
}
