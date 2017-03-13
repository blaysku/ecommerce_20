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
    public function show($id)
    {
        //
    }
}
