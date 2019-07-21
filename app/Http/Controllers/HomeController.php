<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $item = $request;     // 書籍情報取得
        return view('home', ['user' => $user, 'item' => $item]);
    }


    public function post(Request $request)
    {
        $user = Auth::user();
        $item = $request->all();
       
        // 画像をストレージに保存
        $thumbnail_url = $request->input('thumbnail') . '&printsec=frontcover&img=1&zoom=1&edge=curl&source=gbs_api'i;
        $img = file_get_contents($thumbnail_url);
        $id  = $request->input('google_books_id');
        file_put_contents("./books_thumnail/{$id}.jpg",$img);

        var_dump($item);
    }

}
