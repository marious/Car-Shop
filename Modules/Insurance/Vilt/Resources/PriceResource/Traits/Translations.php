<?php


namespace Modules\Insurance\Vilt\Resources\PriceResource\Traits;

trait Translations
{
    public function loadTranslations(): array
    {
        return [
            "index" => __(" Prices"),
            "create" => __('Create ' . " Price"),
            "bulk" => __('Delete Selected ' . " Price"),
            "edit_title" => __('Edit ' . " Price"),
            "create_title" => __('Create New ' . " Price"),
            "view_title" => __('View ' . " Price"),
            "delete_title" => __('Delete ' . " Price"),
            "bulk_title" => __('Run Bulk Action To ' . " Price"),
        ];
    }
}

