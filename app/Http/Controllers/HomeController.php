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
