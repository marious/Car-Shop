<?php

namespace Modules\Base\Services\Resource\Concerns\Filters;

use Illuminate\Pagination\LengthAwarePaginator;

trait Media
{
    public function filterMedia(array $rows, $data)
    {
        return $data->map(function($item) use ($rows){

            foreach ($rows as $field) {
                if ($field->vue === 'ViltMedia.vue') {
                    if (count($item->getMedia($field->name))) {
                        if ($field->multi) {
                            $arrayImages = [];
                            foreach ($item->getMedia($field->name) as $imageItem) {
                                $arrayImages[] = $imageItem->getUrl();
                            }
                            $item->{$field->name} = $arrayImages;
                        } else {
                            $item->{$field->name} = $item->getMedia($field->name)->first()->getUrl();
                        }
                    } else {
                        $item->{$field->name} = null;
                    }
                }
            }
            unset($item->media);
            return $item;
        });
    }
}
