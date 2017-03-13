<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use DB;

class HomeController extends Controller
{
    public function __invoke()
    {
        $query = Product::select('name', 'image', 'price', 'avg_rating')->take(config('setting.front.home-limit-take'));
        $topNews = (clone $query)->latest()->get();
        $topSellers = (clone $query)->whereHas('orderItem', function ($query) {
            $query->select(DB::raw('count(product_id) as count'), 'order_id')->groupBy('order_id')->orderBy('count', 'DESC');
        })->get();
        $topRatings = (clone $query)->latest('avg_rating')->get();
        $trendings = Product::select('image', 'name', 'price', 'avg_rating')->whereIsTrending(config('setting.trending_product'))->take(config('setting.front.home-trending-limit'))->get();

        return view('front.index', compact('topNews', 'topRatings', 'topSellers', 'trendings'));
    }
}
