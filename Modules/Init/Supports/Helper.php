<?php

namespace Modules\Init\Supports;

use Illuminate\Support\Facades\File;

class Helper
{
    public static function autoload(string $directory): void
    {
        $helpers = File::glob($directory . '/*.php');
        foreach ($helpers as $helper) {
            File::requireOnce($helper);
        }
    }
}