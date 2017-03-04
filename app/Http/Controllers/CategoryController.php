<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\CategoryCreateRequest;
use App\Http\Requests\CategoryUpdateRequest;
use DB;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryController extends Controller
{
    protected $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->category->rootCategories();

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryCreateRequest $request)
    {
        try {
            $this->category->create($request->all());

            return redirect()->back()->with('message', trans('admin.category.created'));
        } catch (Exception $e) {
            return redirect()->back()->with(['message' => trans('admin.main.error'), 'level' => 'danger']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $categories = $this->category->rootCategories();
            $thisCategory = $this->category->findOrFail($id);

            return view('admin.categories.edit', compact('categories', 'thisCategory'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('category.index')->with(['message' => trans('admin.main.error'), 'level' => 'danger']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryUpdateRequest $request, $id)
    {
        try {
            $user = $this->category->findOrFail($id);
            $user->update($request->all());

            return redirect()->back()->with('message', trans('admin.category.updated'));
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with(['message' => trans('admin.main.error'), 'level' => 'danger']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = $this->category->findOrFail($id);
        DB::beginTransaction();
        try {
            $products = [];

            if ($category->parent_id != config('setting.rootcategory')) {
                $products = $this->category->products->pluck('id')->toArray();
            }

            if (count($category->childrens)) {
                $childrens = $category->childrens->pluck('id')->toArray();
                $products = $this->category->getProductsThroughChildrens($id)->pluck('id')->toArray();
                $this->category->whereIn('id', $childrens)->delete();
            }

            Product::whereIn('id', $products)->delete();
            $category->delete();
            DB::commit();

            return redirect()->back()->with('message', trans('admin.category.destroyed'));
        } catch (Exception $e) {
            DB::rollback();

            return redirect()->back()->with(['message' => trans('admin.main.error'), 'level' => 'danger']);
        }
    }
}
