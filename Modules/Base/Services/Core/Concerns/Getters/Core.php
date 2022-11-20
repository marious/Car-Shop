<?php

namespace Modules\Base\Services\Core\Concerns\Getters;

use App\Models\User;

trait Core
{
    public static function get(): array
    {
        $data = [
            "menus" => self::loadMenu(),
            "trans" => self::loadLanguage(),
            "appName" => config('app.name'),
            "appUrl" => url('/'),
            "message" => session()->get('message'),
        ];

        $share = self::loadShareData();

        if(auth('web')->user()){
            if(\Module::collections()->has('Notifications')){
                $share['notifications'] = get_notifications(10, User::class, auth('web')->user()->id);

                $share['token'] = auth('web')->user()->userTokensFcm ? auth('web')->user()->userTokensFcm->provider_token : false;
            }
        }

        return array_merge($data, $share);
    }
}
