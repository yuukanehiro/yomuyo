<?php

  namespace App\Http\Controllers;

  use Illuminate\Http\Request;
  use Validator,Redirect,Response,File;
  use Socialite;
  use App\User;
  use Auth;
  use App\Models\Review;
  use Illuminate\Support\Facades\Log;
  use PHPUnit\Framework\MockObject\Stub\Exception;

class SocialController extends Controller
{
    // リダイレクト先
    protected $redirectTo   = '/mypage';
    protected $redirectPath = '/mypage';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }



    public function redirect($provider)
    {
        // SNS認証エンドポイントへリダイレクトして各SNSから許可をもらう
        return Socialite::driver($provider)->redirect();
    }



    public function callback($provider, Request $request)
    {
        // コールバックでエラーが発生した場合はログインページにリダイレクト
        if (! $request->input('code')) {
            \Session::flash(
                                'flash_error_message', 'ごめんなさい。ログインに失敗しました。<br/>' .
                                'エラー内容:SocialController@callback(): ' . $request->input('error') . ' - ' . $request->input('error_reason')
                           );
            Log::error(get_class() . ':SocialController@callback(): ' . $request->input('error') . ' - ' . $request->input('error_reason') );
            return redirect('/login');
        }


        try {
                // ユーザ情報のインスタンスを取得
                $getInfo = Socialite::driver($provider)->user();
                
                // $providerの指定で動的にSNS別のユーザインスタンスを作成
                $user = $this->createUser($getInfo, $provider);
            
                // そのままログイン
                Auth::login($user);
                return redirect($this->redirectTo);

        }catch(Exception $e){
                return redirect("/auth/login/{$provider}");
        }
    }



    function createUser($getInfo,$provider)
    {
        // IDを取得
        $user = User::where('provider_id', $getInfo->id)->first();

        // provider_idがuserテーブルに存在しないなら、テーブルに挿入
        if(!$user){
            $user = User::create([
                        'name'        => $getInfo->name,
                        'email'       => $getInfo->email,
                        'provider'    => $provider,
                        'provider_id' => $getInfo->id
                    ]);
        }
        return $user;
    }
}
