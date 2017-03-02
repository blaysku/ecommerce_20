<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
