<?php

namespace App\Models;

use App\Models\Heirarchy as ModelsHeirarchy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Heirarchy extends Model
{
    use HasFactory;

    public static function tree()
    {
        $allHeirarchies = Heirarchy::get();
        $rootHeirarchy = $allHeirarchies->whereNull('parent_id');

        self::formatTree($rootHeirarchy, $allHeirarchies);

        return $rootHeirarchy;
    }

    private static function formatTree($rootHeirarchy, $allHeirarchies)
    {
        foreach ($rootHeirarchy as $rootCategory) {
            $rootCategory->children = $allHeirarchies->where('parent_id', $rootCategory->id)->values();

            if ($rootCategory->children->isNotEmpty()) {
                self::formatTree($rootCategory->children, $allHeirarchies);
            }
        }
    }

    public function isChild()
    {
        return $this->parent_id !== null;
    }
}
