<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DB;

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
    public function index(Request $request)
    {
        try {
            $keyword = $request->get('keyword') == '' ? null : $request->get('keyword');
            $status = $request->get('status') == '' ? null : $request->get('status');
            $orderBy = $request->get('orderby') == '' ? null : $request->get('orderby');
            $direction = $request->get('direction') == '' ? null : $request->get('direction');
            $take = $request->get('take') == '' ? null : $request->get('take');

            $orders = $this->order->filter($keyword, $status, $orderBy, $direction, $take);
            $orders->appends($request->except('page'));

            return view('admin.orders.index', compact('orders'));
        } catch (\Exception $e) {
            return redirect()->route('order.index')->with(['message' => trans('admin.main.error'), 'level' => 'danger'])->withInput();
        }
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

    public function updateMulti(Request $request)
    {
        if ($request->ajax()) {
            DB::beginTransaction();
            try {
                $idArray = $request->get('id', null);
                $status = $request->get('status');

                $this->order->whereIn('id', $idArray)->update(['status' => $status]);
                DB::commit();

                return response()->json();
            } catch (\Exception $e) {
                DB::rollback();

                return response()->json(['error' => trans('admin.main.error')], 400);
            }
        }
    }
}
