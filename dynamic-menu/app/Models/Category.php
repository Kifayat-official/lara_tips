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

    private static function formatTree($categories, $allCategories)
    {
        foreach ($categories as $category) {
            $category->childern = $allCategories->where('parent_id', $category->id)->values();
            if ($category->childern->isNotEmpty()) {
                self::formatTree($category->childern, $allCategories);
            }
        }
    }
}