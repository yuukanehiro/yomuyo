<?php

  namespace App\Http\Controllers;

  use Illuminate\Http\Request;
  use Validator,Redirect,Response,File;
  use Socialite;
  use App\User;
  use Auth;
  use App\Models\Review;
use PHPUnit\Framework\MockObject\Stub\Exception;

class SocialController extends Controller
{

    protected $redirectTo = '/mypage';

    public function redirect($provider)
    {
        // ユーザをSNS認証エンドポイントへリダイレクト
        return Socialite::driver($provider)->redirect();
    }


    public function callback($provider)
    {
        // ユーザ情報のインスタンスを取得
        try {
                $getInfo = Socialite::driver($provider)->user();
        }catch(Exception $e){
                return redirect('/login');
        }
        // if($provider == "twitter")
        // {
        //      $getInfo = Socialite::driver($provider)->user();
        // }else{
        //     $getInfo = Socialite::driver($provider)->stateless()->user();
        // }


        // $providerの指定で動的にSNS別のユーザインスタンスを作成
        $user = $this->createUser($getInfo,$provider);
    
        // そのままログイン
        Auth::login($user);
        return redirect($this->redirectTo);
    }


    function createUser($getInfo,$provider)
    {
        // IDを取得
        $user = User::where('provider_id', $getInfo->id)->first();
        // provider_idがuserテーブルに存在しないなら、テーブルに挿入
        if(!$user){
            $user = User::create([
                        'name'     => $getInfo->name,
                        'email'    => $getInfo->email,
                        'provider' => $provider,
                        'provider_id' => $getInfo->id
                    ]);
        }
        return $user;
    }
}
