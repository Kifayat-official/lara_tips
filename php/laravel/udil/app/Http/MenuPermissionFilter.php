<?php

namespace App\Http;

use JeroenNoten\LaravelAdminLte\Menu\Builder;
use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;
use Auth;

class MenuPermissionFilter implements FilterInterface
{
    public function transform($item, Builder $builder)
    {
        if( isset($item['submenu']) )
        {
            $hasPermissionToAtleastOneSubmenu = false;
            foreach($item['submenu'] as $submenu)
            {
                if (isset($submenu['permission']) && Auth::user()->hasPermission($submenu['permission'])) {
                    $hasPermissionToAtleastOneSubmenu = true;
                }
            }

            if($hasPermissionToAtleastOneSubmenu == true)
            {
                return $item;
            }
            else
            {
                return false;
            }
        }

        if (isset($item['permission']) && ! Auth::user()->hasPermission($item['permission'])) {
            return false;
        }

        return $item;
    }
}