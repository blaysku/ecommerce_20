<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DB;
use App\Models\Category;
use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductUpdateRequest;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    protected $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    protected function uploadImage($request)
    {
        if (!($request->hasFile('image'))) {
            return null;
        }

        $file = $request->file('image');
        $fileName = $file->getClientOriginalName();

        if (Storage::exists(config('setting.image_folder') . '/' .$fileName)) {
            $fileName = md5(time()) . $fileName;
        }

        $avatar = $file->storeAs(config('setting.image_folder'), $fileName);

        return $avatar;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->product->latest('is_trending')->latest()->paginate(config('setting.pagination_limit'));

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = (new Category)->rootCategories();

        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductCreateRequest $request)
    {
        try {
            $image = $this->uploadImage($request);
            $input = $request->all();

            if (isset($image)) {
                $input['image'] = $image;
            }

            $input['is_trending'] = isset($input['is_trending']) ? config('setting.trending_product') : config('setting.not_trending_product');
            $this->product->create($input);

            return redirect()->route('product.index')->with('message', trans('admin.category.created'));
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
            $product = $this->product->findOrFail($id);
            $categories = (new Category)->rootCategories();

            return view('admin.products.edit', compact('product', 'categories'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('product.index')->with(['message' => trans('admin.main.error'), 'level' => 'danger']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdateRequest $request, $id)
    {
        try {
            $product = $this->product->findOrFail($id);
            $image = $this->uploadImage($request);
            $input = $request->all();
            $input['image'] = $image;

            if (!isset($image)) {
                unset($input['image']);
            }

            if ($input['image'] != config('setting.default_image')) {
                Storage::delete($product->image);
            }

            $input['is_trending'] = isset($input['is_trending']) ? config('setting.trending_product') : config('setting.not_trending_product');
            $product->update($input);

            return redirect()->route('product.index', $product->id)->with('message', trans('admin.product.updated'));
        } catch (Exception $e) {
            return redirect()->route('product.index')->with(['message' => trans('admin.main.error'), 'level' => 'danger']);
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
        DB::beginTransaction();
        try {
            $product = $this->product->findOrFail($id);
            $product->ratings()->delete();
            $product->delete();
            DB::commit();

            return redirect()->back()->with('message', trans('admin.product.destroyed'));
        } catch (Exception $e) {
            DB::rollback();

            return redirect()->back()->with(['message' => trans('admin.main.error'), 'level' => 'danger']);
        }
    }

    public function changTrendingAjax(Request $request, $id)
    {
        if ($request->ajax()) {
            try {
                $product = $this->product->findOrFail($id);
                $isTrending = $request->get('trending') == 'true' ? config('setting.trending_product') : config('setting.not_trending_product');
                $product->is_trending = $isTrending;
                $product->save();
                return response()->json();
            } catch (Exception $e) {
                return response()->json([], 400);
            }
        }
    }
}
