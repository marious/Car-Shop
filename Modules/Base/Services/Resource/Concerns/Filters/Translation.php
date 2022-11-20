<?php

namespace Modules\Base\Services\Resource\Concerns\Filters;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

trait Translation
{
    public function filterTranslation(array $rows, $data)
    {
        foreach ($data as $item) {
            foreach ($rows as $row) {
                if ($row->vue === 'ViltTrans.vue') {
                    if (isset($item->{$row->name}->{app()->getLocale()})) {
                        $data->{$row->name} = $data->{$row->name}->{app()->getLocale()};
                    } else {
                        $data->{$row->name}  = "";
                    }
                }
            }
        }

        return $data;
    }
}
