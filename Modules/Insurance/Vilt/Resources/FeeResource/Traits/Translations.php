<?php


namespace Modules\Insurance\Vilt\Resources\FeeResource\Traits;

trait Translations
{
    public function loadTranslations(): array
    {
        return [
            "index" => __(" Fees"),
            "create" => __('Create ' . " Fee"),
            "bulk" => __('Delete Selected ' . " Fee"),
            "edit_title" => __('Edit ' . " Fee"),
            "create_title" => __('Create New ' . " Fee"),
            "view_title" => __('View ' . " Fee"),
            "delete_title" => __('Delete ' . " Fee"),
            "bulk_title" => __('Run Bulk Action To ' . " Fee"),
        ];
    }
}

