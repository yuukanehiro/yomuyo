<?php

  namespace App\Http\Controllers;

  use Illuminate\Http\Request;
  use Validator,Redirect,Response,File;
  use Socialite;
  use App\User;
  use Auth;
  use App\Models\Review;

class SocialController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }


    public function callback($provider)
    {
        // ユーザ情報のインスタンスを取得
        if($provider == "twitter")
        {
             $getInfo = Socialite::driver($provider)->user();
        }else{
            $getInfo = Socialite::driver($provider)->stateless()->user();
        }


        // $providerの指定で動的にSNS別のユーザインスタンスを作成
        $user = $this->createUser($getInfo,$provider);
    
        // そのままログイン
        //auth()->login($user);
        Auth::login($user);

        // ユーザのレビュー情報取得
        $user_id   = User::where('provider_id', $getInfo->id)->first();
        $review = new Review();
        $reviews = $review->getList(null, null, 5, $user_id);

        return view('mypage.index', compact("user", "reviews"));
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
