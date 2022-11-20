<?php


namespace Modules\Insurance\Vilt\Resources\CompanyResource\Traits;

trait Translations
{
    public function loadTranslations(): array
    {
        return [
            "index" => __(" Companys"),
            "create" => __('Create ' . " Company"),
            "bulk" => __('Delete Selected ' . " Company"),
            "edit_title" => __('Edit ' . " Company"),
            "create_title" => __('Create New ' . " Company"),
            "view_title" => __('View ' . " Company"),
            "delete_title" => __('Delete ' . " Company"),
            "bulk_title" => __('Run Bulk Action To ' . " Company"),
        ];
    }
}

