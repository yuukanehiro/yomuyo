<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;

class MypageController extends Controller
{
    public function __construct()
    {
        // authミドルウェア生成.認証の有無ををチェックする。
        // このコントローラで利用する関数すべてに影響を与える
        $this->middleware('auth');
    }

    /** ========================
    *    /mypage index表示
    *   ========================
    */
    public function index(Request $request)
    {
        $user = Auth::user(); // ログインユーザ情報取得

        // ユーザのレビュー情報取得
        $id   = $user->id;
        $review = new Review();
        $reviews = $review->getList(null, null, 5, $id);

        // レビュー投稿 書籍情報取得を取得してリダイレクト
        $item = $request;
        unset($item['_token']); // トークン削除
        return view('mypage.index', compact("user", "reviews", "item"));
    }



    /** ========================
    *    レビューの投稿
    *   ========================
    */
    public function post(Request $request)
    {
        $user = Auth::user();
        $review = new Review();
        $result = $review->create($request);

        // 投稿成功後の処理
        if($result == true){
            $id   = $user->id;
            $reviews = $review->getList(null, null, 5, $id);

            return view('mypage.index', ['user' => $user, 'reviews' => $reviews]);
        }
        else {
            echo "投稿に失敗しました";
            exit();
        }

    }

}
