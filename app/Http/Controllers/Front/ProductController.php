<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Cart;
use Format;

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
        try {
            $keyword = $request->get('keyword') == '' ? null : $request->get('keyword');
            $category = $request->get('category') == '' ? null : $request->get('category');
            $price = $request->get('price') == '' ? null : $request->get('price');
            $orderBy = $request->get('orderby') == '' ? null : $request->get('orderby');
            $direction = $request->get('direction') == '' ? null : $request->get('direction');

            if ($request->ajax()) {
                $price = explode(',', $request->get('price'));
                $products = $this->product->getProductWithFilter($keyword, $category, $price, $orderBy, $direction);

                return [
                    'view' => view('front.products.data', compact('products'))->render(),
                    'links' => e($products->appends([
                        'keyword' => $keyword,
                        'category' => $category,
                        'price' => $price,
                        'orderby' => $orderBy,
                        'direction' => $direction,
                    ])->links()),
                ];
            }

            $products = $this->product->getProductWithFilter($keyword, $category, $price, $orderBy, $direction);
            $links = $products->appends([
                'keyword' => $keyword,
                'category' => $category,
                'price' => $price,
                'orderby' => $orderBy,
                'direction' => $direction,
            ])->links();

            return view('front.products.index', compact('products', 'links'));
        } catch (\Exception $e) {
            $products = $links = null;

            return view('front.products.index', compact('products', 'links'));
        }
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
            $storedCart = $request->session()->has('cart') ? $request->session()->get('cart') : null;

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

            return view('front.products.show', compact('product', 'relatedProducts', 'trendingProducts', 'userRating', 'recentlyProducts', 'storedCart'));
        } catch (\Exception $e) {
            return view('front.404');
        }
    }

    public function addToCart(Request $request, $id)
    {
        if ($request->ajax()) {
            try {
                $product = $this->product->findOrFail($id);
                $oldCart = $request->session()->has('cart') ? $request->session()->get('cart') : null;
                $cart = new Cart($oldCart);

                if ($product->quantity == 0 || (count($oldCart) && array_key_exists($id, $oldCart->items) && $oldCart->items[$id]['restAmount'] == 0)) {
                    return response()->json(['error' => trans('front.cart.out-of-stock')], 400);
                }

                $cart->add($product, $product->id, $request->get('quantity'));
                $request->session()->put('cart', $cart);
                $data = $request->session()->get('cart');

                return response()->json([
                    'totalPrice' => Format::currency($data->totalPrice),
                    'totalItems' => count($data->items),
                    'restAmount' => $data->items[$id]['restAmount'],
                ]);
            } catch (\Exception $e) {
                return response()->json(['error' => trans('admin.main.error')], 400);
            }
        }
    }
}
