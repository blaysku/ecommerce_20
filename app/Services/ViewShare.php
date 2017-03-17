<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\View;

class ViewShare
{
    public static function boot()
    {
        $categories = (new Category)->rootCategories();
        $trendingProducts = Product::whereIsTrending(config('setting.trending_product'))->take(config('setting.front.limit'))->get();
        View::share([
            'categories' => $categories,
            'trendingProducts' => $trendingProducts,
        ]);
    }
}
