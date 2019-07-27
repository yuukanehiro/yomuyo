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

    public function index(Request $request)
    {
        $user = Auth::user(); // ログインユーザ情報取得
        $id   = $user->id; 
        $review = new Review();
        $reviews = $review->getList(null, null, 5, $id);

        return view('mypage.index', compact("user", "reviews"));
    }

}
