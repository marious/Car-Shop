<?php

namespace Modules\Init\Service\Generators\Traits;

use Illuminate\Support\Facades\File;
use phpDocumentor\Reflection\Types\Boolean;

trait FileManipulation
{
    protected function replaceFile($fileName, $ifExistsRegex, $find, $replaceWith): Boolean|Null
    {
        $content = File::get($fileName);
        if (preg_match($ifExistsRegex, $content)) {
            return null;
        }

        return File::put($fileName, str_replace($find, $replaceWith, $content));
    }


    protected function replaceAnyWay($fileName, $find, $replaceWith): Boolean
    {
        $content = File::get($fileName);
        return File::put($fileName, str_replace($find, $replaceWith, $content));
    }
}