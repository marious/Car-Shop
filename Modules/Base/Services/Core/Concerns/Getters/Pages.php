<?php

namespace Modules\Base\Services\Core\Concerns\Getters;

use Illuminate\Support\Facades\File;

trait Pages
{
    public static function loadPages($module)
    {
        $files = File::files(module_path($module) . '/Pages');
        foreach ($files as $file) {
            $fileName = $file->getRelativePathname();
            if (strpos($fileName, "Page.php")) {
                $path = $file->getPath();
                $filterPath = str_replace(base_path(), "", str_replace(base_path() . 'Core.php/', "", $path));
                $className = str_replace("/", "\\", $filterPath . '/' . str_replace(".php", "", $fileName));
                self::registerPage($className);
            }
        }
    }
}
