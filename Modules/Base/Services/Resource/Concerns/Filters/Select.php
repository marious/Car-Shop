<?php

namespace Modules\Base\Services\Resource\Concerns\Filters;

use Illuminate\Pagination\LengthAwarePaginator;

trait Select
{
    public function filterSelect(array $rows, $data)
    {
        $data->transform(function ($item) use ($rows){
            foreach ($rows as $row) {
                if ($row->vue === 'ViltSelect.vue' || $row->vue === 'ViltHasOne.vue') {
                    foreach ($row->options as $option) {
                        if(is_array($option)){
                            if ($option[$row->trackById] === $item[$row->name]) {
                                $item[$row->name] = $option;
                            }
                        }
                        else {
                            if ($option->{$row->trackById} === $item[$row->name]) {
                                $item[$row->name] = $option;
                            }
                        }
                    }
                }
            }

            return $item;

        });

        return $data;
    }
}
