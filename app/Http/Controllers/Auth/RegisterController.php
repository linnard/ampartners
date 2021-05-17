<?php

namespace App\Http\Controllers\Auth;

use App\Constants\User\Role;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
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
        $url_start = 'https://,http://';

        $rules = [
            'user.login'      => ['required', 'string', 'max:10', 'min:3', 'unique:users,login'],
            'user.firstname'  => ['required', 'alpha', 'max:255', 'min:2'],
            'user.lastname'   => ['required', 'alpha', 'max:255', 'min:2'],
            'user.patronymic' => ['required', 'alpha', 'max:255', 'min:4'],
            'password'        => ['required', 'string', 'min:3', 'confirmed'],

            'company.name'    => ['nullable', 'string', 'min:2', 'max:255'],
            'company.phone'   => ['nullable', 'numeric'],
            'company.viber'   => ['nullable', 'string', 'min:3'],

            'company.site'           => ['nullable', 'starts_with:'.$url_start,'url'],
            'company.license_url'    => ['nullable', 'starts_with:'.$url_start,'url'],
            'company.facebook_url'   => ['nullable', 'starts_with:'.$url_start,'url'],
            'company.instagram_url'  => ['nullable', 'starts_with:'.$url_start,'url'],
            'company.other_url'      => ['nullable', 'starts_with:'.$url_start,'url'],
            'company.additional_info'=> ['nullable', 'string'],
            'company.email'          => ['nullable', 'email'],
        ];

        return Validator::make($data, $rules);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $fields
     * @return \App\Models\User
     */
    protected function create(array $fields)
    {
        $fields['user']['password'] = bcrypt($fields['password']);
        $fields['user']['api_token'] = Str::random(60);

        $user = DB::transaction(function () use ($fields) {

            /* @var $user User */
            $user = User::create($fields['user']);

            $fields['company']['creator_id'] = $user->id;

            $user->companies()->create($fields['company']);

            $user->assignRole(Role::PARTNER);

            return $user;
        });

        return $user;
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        //$this->guard()->login($user);

        return $this->registered($request, $user) ?:
            redirect()->back()->with('success', __('register.success'));
    }

}
