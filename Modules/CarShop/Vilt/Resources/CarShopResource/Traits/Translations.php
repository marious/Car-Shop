<?php


namespace Modules\CarShop\Vilt\Resources\CarShopResource\Traits;

trait Translations
{
    public function loadTranslations(): array
    {
        return [
            "index" => __(" Car Shops"),
            "create" => __('Create ' . " Car Shop"),
            "bulk" => __('Delete Selected ' . " Car Shop"),
            "edit_title" => __('Edit ' . " Car Shop"),
            "create_title" => __('Create New ' . " Car Shop"),
            "view_title" => __('View ' . " Car Shop"),
            "delete_title" => __('Delete ' . " Car Shop"),
            "bulk_title" => __('Run Bulk Action To ' . " Car Shop"),
        ];
    }
}

