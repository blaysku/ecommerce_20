<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Http\Requests\Front\CheckoutRequest;
use Format;
use Auth;
use DB;
use Mail;

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
            $oldCart = $request->session()->get('cart', null);
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

    public function showCheckout(Request $request)
    {
        $cart = $request->session()->get('cart', null);
        return view('front.carts.checkout', compact('cart'));
    }

    public function checkout(CheckoutRequest $request)
    {
        DB::beginTransaction();
        try {
            $cart = $request->session()->get('cart');
            $orderDetail = array_merge($request->only(['name', 'phone', 'address']), [
                'user_id' => Auth::user()->id,
                'total_price' => $cart->totalPrice,
                'status' => config('setting.waiting_order'),
            ]);

            foreach ($orderDetail as $key => $value) {
                if (!$value) {
                    unset($orderDetail[$key]);
                }
            }

            $orderItems = [];

            foreach ($cart->items as $productId => $item) {
                $orderItems[] = [
                    'product_id' => $productId,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ];

                Product::find($productId)->update(['quantity' => $item['restAmount']]);
            }

            $order = Order::create($orderDetail);
            $order->orderItems()->createMany($orderItems);
            $request->session()->forget('cart');
            DB::commit();
            Mail::queue('front.orders.order-email', ['order' => $order], function ($message) {
                $message->to(Auth::user()->email, Auth::user()->name)
                    ->subject(trans('front.cart.mail-subject'));
            });


            return response()->json();
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([], 400);
        }
    }
}
