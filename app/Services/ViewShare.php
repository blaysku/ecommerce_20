<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Facades\View;

class ViewShare
{
    public static function boot()
    {
        $categories = (new Category)->rootCategories();
        View::share('categories', $categories);
    }
}
