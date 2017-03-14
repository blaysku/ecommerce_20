<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    protected $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $category = $request->get('category') ?: null;
        $price = $request->get('price') ?: null;
        $orderBy = $request->get('orderby') ?: null;
        $direction = $request->get('direction') ?: null;

        if ($request->ajax()) {
            $price = explode(',', $request->get('price'));
            $products = $this->product->getProductWithFilter($category, $price, $orderBy, $direction);

            return [
                'view' => view('front.products.data', compact('products'))->render(),
                'links' => e($products->appends([
                    'category' => $category,
                    'price' => $price,
                    'orderby' => $orderBy,
                    'direction' => $direction,
                ])->links()),
            ];
        }

        $products = $this->product->getProductWithFilter($category, $price, $orderBy, $direction);
        $links = $products->appends([
            'category' => $category,
            'price' => $price,
            'orderby' => $orderBy,
            'direction' => $direction,
        ])->links();

        return view('front.products.index', compact('products', 'links'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        try {
            $product = $this->product->findOrFail($id);
            $relatedProducts = $this->product->where('category_id', $product->category_id)->take(config('setting.front.limit'))->get();
            $trendingProducts = $this->product->whereIsTrending(config('setting.trending_product'))->take(config('setting.front.limit'))->get();

            if (auth()->user()) {
                $userRating = $product->ratings->where('user_id', auth()->id())->first();
                $recentlyProducts = $request->session()->get('recent_viewed');

                if (!is_array($recentlyProducts)) {
                    $recentlyProducts = [];
                }

                if (!in_array($product->id, $recentlyProducts)) {
                    $recentlyProducts[] = $product->id;
                }

                while (count($recentlyProducts) > config('setting.front.limit')) {
                    array_shift($recentlyProducts);
                }

                $request->session()->put('recent_viewed', $recentlyProducts);
                $recentlyProducts = $this->product->whereIn('id', $request->session()->get('recent_viewed'))->get() ;
            }

            return view('front.products.show', compact('product', 'relatedProducts', 'trendingProducts', 'userRating', 'recentlyProducts'));
        } catch (\Exception $e) {
            return view('front.404');
        }
    }
}
