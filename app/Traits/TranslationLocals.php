<?php


namespace App\Traits;


use Modules\Base\Services\Rows\Text;

trait TranslationLocals
{


    public function getTranslationLocals(){
        $getLocals = config('translations.locals');
        $loadLocalsLocals = [];
        foreach ($getLocals as $key => $value) {
            $loadLocalsLocals[] = Text::make($key)->label($value);
        }
        return $loadLocalsLocals;
    }
}
