<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Format;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cart =  $request->session()->has('cart') ? $request->session()->get('cart') : null;

        return view('front.carts.index', compact('cart'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if ($request->ajax()) {
            try {
                $cart = new Cart(null);

                foreach ($request->all() as $cartItem) {
                    $cart->add(Product::findOrFail($cartItem['id']), $cartItem['id'], $cartItem['quantity']);
                }

                $request->session()->put('cart', $cart);
                $data = $request->session()->get('cart');

                return response()->json([
                    'totalPrice' => Format::currency($data->totalPrice),
                    'totalItems' => count($data->items),
                ]);
            } catch (\Exception $e) {
                return response()->json([], 400);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        if ($request->ajax()) {
            $oldCart = $request->session()->has('cart') ? $request->session()->get('cart') : null;
            $cart = new Cart($oldCart);

            if ($cart->removeItem($id)) {
                $request->session()->put('cart', $cart);
                $data = $request->session()->get('cart');

                return response()->json([
                    'totalPrice' => Format::currency($data->totalPrice),
                    'totalItems' => count($data->items),
                ]);
            }

            return response()->json([], 400);
        }
    }
}
