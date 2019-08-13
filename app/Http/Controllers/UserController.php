<?php

  namespace App\Http\Controllers;

  use Illuminate\Http\Request;
  use App\Models\Review;
  use App\Models\Comment;
  use App\Models\Following;
  use Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $review_user_id = (int) $request->user_id;

        // ユーザのレビュー情報取得
        $review  = new Review();
        $reviews = $review->getList(null, null, 5, $review_user_id);

        // フォローしている数を取得
        $following = new following();
        $cnt_following = $following->getCount($review_user_id);

        //var_dump($cnt_following);
        //exit();

        // ログインしているユーザがフォローしているかを判定
        if (Auth::check() == true) {
            $login_user_id = Auth::id();
            $following_flag = $following->isExist($review_user_id, $login_user_id);
            return view('user.index', ["reviews" => $reviews, "cnt_following" => $cnt_following, "following_flag" => $following_flag]);
        }else{
          return view('user.index', ["reviews" => $reviews, "cnt_following" => $cnt_following]);
        }
    }
}
