<?php

namespace Modules\Base\Services\Core\Concerns\Load;

trait Translation
{
    private static ?array $translations = [];

    public static function loadLanguage(): array
    {
        $global = [
            "global.dashboard" => __('Dashboard'),
            "global.settings" => __('Settings'),
            "global.save" => __('Save'),
            "global.home" => __('Home'),
            "global.close" => __('Close'),
            "global.update" => __('Update'),
            "global.next" => __('Next'),
            "global.error.message" => __('Some Inputs is required'),
            "global.view" => __('View'),
            "global.edit" => __('Edit'),
            "global.delete" => __('Delete'),
            "global.create" => __('Create'),
            "global.search" => __('Search'),
            "global.pagination" => __('Pagination'),
            "pagination.next" => __('Next'),
            "pagination.previous" => __('Previous'),
            "global.pagination.from" => __('From'),
            "global.pagination.to" => __('To'),
            "global.pagination.results" => __('Results'),
            "global.pagination.per_page" => __('Per Page'),
            "global.bulk.message" => __('Do you when to run acction on selected items?'),
            "global.actions" => __('Actions'),
            "global.delete.message" => __('Do You when to delete this item?'),
            "global.filter.reset" => __('Reset Filter'),
            "global.show" => __('Show'),
            "global.to" => __('To'),
            "global.from" => __('From'),
            "global.of" => __('Of'),
            "global.results" => __('Results'),
            "global.per_page" => __('Per Page'),
            "global.new.item" => __('Add New Item'),
            "global.empty" => __('Sorry No Records is here change filter or create new one'),
        ];
        return array_merge($global, self::$translations);
    }
}
