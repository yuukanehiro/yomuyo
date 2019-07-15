<?php

 namespace App\Http\Controllers;
 use Illuminate\Http\Request;
 use Validator,Redirect,Response,File;
 use Socialite;
 use App\User;

class SocialController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }


    public function callback($provider)
    {
        // ユーザ情報のインスタンスを取得
        $getInfo = Socialite::driver($provider)->user();
        // $providerの指定で動的にSNS別のユーザインスタンスを作成
        $user = $this->createUser($getInfo,$provider);
        auth()->login($user);
        return redirect()->to('/home');
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
