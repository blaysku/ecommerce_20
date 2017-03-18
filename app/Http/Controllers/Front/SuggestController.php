<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Front\SuggestRequest;
use App\Helpers\FormatData;
use App\Models\Suggest;
use Auth;

class SuggestController extends Controller
{
    public function __invoke(SuggestRequest $request)
    {
        if ($request->ajax()) {
            try {
                $image = FormatData::upload($request, 'image', config('setting.suggest_image_folder'));
                $input = $request->all();
                $input['image'] = $image;
                $input['user_id'] = Auth::user()->id;

                if (!isset($image)) {
                    unset($input['avatar']);
                }

                Suggest::create($input);

                return response()->json();
            } catch (\Exception $e) {
                return response()->json([], 400);
            }
        }
    }
}
