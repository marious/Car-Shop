<?php


namespace Modules\Insurance\Vilt\Resources\CompanyPriceResource\Traits;

trait Translations
{
    public function loadTranslations(): array
    {
        return [
            "index" => __(" Company Prices"),
            "create" => __('Create ' . " Company Price"),
            "bulk" => __('Delete Selected ' . " Company Price"),
            "edit_title" => __('Edit ' . " Company Price"),
            "create_title" => __('Create New ' . " Company Price"),
            "view_title" => __('View ' . " Company Price"),
            "delete_title" => __('Delete ' . " Company Price"),
            "bulk_title" => __('Run Bulk Action To ' . " Company Price"),
        ];
    }
}

