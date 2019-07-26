<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // authミドルウェア生成.認証の有無ををチェックする。
        // このコントローラで利用する関数すべてに影響を与える
        $this->middleware('auth'); 
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $user = Auth::user(); // ログインユーザ情報取得
        // 書籍情報取得
        $item = $request;   
        unset($item['_token']); // トークン削除
        return view('home', ['user' => $user, 'item' => $item]);
    }

    /**
    * 感想の投稿
    *
    */
    public function post(Request $request)
    {
        $item = $request->all();
        unset($item['_token']); // トークン削除 

        $user = Auth::user();
        $review = new Review();
        $val = $review->create($form);

        if($val == true){
            return view('mypage.index', ['user' => $user, 'item' => $item]);
        }
        else {
            echo "投稿に失敗しました";
            exit();
        } 
        
    }

}
