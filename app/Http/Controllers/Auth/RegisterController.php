<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Mail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';
    protected $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'phone' => 'numeric',
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $request->merge([
            'confirmation_code' => strtolower(str_random(50)),
        ]);

        $data = [
            'confirmationCode' => $request->confirmation_code,
        ];

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'address' => $request->address,
            'confirmation_code' => $request->confirmation_code,
        ]);

        $emailTo = $request->only('name', 'email');

        Mail::queue('auth.verify_email', $data, function ($message) use ($emailTo) {
            $message->to($emailTo['email'], $emailTo['name'])
                ->subject(trans('authentication.verify_email_title'));
        });

        return redirect()->back()->with('status', trans('authentication.check_mail'));
    }

    /**
     * Confirm user email before active account
     *
     * @param  $confirmationCode
     * @return mix
     */
    public function confirmEmail($confirmationCode)
    {
        if (!$confirmationCode) {
            return redirect()->route('index')->with('status', trans('authentication.incorrect_url'));
        }
        $user = $this->user->getUserbyConfirmationCode($confirmationCode);

        if (!$user) {
            return redirect()->route('index')->with('status', trans('authentication.invalid_code'));
        }

        $user->status = config('setting.activated_user_status');
        $user->confirmation_code = null;
        $user->save();

        $this->guard()->login($user);

        return redirect()->route('index')->with('status', trans('authentication.verify_success'));
    }
}
