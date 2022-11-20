<?php


namespace Modules\Insurance\Vilt\Resources\CompanyFeeResource\Traits;

trait Translations
{
    public function loadTranslations(): array
    {
        return [
            "index" => __(" Company Fees"),
            "create" => __('Create ' . " Company Fee"),
            "bulk" => __('Delete Selected ' . " Company Fee"),
            "edit_title" => __('Edit ' . " Company Fee"),
            "create_title" => __('Create New ' . " Company Fee"),
            "view_title" => __('View ' . " Company Fee"),
            "delete_title" => __('Delete ' . " Company Fee"),
            "bulk_title" => __('Run Bulk Action To ' . " Company Fee"),
        ];
    }
}

