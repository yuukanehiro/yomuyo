<?php

  namespace App\Http\Controllers;

  use Illuminate\Http\Request;
  use Response;
  use Log;
  use App\Models\Following;
  use App\Models\Followed;
  use App\Models\Review;
  use App\User;
  use Exception;
  use Auth;


class FollowController extends Controller
{
    public function __construct()
    {
        // authミドルウェア生成.認証の有無ををチェックする。
        // このコントローラで利用する関数すべてに影響を与える
        $this->middleware('auth');
    }


    public function index(Request $request)
    {
        $login_user = Auth::user(); // ログインユーザ情報取得

        $request = $request->all();
        unset($request['_token']);
        $user = User::find($request['user_id']);

        // ログインしているユーザがフォローしているかを判定
        $following = new following();
        $following_flag = $following->isExist($user->id, $login_user->id);

        $following_recs = $following->getList($user->id);
        
        return view('mypage.following.index', [
                                                   "user"           => $user,
                                                   "login_user"     => $login_user,
                                                   "request"        => $request,
                                                   "following_flag" => $following_flag,
                                                   "following_recs" => $following_recs
                                              ]);
    }

    public function create(Request $request)
    {
        try {
                $request = $request->all();
                unset($request['_token']);
                $follow_user_id  = (int) $request['follow_user_id'];     // フォロー対象のユーザID
                $login_user_id   = (int) $request['login_user_id'];      // フォローボタンを押したログインユーザのID
        
                // 異常データが入らないようにチェックする
                if($follow_user_id == $login_user_id)
                {
                    \Session::flash(
                                        'flash_error_message', 'システムエラー：自分自身をフォローすることはできません。システムエラー：' .
                                        'エラー内容:FollowController@create(): ' . 'システムエラー：自分自身をフォローすることはできません。'
                                   );
                    Log::error(get_class() . ':FollowController@create(): ' . 'システムエラー：自分自身をフォローすることはできません。');
                    throw new Exception("エラー内容:FollowController@create(): システムエラー：自分自身をフォローすることはできません。");
                }

                // フォローデータ挿入
                $following = new Following();
                $response = $following->insert($follow_user_id, $login_user_id);

                echo $response['cnt_following']; //いいね総数/レビューID
                Log::info($response);
            } catch (Exception $e) {
                die($e->getMessage());
            }
    }
}
