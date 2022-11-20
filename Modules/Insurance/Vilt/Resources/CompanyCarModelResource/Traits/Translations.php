<?php


namespace Modules\Insurance\Vilt\Resources\CompanyCarModelResource\Traits;

trait Translations
{
    public function loadTranslations(): array
    {
        return [
            "index" => __(" Company Car Models"),
            "create" => __('Create ' . " Company Car Model"),
            "bulk" => __('Delete Selected ' . " Company Car Model"),
            "edit_title" => __('Edit ' . " Company Car Model"),
            "create_title" => __('Create New ' . " Company Car Model"),
            "view_title" => __('View ' . " Company Car Model"),
            "delete_title" => __('Delete ' . " Company Car Model"),
            "bulk_title" => __('Run Bulk Action To ' . " Company Car Model"),
        ];
    }
}

