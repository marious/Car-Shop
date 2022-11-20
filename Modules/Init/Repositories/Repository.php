<?php

namespace Modules\Init\Repositories;


class Repository
{
    public static function prepareData(object $data)
    {
        $collect = (array)$data;
        return array_map(function ($item) {
            if (is_object($item)) {
                return (array)$item;
            }
            return $item;
        }, $collect);
    }
}
