<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public static function tree()
    {
        $allCategories = Category::get();
        $rootCategories = $allCategories->whereNull('parent_id');

        self::formatTree($rootCategories, $allCategories);

        return $rootCategories;
    }

    private static function formatTree($rootCategories, $allCategories)
    {
        foreach ($rootCategories as $rootCategory) {
            $rootCategory->children = $allCategories->where('parent_id', $rootCategory->id)->values();

            if ($rootCategory->children->isNotEmpty()) {
                self::formatTree($rootCategory->children, $allCategories);
            }
        }
    }

    public function isChild()
    {
        dd($this);
        return $this->parent_id !== null;
    }
}
