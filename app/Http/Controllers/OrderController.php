<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OrderController extends Controller
{
    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = $this->order->oldest('status')->latest()->paginate(config('setting.pagination_limit'));

        return view('admin.orders.index', compact('orders'));
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
            $order = $this->order->findOrFail($id);

            return view('admin.orders.show', compact('order'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('order.index')->with(['message' => trans('admin.main.error'), 'level' => 'danger']);
        }
    }

    public function changeStatusWithAjax(Request $request, $id)
    {
        if ($request->ajax()) {
            try {
                $order = $this->order->findOrFail($id);
                $status = $request->get('status') == 'true' ? config('setting.done_order') : config('setting.waiting_order');
                $order->status = $status;
                $order->save();
                return response()->json();
            } catch (ModelNotFoundException $e) {
                return response()->json([], 400);
            }
        }
    }
}
