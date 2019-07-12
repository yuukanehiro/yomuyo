<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Socialite;
use App\User;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    //ログインボタンからリンク
    public function socialLogin($social)
    {
        return Socialite::driver($social)->redirect();
    }

    //Callback処理
    public function handleProviderCallback($social)
    {
        //ソーシャルサービス（情報）を取得
        $userSocial = Socialite::driver($social)->stateless()->user();
        //emailで登録を調べる
        $user = User::where(['email' => $userSocial->getEmail()])->first();

        //登録（email）の有無で分岐
        if($user){

            //登録あればそのままログイン（2回目以降）
            Auth::login($user);
            return redirect('/home');

        }else{

            //なければ登録（初回）
            $newuser = new User;
            $newuser->name = $userSocial->getName();
            $newuser->email = $userSocial->getEmail();
            $newuser->save();

            //そのままログイン
            Auth::login($newuser);
            return redirect('/home');

        }
    }
}
