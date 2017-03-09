<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Suggest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Category;

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
    public function index()
    {
        $suggests = $this->suggest->oldest('status')->latest()->paginate(config('setting.pagination_limit'));

        return view('admin.suggests.index', compact('suggests'));
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
}
