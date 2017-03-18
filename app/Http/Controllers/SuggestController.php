<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Suggest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Category;
use DB;

class SuggestController extends Controller
{
    protected $suggest;

    public function __construct(Suggest $suggest)
    {
        $this->suggest = $suggest;
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
            // $category = $request->get('category') == '' ? null : $request->get('category');
            $status = $request->get('status') == '' ? null : $request->get('status');
            // $quantity = $request->get('quantity') =='' ? null : $request->get('quantity');
            $orderBy = $request->get('orderby') == '' ? null : $request->get('orderby');
            $direction = $request->get('direction') == '' ? null : $request->get('direction');
            $take = $request->get('take') == '' ? null : $request->get('take');
            // $categories = Category::where('parent_id', 0)->get();
            $suggests = $this->suggest->filter($keyword, $status, $orderBy, $direction, $take);
            $suggests->appends($request->except('page'));

            return view('admin.suggests.index', compact('suggests'));
        } catch (\Exception $e) {
            return redirect()->route('suggest.index')->with(['message' => trans('admin.main.error'), 'level' => 'danger'])->withInput();
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
            $suggest = $this->suggest->findOrFail($id);

            return view('admin.suggests.show', compact('suggest'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('suggest.index')->with(['message' => trans('admin.main.error'), 'level' => 'danger']);
        }
    }

    public function reject(Request $request, $id)
    {
        try {
            $suggest = $this->suggest->findOrFail($id);
            $suggest->status = config('setting.sugget_reject');
            $suggest->save();

            return redirect()->back()->with('message', trans('admin.suggest.rejected'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('suggest.index')->with(['message' => trans('admin.main.error'), 'level' => 'danger']);
        }
    }

    public function accept($id)
    {
        try {
            $suggest = $this->suggest->findOrFail($id);
            $categories = (new Category)->rootCategories();

            return redirect()->route('product.create')->with('suggest', $suggest);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('suggest.index')->with(['message' => trans('admin.main.error'), 'level' => 'danger']);
        }
    }

    public function rejectMulti(Request $request)
    {
        if ($request->ajax()) {
            DB::beginTransaction();
            try {
                $idArray = $request->get('id', null);
                $status = $request->get('status');

                $this->suggest->whereIn('id', $idArray)->update(['status' => config('setting.sugget_reject')]);
                DB::commit();

                return response()->json();
            } catch (\Exception $e) {
                DB::rollback();

                return response()->json([trans('admin.main.error')], 400);
            }
        }
    }
}
