<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Front\RatingRequest;
use App\Models\Rating;
use App\Models\Product;
use DB;

class RatingController extends Controller
{
    protected $rating;

    public function __construct(Rating $rating)
    {
        $this->rating = $rating;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RatingRequest $request)
    {
        if ($request->ajax()) {
            DB::beginTransaction();
            try {
                $rating = $this->rating->create($request->all());
                $product = Product::findOrFail($request->get('product_id'));
                $avgRating = $product->updateAvgRating();
                DB::commit();

                return response()->json([$rating->review, $avgRating, $product->ratings->count()]);
            } catch (\Exception $e) {
                DB::rollback();

                return response()->json([], 400);
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RatingRequest $request, $id)
    {
        if ($request->ajax()) {
            DB::beginTransaction();
            try {
                $rating = $this->rating->findOrFail($id);
                $rating->rating = $request->get('rating');
                $rating->review = $request->get('review');
                $rating->save();
                $avgRating = $rating->product->updateAvgRating();
                DB::commit();

                return response()->json([$rating->review, $avgRating, $rating->product->ratings->count()]);
            } catch (\Exception $e) {
                DB::rollback();

                return response()->json([], 400);
            }
        }
    }
}
