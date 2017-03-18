<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Support\Facades\Storage;
use DB;
use Auth;

class UserController extends Controller
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $role = null)
    {
        try {
            $keyword = $request->get('keyword') == '' ? null : $request->get('keyword');
            $role = $request->get('role') == '' ? null : $request->get('role');
            $status = $request->get('status') == '' ? null : $request->get('status');
            $orderBy = $request->get('orderby') == '' ? null : $request->get('orderby');
            $direction = $request->get('direction') == '' ? null : $request->get('direction');
            $take = $request->get('take') == '' ? null : $request->get('take');

            $users = $this->user->filter($keyword, $role, $status, $orderBy, $direction, $take);
            $users->appends($request->except('page'));

            return view('admin.users.index', compact('users'));
        } catch (\Exception $e) {
            return redirect()->route('user.index')->with(['message' => trans('admin.main.error'), 'level' => 'danger'])->withInput();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    protected function uploadAvatar($request)
    {
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $fileName = $file->getClientOriginalName();

            if (Storage::exists(config('setting.avatars_folder') . '/' . $fileName)) {
                $fileName = md5(time()) . $fileName;
            }

            $avatar = $file->storeAs(config('setting.avatars_folder'), $fileName);

            return $avatar;
        }

        return null;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserCreateRequest $request)
    {
        $avatar = $this->uploadAvatar($request);
        $input = $request->all();

        if (isset($avatar)) {
            $input['avatar'] = $avatar;
        }

        $input['status'] = isset($input['status']) ? config('setting.activated_user_status') : config('setting.not_activated_user_status');

        $user = $this->user->create($input);

        if ($user) {
            return redirect()->route('user.show', $user->id)->with('message', trans('admin.user.created'));
        }

        return redirect()->back()->with(['message' => trans('admin.main.error'), 'level' => 'danger']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->user->findOrFail($id);

        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->user->findOrFail($id);

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $user = $this->user->findOrFail($id);
        $avatar = $this->uploadAvatar($request);
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

        $input['status'] = isset($input['status']) ? config('setting.activated_user_status') : config('setting.not_activated_user_status');
        $user->update($input);

        return redirect()->route('user.show', $user->id)->with('message', trans('admin.user.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (auth()->id() == $id) {
            return redirect()->back()->with(['message' => trans('admin.user.delete-fail'), 'level' => 'danger']);
        }

        $user = $this->user->findOrFail($id);
        $user->delete();

        return redirect()->back()->with('message', trans('admin.user.destroyed'));
    }

    public function changeStatusWithAjax($id, Request $request)
    {
        if ($request->ajax()) {
            if (auth()->id() == $id) {
                return response()->json([], 400);
            }

            $user = $this->user->findOrFail($id);
            $status = $request->get('status') == 'true' ? config('setting.activated_user_status') : config('setting.not_activated_user_status');
            $user->status = $status;

            if (($user->save())) {
                return response()->json();
            }

            return response()->json([], 400);
        }
    }

    public function changeStatusMultiUser(Request $request)
    {
        if ($request->ajax()) {
            DB::beginTransaction();
            try {
                $idArray = $request->get('id', null);
                if ($request->get('status') == 0 && in_array(Auth::user()->id, $idArray)) {
                    return response()->json(["Can't deactive yourself!"], 400);
                }
                $this->user->whereIn('id', $idArray)->update(['status' => $request->get('status')]);
                DB::commit();

                return response()->json();
            } catch (\Exception $e) {
                DB::rollback();

                return response()->json(['error' => trans('admin.main.error')], 400);
            }
        }
    }

    public function destroyMultiUser(Request $request)
    {
        if ($request->ajax()) {
            DB::beginTransaction();
            try {
                $idArray = $request->get('id', null);
                if (in_array(Auth::user()->id, $idArray)) {
                    return response()->json([trans('admin.user.delete-fail')], 400);
                }
                $this->user->whereIn('id', $idArray)->delete();
                DB::commit();

                return response()->json();
            } catch (\Exception $e) {
                DB::rollback();

                return response()->json([trans('admin.main.error')], 400);
            }
        }
    }
}
