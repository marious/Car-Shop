<?php

namespace Modules\Base\Services\Core\Concerns\Getters;

use Illuminate\Support\Facades\File;

trait Resources
{
    /**
     * @param $module
     * @return void
     */
    public static function loadResources($module): void
    {
        if(File::exists(module_path($module) . '/Vilt/Resources')){
            $files = File::files(module_path($module) . '/Vilt/Resources');
            foreach ($files as $file) {
                $fileName = $file->getRelativePathname();
                if (strpos($fileName, "Resource.php")) {
                    $path = $file->getPath();
                    $filterPath = str_replace(array(base_path() . 'Core.php/', base_path()), "", $path);
                    $className = str_replace("/", "\\", $filterPath . '/' . str_replace(".php", "", $fileName));
                    self::registerResource($className);
                }
            }
        }
    }
}
