<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Auth;

class OrderController extends Controller
{
    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $user = Auth::user();
            $order = $this->order->findOrFail($id);

            if ($user && $user->can('manage', $order)) {
                return view('front.orders.show', compact('order'));
            }

            return view('front.401');
        } catch (\Exception $e) {
            return view('front.404');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->ajax()) {
            try {
                $user = Auth::user();
                $order = $this->order->findOrFail($id);

                if ($user && $user->can('manage', $order)) {
                    $order->update(['status' => config('setting.cancel_order')]);

                    return response()->json();
                }

                return response()->json([], 400);
            } catch (\Exception $e) {
                return response()->json([], 400);
            }
        }
    }
}
