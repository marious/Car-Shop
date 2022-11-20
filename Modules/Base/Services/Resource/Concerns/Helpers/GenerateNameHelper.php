<?php

namespace Modules\Base\Services\Resource\Concerns\Helpers;

use Illuminate\Support\Str;

trait GenerateNameHelper
{
    public ?string $table = null;

    public function generateName(bool $single = false, bool $space = false): string
    {
        $explode = explode('_', $this->table);
        $tableName = "";
        $x = 1;
        foreach ($explode as $item) {
            if ($space && $single) {
                if ($x === count($explode)) {
                    $item = Str::singular(Str::ucfirst($item));
                } else {
                    $item = Str::ucfirst($item);
                }
                $tableName .= " " . $item;
                $x++;
            } else {
                $item = Str::ucfirst($item);
                $tableName .= " " . $item;
            }
        }

        return Str::ucfirst($tableName);
    }
}
