<?php

namespace Modules\Init\Repositories;

class RepositoryHelper
{
    public static function applyBeforeExecuteQuery($data, $model, bool $isSingle = false)
    {
        $filter = $isSingle ? BASE_FILTER_BEFORE_GET_ADMIN_SINGLE_ITEM : BASE_FILTER_BEFORE_GET_FRONT_PAGE_ITEM;

        return apply_filters($filter, $data, $model);
    }
}