<?php

namespace Modules\Init\Helpers;

use Exception;
use Illuminate\Support\Facades\File;

class BaseHelper
{
    /**
     * @param string $path
     * @param array $ignoreFiles
     * @return array
     */
    public static function scanFolder(string $path, array $ignoreFiles = []): array
    {
        try {
            if (File::isDirectory($path)) {
                $data = array_diff(scandir($path), array_merge(['.', '..', '.DS_Store'], $ignoreFiles));
                natsort($data);
                return $data;
            }

            return [];
        } catch (Exception $exception) {
            return [];
        }
    }


    public static function getFileData(string $file, bool $convertToArray = true)
    {
        $file = File::get($file);
        if (!empty($file)) {
            if ($convertToArray) {
                return json_decode($file, true);
            }

            return $file;
        }

        if (!$convertToArray) {
            return null;
        }

        return [];
    }
}
