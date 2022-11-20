<?php

namespace Modules\Base\Services\Resource\Concerns\Filters;

use Illuminate\Pagination\LengthAwarePaginator;

trait Query
{
    public function filterQuery(array $rows, LengthAwarePaginator $data, bool $isAPI): LengthAwarePaginator
    {
        foreach ($rows as $row) {
            if (($row->vue === 'ViltHasOne.vue') && $row->list && !empty($row->relation)) {
                foreach($data as $i=>$item){
                    $item->{$row->name} = $item->{$row->relation};
                    unset($item->{$row->relation});
                }
            }
            else if ($isAPI && ($row->vue === 'ViltHasOne.vue') && !empty($row->relation)) {
                foreach($data as $i=>$item){
                    unset($item->{$row->name});
                }
            }
        }

        return $data;
    }
}
