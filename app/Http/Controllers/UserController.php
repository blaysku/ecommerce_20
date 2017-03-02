<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Support\Facades\Storage;

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
    public function index($role = null)
    {
        $users = $this->user->getUserByRole($role);
        $counts = $this->user->countUser();

        return view('admin.users.index', compact('users', 'counts'));
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

            if (Storage::exists(config('setting.avatars_folder') . $fileName)) {
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

        if (!isset($avatar)) {
            unset($input['avatar']);
        }

        $input['avatar'] = $avatar;
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

        if (!isset($avatar)) {
            unset($input['avatar']);
        }

        $input['avatar'] = $avatar;

        if ($avatar != config('setting.default_avatar')) {
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
}
