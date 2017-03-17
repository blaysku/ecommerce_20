<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Helpers\FormatData;
use Storage;
use App\Http\Requests\Front\UserUpdateRequest;
use Auth;

class UserController extends Controller
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
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
            $user = $this->user->findOrFail($id);

            return view('front.users.show', compact('user'));
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
    public function update(UserUpdateRequest $request)
    {
        if ($request->ajax()) {
            try {
                $user = Auth::user();
                $avatar = FormatData::upload($request, 'avatar', config('setting.avatars_folder'));
                $input = $request->all();
                $input['avatar'] = $avatar;

                if (!isset($avatar)) {
                    unset($input['avatar']);
                } elseif ($input['avatar'] != config('setting.default_avatar')) {
                    Storage::delete($user->avatar);
                }

                if ($input['password'] == '') {
                    unset($input['password']);
                }

                $user->update($input);

                return response()->json();
            } catch (\Exception $e) {
                return response()->json([], 400);
            }
        }
    }
}
