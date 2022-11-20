<?php

namespace Modules\Base\Services\Resource\Concerns\Process;

use Illuminate\Http\Request;

trait Media
{
    public function processMediaOnCreate(Request $request, $record): void
    {
        foreach ($this->rows() as $field) {
            if($field->vue === 'ViltMedia.vue') {
                if ($request->{$field->name} && is_array($request->{$field->name})) {
                    foreach ($request->{$field->name} as $item) {
                        $record->addMedia($item)
                            ->preservingOriginal()
                            ->toMediaCollection($field->name);
                    }
                }
            }
        }
    }

    public function processMediaOnUpdate(Request $request, $record): void
    {
        foreach ($this->rows() as $field) {
            if (($field->vue === 'ViltMedia.vue')) {
                if ($request->{$field->name} && is_array($request->{$field->name})) {
                    $hasNewMedia = false;
                    foreach ($request->{$field->name} as $item) {
                        if ($item->getClientOriginalName() !== 'blob') {
                            $hasNewMedia = true;
                        }
                    }
                    if ($hasNewMedia) {
                        $record->clearMediaCollection($field->name);
                        foreach ($request->{$field->name} as $item) {
                            $record->addMedia($item)
                                ->preservingOriginal()
                                ->toMediaCollection($field->name);
                        }
                    }
                }
                else if(empty($request->get($field->name))){
                    $record->clearMediaCollection($field->name);
                }
            }
        }
    }
}
