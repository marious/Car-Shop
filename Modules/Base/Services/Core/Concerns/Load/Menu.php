<?php

namespace Modules\Base\Services\Core\Concerns\Load;

use Illuminate\Support\Collection;

trait Menu
{
    /**
     * @return Collection
     */
    public static function loadMenu(): Collection
    {
        $menus = collect(self::$menu)->groupBy('key');
        $menus->transform(function ($menu){
            $menu = collect($menu);
            $groups = $menu->sortBy('sort')->groupBy('group');
            $groups->transform(fn($item, $k) => collect($item)->filter(function ($item){
                if($item->can && is_string($item->can) && auth()->user() && auth()->user()->can($item->can)){
                    return $item;
                }

                if(!is_string($item->can) && $item->can){
                    return $item;
                }

                return false;
            }));

            return $groups->map(fn($item, $k) => [
                'label' => $k,
                'menu' => $item,
                'icon' => "bx bx-menu"
            ])->filter(fn($item) => $item['menu']->count() > 0);
        });

        return $menus;
    }
}
