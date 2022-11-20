<?php

namespace Modules\Base\Services\Resource\Concerns\Handlers;

use Modules\Base\Helpers\Resources\Lang;

trait Translation
{
    public ?string $resourceTitle = null;

    public function loadTranslations(): array
    {
        $translations = [
            "index" => __($this->generateName()),
            "create" => __('Create ' . $this->generateName(true, true)),
            "bulk" => __('Delete Selected ' . $this->generateName(true, true)),
            "edit_title" => __('Edit ' . $this->generateName(true, true)),
            "create_title" => __('Create New ' . $this->generateName(true, true)),
            "view_title" => __('View ' . $this->generateName(true, true)),
            "delete_title" => __('Delete ' . $this->generateName(true, true)),
            "bulk_title" => __('Run Bulk Action To ' . $this->generateName(true, true)),
        ];

        if (!empty($this->resourceTitle)) {
            $translations['index'] = $this->resourceTitle;
        }

        return array_merge($this->translationsHook(), $translations);
    }

    public function translationsHook(): array {
        return [];
    }
}
